# Sistem Notifikasi 2 Arah (Admin ↔ User)

## 📋 Deskripsi

Sistem komunikasi 2 arah yang memungkinkan user mengirim pesan ke admin melalui form kontak, dan admin dapat membalas pesan tersebut. Semua data tersimpan di database dengan thread support untuk percakapan yang terstruktur.

## 🗄️ Database Structure

### Table: `messages`
```sql
CREATE TABLE messages (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    sender_type ENUM('user', 'admin') NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('unread', 'read') DEFAULT 'unread',
    reply_to BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (reply_to) REFERENCES messages(id) ON DELETE CASCADE
);
```

**Penjelasan Field:**
- `user_id`: ID user yang terlibat dalam percakapan
- `sender_type`: Pengirim pesan ('user' atau 'admin')
- `subject`: Subjek pesan
- `message`: Isi pesan
- `status`: Status baca ('unread' atau 'read')
- `reply_to`: ID pesan yang dibalas (untuk threading)

## 📂 File Structure

```
app/
├── Http/Controllers/
│   ├── Admin/
│   │   └── AdminNotificationController.php    # CRUD notifikasi admin
│   ├── AuthController.php                     # Updated: sendKontak()
│   └── UserNotificationController.php         # Notifikasi user
├── Models/
│   └── Message.php                            # Model dengan relationships

database/migrations/
└── 2025_12_04_101847_create_messages_table.php

resources/views/
├── admin/notifications/
│   ├── index.blade.php                        # List pesan dari user
│   └── show.blade.php                         # Detail + form balas
├── user/notifications/
│   └── index.blade.php                        # List notifikasi user
└── layouts/
    └── admin.blade.php                        # Updated: notification badge

routes/
└── web.php                                     # Routes untuk notifikasi
```

## 🔄 Alur Kerja

### 1. User Mengirim Pesan
1. User mengisi form kontak di `/kontak`
2. Submit form → `AuthController::sendKontak()`
3. Jika user login:
   - Simpan ke tabel `messages` dengan `sender_type = 'user'`
   - Status: `unread`
4. Jika user TIDAK login:
   - Simpan ke tabel `contacts` (sistem lama)

### 2. Admin Menerima Notifikasi
1. Notification bell di header menampilkan unread count
   ```php
   $unreadMessages = Message::fromUser()->unread()->count();
   ```
2. Admin buka `/admin/notifications`
3. Tampil list pesan dengan:
   - Avatar user
   - Subject + preview pesan
   - Badge "BARU" untuk unread
   - Unread dot dengan pulse animation

### 3. Admin Melihat Detail & Membalas
1. Admin klik pesan → `/admin/notifications/{id}`
2. Pesan ditandai sebagai `read` otomatis
3. Tampil thread percakapan (original message + replies)
4. Admin tulis balasan di form
5. Submit → `AdminNotificationController::reply()`
6. Balasan disimpan dengan:
   ```php
   'sender_type' => 'admin',
   'subject' => 'Re: ' . $originalMessage->subject,
   'reply_to' => $id,
   'status' => 'unread' // Unread untuk user
   ```

### 4. User Menerima Balasan
1. User login → notification badge muncul
2. User buka `/notifikasi`
3. Tampil list pesan dengan label "Balasan Admin"
4. User klik detail → tampil thread percakapan
5. Pesan ditandai sebagai `read`

## 🎨 Features

### Admin Side
- ✅ **List Pesan**: Pagination, search, filter
- ✅ **Unread Counter**: Real-time count di header bell
- ✅ **Detail Thread**: Original message + semua replies
- ✅ **Reply Form**: Textarea dengan validation
- ✅ **Delete Message**: Soft delete dengan confirmation
- ✅ **Auto Mark as Read**: Saat admin buka detail

### User Side
- ✅ **Send Message**: Via form kontak (jika login)
- ✅ **List Notifications**: Semua pesan + balasan admin
- ✅ **Unread Counter**: Badge di notification bell
- ✅ **Mark All as Read**: Tandai semua notifikasi dibaca
- ✅ **Thread View**: Percakapan terstruktur
- ✅ **Empty State**: Ketika belum ada notifikasi

