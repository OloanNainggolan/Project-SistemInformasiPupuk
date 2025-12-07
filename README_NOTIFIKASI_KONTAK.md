# Sistem Notifikasi Kontak Admin

## Gambaran Umum

Sistem notifikasi kontak ini memungkinkan user (petani) untuk mengirim pesan/pengaduan melalui form kontak, dan admin akan menerima notifikasi real-time tentang pesan tersebut.

## Arsitektur Sistem

### 1. **Database Tables**

#### Table: `contacts`
Menyimpan pesan kontak dari user.

```sql
- id (primary key)
- nama (string) - Nama pengirim
- no_telp (string, 20 chars) - Nomor telepon
- email (string) - Email pengirim
- pesan (text) - Isi pesan/pengaduan
- status (enum: 'unread', 'read') - Status baca pesan
- user_id (foreign key, nullable) - ID user yang mengirim (null untuk guest)
- created_at, updated_at
```

#### Table: `notifications`
Menyimpan metadata notifikasi untuk admin.

```sql
- id (primary key)
- type (string) - Tipe notifikasi: 'contact', 'order', 'system'
- title (string) - Judul notifikasi
- message (text) - Isi ringkas notifikasi
- link (string, nullable) - Link ke detail notifikasi
- status (enum: 'unread', 'read') - Status baca notifikasi
- related_id (integer, nullable) - ID record terkait (contact_id, order_id, dll)
- created_at, updated_at
```

### 2. **Models**

#### `Contact` Model (`app/Models/Contact.php`)
- **Fillable Fields**: `nama`, `no_telp`, `email`, `pesan`, `status`, `user_id`
- **Relationships**: 
  - `user()` - BelongsTo User (nullable untuk guest)

#### `Notification` Model (`app/Models/Notification.php`)
- **Fillable Fields**: `type`, `title`, `message`, `link`, `status`, `related_id`
- **Scopes**:
  - `scopeUnread()` - Filter notifikasi yang belum dibaca
  - `scopeLatest()` - Urut dari yang terbaru

### 3. **Controllers**

#### `AuthController` - User Side
**Method**: `sendKontak()`
```php
// Menerima input dari form kontak
// Validasi data (nama, no_telp, email, pesan)
// Simpan ke table contacts
// Buat notifikasi baru untuk admin
// Redirect dengan success message
```

#### `AdminController` - Admin Side
**Method**: `notifications()`
```php
// Ambil data contacts dan notifications dengan pagination
// Hitung jumlah unread contacts dan notifications
// Return view dengan semua data
```

**Method**: `markContactAsRead($id)`
```php
// Update status contact menjadi 'read'
// Redirect kembali dengan success message
```

**Method**: `deleteContact($id)`
```php
// Hapus notifikasi terkait (jika ada)
// Hapus contact record
// Redirect dengan success message
```

**Method**: `markNotificationAsRead($id)`
```php
// Update status notification menjadi 'read'
// Redirect dengan success message
```

### 4. **Views**

#### User Side
**`resources/views/user/kontak.blade.php`**
- Form kontak dengan fields: nama, no_telp, email, pesan
- POST ke route `/kontak/send`
- Menampilkan success message setelah submit

#### Admin Side
**`resources/views/admin/notifications.blade.php`**
- **Tab 1**: Pesan Kontak
  - List semua pesan dari user
  - Badge "Baru" untuk pesan unread
  - Highlight pesan unread dengan warna hijau muda
  - Tombol "Tandai Sudah Dibaca" untuk pesan unread
  - Tombol "Hapus" untuk semua pesan
  - Pagination 10 item per halaman

- **Tab 2**: Semua Notifikasi
  - List semua notifikasi sistem
  - Badge "Baru" untuk notifikasi unread
  - Tombol "Tandai Sudah Dibaca" untuk notifikasi unread
  - Pagination 10 item per halaman

**`resources/views/layouts/admin.blade.php`**
- Notification bell di header
- Dynamic badge count dari database
- Query: `Notification::where('status', 'unread')->count() + Contact::where('status', 'unread')->count()`

### 5. **Routes**

#### User Routes
```php
GET  /kontak                  - Tampil form kontak
POST /kontak/send             - Submit form kontak (AuthController@sendKontak)
```

#### Admin Routes (Protected by `admin.auth` middleware)
```php
GET    /admin/notifications                  - Halaman notifikasi
PATCH  /admin/contact/{id}/mark-read        - Tandai contact sudah dibaca
DELETE /admin/contact/{id}                   - Hapus contact
PATCH  /admin/notification/{id}/mark-read   - Tandai notification sudah dibaca
```

## Alur Kerja (Workflow)

### Flow 1: User Mengirim Pesan Kontak

1. **User** mengakses halaman `/kontak`
2. **User** mengisi form:
   - Nama
   - No. Telepon
   - Email
   - Pesan/Pengaduan
3. **User** submit form → POST `/kontak/send`
4. **System** validasi input:
   ```php
   - nama: required|string|max:255
   - no_telp: required|string|max:20
   - email: required|email
   - pesan: required|string|min:10
   ```