## 🎯 Model Relationships

### Message Model
```php
class Message extends Model
{
    // Belongs to user
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    // Self-referencing: parent message
    public function replyToMessage() {
        return $this->belongsTo(Message::class, 'reply_to');
    }
    
    // Self-referencing: child messages (balasan)
    public function replies() {
        return $this->hasMany(Message::class, 'reply_to');
    }
    
    // Query Scopes
    public function scopeUnread($query) {
        return $query->where('status', 'unread');
    }
    
    public function scopeFromUser($query) {
        return $query->where('sender_type', 'user');
    }
    
    public function scopeFromAdmin($query) {
        return $query->where('sender_type', 'admin');
    }
}
```

## 🚀 Routes

### Admin Routes
```php
// Protected dengan middleware admin.auth
Route::get('/admin/notifications', [AdminNotificationController::class, 'index'])
    ->name('admin.notifications.index');

Route::get('/admin/notifications/{id}', [AdminNotificationController::class, 'show'])
    ->name('admin.notifications.show');

Route::post('/admin/notifications/{id}/reply', [AdminNotificationController::class, 'reply'])
    ->name('admin.notifications.reply');

Route::delete('/admin/notifications/{id}', [AdminNotificationController::class, 'destroy'])
    ->name('admin.notifications.destroy');
```

### User Routes
```php
// Protected dengan middleware auth
Route::get('/notifikasi', [UserNotificationController::class, 'index'])
    ->name('notifikasi');

Route::get('/notifikasi/{id}', [UserNotificationController::class, 'show'])
    ->name('user.notifications.show');

Route::post('/notifikasi/mark-all-read', [UserNotificationController::class, 'markAllAsRead'])
    ->name('user.notifications.markAllRead');
```

## 💾 Controller Methods

### AdminNotificationController
```php
index()     // List semua pesan dari user dengan pagination
show($id)   // Detail pesan + replies, mark as read
reply($id)  // Admin balas pesan user
destroy($id) // Hapus pesan
```

### UserNotificationController
```php
index()          // List semua notifikasi user
show($id)        // Detail notifikasi, mark as read
markAllAsRead()  // Tandai semua sebagai dibaca
```

### AuthController (Updated)
```php
sendKontak($request) {
    // Jika user login → simpan ke messages
    // Jika user TIDAK login → simpan ke contacts
}
```

## 🎨 UI Components

### Notification Badge (Header)
```blade
@php
    $unreadMessages = \App\Models\Message::fromUser()->unread()->count();
@endphp
@if($unreadMessages > 0)
    <span class="notification-badge">{{ $unreadMessages }}</span>
@endif
```

**Styling:**
- Background: Linear gradient merah (#ef4444 → #dc2626)
- Border: 2px solid white
- Animation: Pulse 2s infinite
- Min-width: 18px untuk angka 2 digit
- Font: 10px, bold, white

### Message Card (Unread)
```css
.message-card.unread {
    background: linear-gradient(135deg, #ecfdf5 0%, #ffffff 100%);
    border-left-color: #10b981;
}

.unread-dot {
    width: 12px;
    height: 12px;
    background: #ef4444;
    border-radius: 50%;
    animation: pulse 2s infinite;
}
```

### Avatar Styling
```css
/* User Avatar */
.sender-avatar.user {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    box-shadow: 0 3px 10px rgba(16, 185, 129, 0.3);
}

/* Admin Avatar */
.sender-avatar.admin {
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    box-shadow: 0 3px 10px rgba(99, 102, 241, 0.3);
}
```

## 🔍 Testing Scenarios

### 1. User Kirim Pesan
```bash
# Login sebagai user
POST /kontak/send
Body: nama, no_telp, email, pesan

# Cek database
SELECT * FROM messages WHERE sender_type = 'user' ORDER BY created_at DESC LIMIT 1;
```

### 2. Admin Terima & Balas
```bash
# Login sebagai admin
GET /admin/notifications
# Cek unread count di header

GET /admin/notifications/{id}
# Pesan otomatis berubah status jadi 'read'

POST /admin/notifications/{id}/reply
Body: message
# Balasan tersimpan dengan sender_type = 'admin'
```

### 3. User Lihat Balasan
```bash
# Login sebagai user
GET /notifikasi
# Tampil balasan admin dengan badge "BARU"

GET /notifikasi/{id}
# Balasan ditandai sebagai 'read'
```

## 📊 Database Queries

### Count Unread untuk Admin
```php
$unreadCount = Message::fromUser()->unread()->count();
```

### Count Unread untuk User
```php
$unreadCount = Message::where('user_id', Auth::id())
    ->fromAdmin()
    ->unread()
    ->count();
```

### Get Thread Percakapan
```php
$message = Message::with(['user', 'replies.user', 'replyToMessage'])
    ->findOrFail($id);
```

## 🔒 Security

1. **Middleware Protection**
   - Admin routes: `admin.auth`
   - User routes: `auth`

2. **Authorization**
   - User hanya bisa lihat pesannya sendiri:
     ```php
     Message::where('user_id', Auth::id())->findOrFail($id);
     ```

3. **Validation**
   - Subject: required
   - Message: required, min 10 characters
   - Validated di controller sebelum save

4. **Cascade Delete**
   - Jika user dihapus → semua messages ikut terhapus
   - Jika parent message dihapus → replies ikut terhapus

## 🎯 Perbedaan dengan Sistem Lama

### Sistem Lama (Table: `contacts`, `notifications`)
- ❌ Tidak ada threading (percakapan tidak terstruktur)
- ❌ Admin tidak bisa balas langsung
- ❌ User tidak menerima notifikasi balasan
- ❌ Dua tabel terpisah (sulit di-maintain)

### Sistem Baru (Table: `messages`)
- ✅ Threading support (reply_to field)
- ✅ Admin bisa balas langsung ke user
- ✅ User terima notifikasi balasan admin
- ✅ Satu tabel untuk semua komunikasi
- ✅ Real-time unread counter
- ✅ Auto mark as read

## 📝 Migration Notes

Jika ada data lama di `contacts` atau `notifications`, **JANGAN HAPUS**. Sistem baru akan:
1. Berjalan paralel dengan sistem lama
2. User login → gunakan `messages` table
3. User TIDAK login → gunakan `contacts` table (fallback)

## 🚀 Future Enhancements

- [ ] Real-time notification dengan WebSocket/Pusher
- [ ] Email notification ketika ada pesan baru
- [ ] File attachment support
- [ ] Search & filter di list messages
- [ ] Export conversation ke PDF
- [ ] Admin assign message ke staff tertentu

## 📞 Endpoints Summary

| Method | Route | Controller | Description |
|--------|-------|------------|-------------|
| GET | `/admin/notifications` | AdminNotificationController@index | List pesan dari user |
| GET | `/admin/notifications/{id}` | AdminNotificationController@show | Detail pesan + form balas |
| POST | `/admin/notifications/{id}/reply` | AdminNotificationController@reply | Admin balas pesan |
| DELETE | `/admin/notifications/{id}` | AdminNotificationController@destroy | Hapus pesan |
| GET | `/notifikasi` | UserNotificationController@index | List notifikasi user |
| GET | `/notifikasi/{id}` | UserNotificationController@show | Detail notifikasi |
| POST | `/notifikasi/mark-all-read` | UserNotificationController@markAllAsRead | Tandai semua dibaca |
| POST | `/kontak/send` | AuthController@sendKontak | User kirim pesan |

---

**Dokumentasi dibuat:** 4 Desember 2025  
**Laravel Version:** 12.28.1  
**PHP Version:** 8.4.1  
**Database:** MySQL (via Laragon)