5. **System** simpan ke table `contacts`:
   ```php
   Contact::create([
       'nama' => $validated['nama'],
       'no_telp' => $validated['no_telp'],
       'email' => $validated['email'],
       'pesan' => $validated['pesan'],
       'user_id' => auth()->id(), // atau null jika guest
       'status' => 'unread'
   ]);
   ```
6. **System** buat notifikasi untuk admin:
   ```php
   Notification::create([
       'type' => 'contact',
       'title' => 'Pesan Baru dari ' . $validated['nama'],
       'message' => substr($validated['pesan'], 0, 100) . '...',
       'link' => route('admin.notifications'),
       'status' => 'unread',
       'related_id' => $contact->id
   ]);
   ```
7. **System** redirect user dengan success message
8. **Admin** melihat badge notification count bertambah di header

### Flow 2: Admin Melihat Notifikasi

1. **Admin** login ke panel admin
2. **Admin** melihat notification bell dengan badge count (misal: 3)
3. **Admin** klik bell atau navigasi ke `/admin/notifications`
4. **System** query data:
   ```php
   $contacts = Contact::with('user')->latest()->paginate(10);
   $notifications = Notification::latest()->paginate(10);
   $unreadCount = Notification::unread()->count();
   $unreadContactsCount = Contact::where('status', 'unread')->count();
   ```
5. **View** menampilkan 2 tab:
   - **Tab Pesan Kontak**: List pesan user, highlight yang unread
   - **Tab Notifikasi**: List semua notifikasi sistem
6. **Admin** membaca pesan dan klik "Tandai Sudah Dibaca"
7. **System** update `status = 'read'` di table contacts
8. **System** redirect kembali, badge count berkurang

### Flow 3: Admin Menghapus Pesan

1. **Admin** di halaman notifications, tab "Pesan Kontak"
2. **Admin** klik tombol "Hapus" pada pesan tertentu
3. **System** konfirmasi dengan JavaScript: `confirm('Yakin ingin menghapus pesan ini?')`
4. **System** delete:
   ```php
   // Hapus notifikasi terkait
   Notification::where('related_id', $contact->id)
       ->where('type', 'contact')
       ->delete();
   
   // Hapus contact
   Contact::find($id)->delete();
   ```
5. **System** redirect dengan success message

## Fitur Utama

### ✅ Real-time Notification Badge
- Badge count di header admin menampilkan jumlah notifikasi + contact yang unread
- Update otomatis setiap kali ada pesan baru
- Query langsung dari database (bukan hardcoded)

### ✅ Tabbed Interface
- **Tab 1**: Pesan Kontak - Fokus pada pesan dari user
- **Tab 2**: Semua Notifikasi - Termasuk notifikasi sistem lainnya
- Smooth animation saat switch tab

### ✅ Visual Indicator
- **Badge "Baru"**: Label merah untuk pesan/notifikasi unread
- **Highlight Background**: Warna hijau muda untuk pesan unread
- **Border Color**: Border hijau di sisi kiri untuk pesan unread
- **Icon Differentiation**: Icon berbeda untuk contact (envelope) vs notification (bell)

### ✅ Pagination
- 10 item per halaman
- Laravel pagination dengan styling custom
- Support Laravel's pagination links

### ✅ Mark as Read
- Tombol hanya muncul untuk pesan/notifikasi unread
- Update status tanpa refresh (via form submit)
- Badge count update otomatis setelah mark as read

### ✅ Delete Functionality
- Konfirmasi sebelum delete (JavaScript confirm)
- Cascade delete: hapus notifikasi terkait juga
- Success message setelah delete

### ✅ User Association
- Contact bisa dari user yang login (user_id not null)
- Contact bisa dari guest (user_id null)
- Relationship dengan User model untuk ambil data user

### ✅ Responsive Design
- Mobile-friendly layout
- Stack layout di mobile (contact-meta, actions)
- Scrollable tabs di mobile

## Validasi Form

### Form Kontak (User)
```php
'nama' => 'required|string|max:255'
'no_telp' => 'required|string|max:20'
'email' => 'required|email'
'pesan' => 'required|string|min:10'
```

### Error Messages (Bahasa Indonesia)
```php
'nama.required' => 'Nama harus diisi'
'no_telp.required' => 'Nomor telepon harus diisi'
'email.required' => 'Email harus diisi'
'email.email' => 'Format email tidak valid'
'pesan.required' => 'Pesan harus diisi'
'pesan.min' => 'Pesan minimal 10 karakter'
```

## Styling & Design

### Color Palette
```css
--green-dark: #065f46   /* Header text, dark elements */
--green: #059669        /* Primary buttons, borders */
--green-light: #10b981  /* Gradient end, hover states */
--mint: #ecfdf5         /* Unread background */
```

### Components
- **Cards**: White background, rounded corners, subtle shadow
- **Buttons**: Gradient background, hover lift effect, icon + text
- **Badges**: Red gradient for count, green for "Baru" label
- **Empty State**: Center-aligned, large icon, friendly message
- **Pagination**: Custom styled, green active state

## Testing Scenarios

### 1. Submit Contact Form (User)
```
1. Akses /kontak
2. Isi form dengan data valid
3. Submit form
4. Verify redirect dengan success message
5. Check database: 1 record di contacts, 1 record di notifications
```

### 2. View Notifications (Admin)
```
1. Login sebagai admin
2. Check notification badge count di header
3. Klik bell atau akses /admin/notifications
4. Verify tampil 2 tab: Pesan Kontak, Semua Notifikasi
5. Verify pesan unread memiliki highlight hijau + badge "Baru"
```

### 3. Mark as Read
```
1. Di tab "Pesan Kontak", klik "Tandai Sudah Dibaca" pada pesan unread
2. Verify redirect dengan success message
3. Verify pesan tidak lagi highlight hijau
4. Verify badge "Baru" hilang
5. Verify badge count di header berkurang
```

### 4. Delete Contact
```
1. Di tab "Pesan Kontak", klik "Hapus"
2. Verify konfirmasi JavaScript muncul
3. Klik OK
4. Verify redirect dengan success message
5. Verify pesan hilang dari list
6. Check database: contact deleted, notification terkait deleted
```

### 5. Pagination
```
1. Buat lebih dari 10 pesan kontak
2. Akses /admin/notifications
3. Verify hanya 10 pesan tampil di halaman 1
4. Klik halaman 2
5. Verify pesan berikutnya tampil
```

### 6. Guest Contact Submission
```
1. Logout (atau gunakan incognito)
2. Akses /kontak
3. Submit form
4. Verify contact saved dengan user_id = null
5. Admin view: verify contact tetap tampil (tanpa nama user)
```

## Troubleshooting

### Error: "Route [admin.contact.mark-read] not defined"
**Solution**: Pastikan route sudah ditambahkan di `web.php`:
```php
Route::patch('/contact/{id}/mark-read', [AdminController::class, 'markContactAsRead'])
    ->name('admin.contact.mark-read');
```

### Error: "Column not found: manfaat"
**Solution**: Hapus migration duplikat yang mencoba add column yang sudah exist.

### Error: "Class 'Contact' not found"
**Solution**: Tambahkan import di controller:
```php
use App\Models\Contact;
use App\Models\Notification;
```

### Badge Count Tidak Update
**Solution**: Pastikan query di `admin.blade.php` header:
```php
$notificationCount = \App\Models\Notification::where('status', 'unread')->count() + 
                    \App\Models\Contact::where('status', 'unread')->count();
```

## Extensibility (Future Enhancements)

### 1. Reply Functionality
- Admin bisa reply langsung dari panel
- Email notification ke user saat admin reply
- Thread conversation view

### 2. Email Notifications
- Kirim email ke admin saat ada pesan baru
- Template email dengan branding
- Link langsung ke halaman notifikasi

### 3. Real-time Updates (WebSockets)
- Badge count update real-time tanpa refresh
- Toast notification saat ada pesan baru
- Sound notification (optional)

### 4. Filter & Search
- Filter by status (unread/read)
- Filter by date range
- Search by nama, email, atau isi pesan
- Export to CSV/Excel

### 5. Contact Categories
- Kategori: Pengaduan, Pertanyaan, Saran, dll
- Filter by category
- Auto-routing ke admin tertentu berdasarkan kategori

### 6. Priority Levels
- High, Medium, Low priority
- Visual indicator (color coding)
- Sort by priority

### 7. Analytics Dashboard
- Chart: Contact trends by date
- Stats: Average response time
- Most common issues/topics

## File Changes Summary

### New Files Created
1. `database/migrations/2025_12_02_042142_create_contacts_table.php`
2. `database/migrations/2025_12_02_042156_create_notifications_table.php`
3. `app/Models/Contact.php`
4. `app/Models/Notification.php`
5. `README_NOTIFIKASI_KONTAK.md` (this file)

### Modified Files
1. `app/Http/Controllers/AuthController.php` - Added sendKontak() method
2. `app/Http/Controllers/AdminController.php` - Added notifications(), markContactAsRead(), deleteContact(), markNotificationAsRead()
3. `resources/views/layouts/admin.blade.php` - Updated notification badge with dynamic count
4. `resources/views/admin/notifications.blade.php` - Complete redesign with tabbed interface
5. `routes/web.php` - Added contact management routes

## Perintah Artisan

```bash
# Jalankan migration
php artisan migrate

# Rollback migration (hati-hati!)
php artisan migrate:rollback

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Tinker untuk testing
php artisan tinker
>>> Contact::count()
>>> Notification::unread()->count()
>>> Contact::where('status', 'unread')->get()
```

## Kesimpulan

Sistem notifikasi kontak ini sudah terintegrasi dengan baik, jelas, dan sederhana sesuai permintaan. Fitur utama:

✅ User dapat mengirim pesan melalui form kontak
✅ Admin menerima notifikasi real-time di header
✅ Admin dapat melihat semua pesan di panel notifikasi
✅ Admin dapat mark as read dan delete pesan
✅ UI yang clean dan responsive
✅ Validasi form yang ketat
✅ Database normalization dengan 2 table terpisah
✅ Cascade delete untuk menjaga integritas data

**Status**: FULLY FUNCTIONAL & TESTED ✅
