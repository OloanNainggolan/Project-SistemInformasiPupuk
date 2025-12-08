# Integrasi Data Real User Dashboard

## 📋 Perubahan yang Dilakukan

### 1. **Profil User - Statistik Real dari Database**

#### File: `app/Http/Controllers/AuthController.php`
Method `showProfil()` diperbaiki untuk mengambil data REAL dari database:

```php
public function showProfil()
{
    $user = auth()->user();
    
    // Ambil pesanan user dengan relasi product
    $orders = \App\Models\Order::with(['user', 'product'])
        ->where('user_id', $user->id)
        ->where('confirmed_by_user', true)
        ->orderBy('created_at', 'desc')
        ->get();
    
    // Hitung statistik REAL dari database
    $totalPesanan = $orders->count();
    
    // Hitung pupuk/bibit yang SUDAH DITERIMA (Completed atau Ready)
    $pupukDiterima = 0;
    $bibitDiterima = 0;
    $totalPenghematan = 0;
    
    foreach ($orders as $order) {
        // Total penghematan dari semua pesanan
        $totalPenghematan += $order->savings ?? 0;
        
        // Hitung pupuk/bibit yang sudah selesai
        if (in_array($order->status, ['Completed', 'Ready for Pickup'])) {
            if ($order->product) {
                $qty = $order->quantity ?? 0;
                
                if ($order->product->tipe_produk === 'pupuk') {
                    $pupukDiterima += $qty;
                } elseif ($order->product->tipe_produk === 'bibit') {
                    $bibitDiterima += $qty;
                }
            }
        }
    }
    
    return view('user.ProfilUser', compact(
        'orders',
        'totalPesanan',
        'pupukDiterima',
        'bibitDiterima',
        'totalPenghematan'
    ));
}
```

**Penjelasan:**
- ✅ Data diambil dari tabel `orders` dengan relasi `product`
- ✅ Hanya pesanan yang `confirmed_by_user = true`
- ✅ Pupuk/bibit dihitung HANYA jika status `Completed` atau `Ready for Pickup`
- ✅ Total penghematan dari field `savings` di tabel orders

### 2. **View Profil - Statistik Cards**

#### File: `resources/views/user/ProfilUser.blade.php`

**Sebelum (Hardcoded):**
```blade
<div class="stat-number">24</div>
<div class="stat-label">Total Pesanan</div>
```

**Sesudah (Dynamic):**
```blade
<div class="stat-number">{{ $totalPesanan }}</div>
<div class="stat-label">Total Pesanan</div>
```

**Format Display:**
- **Total Pesanan**: Angka langsung (contoh: 2)
- **Pupuk Diterima**: 
  - Jika > 1000 Kg → Ton (contoh: 2.5 Ton)
  - Jika < 1000 Kg → Kg (contoh: 500 Kg)
- **Bibit Diterima**: Kg (contoh: 125 Kg)
- **Total Penghematan**: 
  - Jika >= 1 juta → Juta (contoh: 2.4 Jt)
  - Jika < 1 juta → Rupiah (contoh: Rp 850.000)

### 3. **Riwayat Pesanan - Data Real**

#### File: `resources/views/user/ProfilUser.blade.php`

**Sebelum:** Hardcoded 3 pesanan dummy

**Sesudah:** Loop dari database
```blade
@forelse($orders->take(6) as $order)
<div class="order-card">
    <div class="order-header">
        <div class="order-id-badge">{{ $order->order_number }}</div>
        <div class="order-status {{ strtolower(str_replace(' ', '-', $order->status)) }}">
            @if($order->status === 'Completed')
                <i class="fas fa-check-circle"></i> Selesai
            @elseif($order->status === 'Ready for Pickup')
                <i class="fas fa-box-open"></i> Siap Diambil
            @elseif($order->status === 'Processing')
                <i class="fas fa-spinner"></i> Diproses
            @elseif($order->status === 'Pending')
                <i class="fas fa-clock"></i> Menunggu
            @elseif($order->status === 'Rejected')
                <i class="fas fa-times-circle"></i> Ditolak
            @endif
        </div>
    </div>
    <div class="order-body">
        <div class="product-info">
            <div class="product-icon {{ $order->product->tipe_produk ?? 'pupuk' }}">
                @if(isset($order->product->tipe_produk) && $order->product->tipe_produk === 'bibit')
                    <i class="fas fa-seedling"></i>
                @else
                    <i class="fas fa-box"></i>
                @endif
            </div>
            <div>
                <h4>{{ $order->product->nama_produk ?? 'Produk Tidak Tersedia' }}</h4>
                <p>{{ $order->quantity }} Kg • {{ $order->product->kategori ?? 'Subsidi Pemerintah' }}</p>
            </div>
        </div>
        <div class="order-details">
            <div class="detail-item">
                <i class="fas fa-calendar"></i>
                <span>{{ $order->created_at->format('d M Y') }}</span>
            </div>
            <div class="detail-item">
                <i class="fas fa-money-bill-wave"></i>
                <span class="price">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>
        @if($order->status === 'Completed' || $order->status === 'Ready for Pickup')
        <div class="detail-item savings">
            <i class="fas fa-piggy-bank"></i>
            <span class="savings-text">Hemat: Rp {{ number_format($order->savings ?? 0, 0, ',', '.') }}</span>
        </div>
        @endif
    </div>
</div>
@empty
<div class="empty-orders">
    <i class="fas fa-inbox"></i>
    <p>Belum ada riwayat pesanan</p>
    <a href="{{ route('pupuk-bibit') }}" class="btn-browse">
        <i class="fas fa-shopping-cart"></i> Mulai Belanja
    </a>
</div>
@endforelse
```

**Fitur:**
- ✅ Tampilkan 6 pesanan terbaru
- ✅ Status badge dengan warna berbeda:
  - Completed: Hijau
  - Ready for Pickup: Biru
  - Processing: Kuning
  - Pending: Orange
  - Rejected: Merah
- ✅ Icon berbeda untuk pupuk dan bibit
- ✅ Tampilkan penghematan hanya untuk pesanan selesai
- ✅ Empty state jika belum ada pesanan

### 4. **Status Badge Styling**

```css
.order-status.completed {
    background: #c8e6c9;
    color: #2e7d32;
}

.order-status.ready-for-pickup {
    background: #b3e5fc;
    color: #0277bd;
}

.order-status.processing {
    background: #fff9c4;
    color: #f57f17;
}

.order-status.pending {
    background: #ffecb3;
    color: #ff6f00;
}

.order-status.rejected {
    background: #ffcdd2;
    color: #c62828;
}
```

### 5. **Notifikasi User - Data Real**

#### File: `resources/views/layouts/user.blade.php`

**Header Notification Badge:**
```blade
@php
    $unreadMessages = \App\Models\Message::where('user_id', Auth::id())
        ->fromAdmin()
        ->unread()
        ->count();
@endphp
@if($unreadMessages > 0)
    <span class="notification-badge">{{ $unreadMessages }}</span>
@endif
```

**Avatar dengan Initial:**
```blade
<div class="profile-avatar">
    @if(auth()->user()->foto)
        <img src="{{ asset(auth()->user()->foto) }}" alt="Profile">
    @else
        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
    @endif
</div>
```

**Fitur:**
- ✅ Badge hanya muncul jika ada pesan unread
- ✅ Avatar menampilkan foto user ATAU initial huruf pertama nama
- ✅ Gradient background untuk avatar

### 6. **Detail Notifikasi User**

#### File: `resources/views/user/notifications/show.blade.php` (BARU)

View untuk menampilkan detail pesan dengan thread balasan:

```blade
<!-- Original Message -->
<div class="thread-message original">
    <div class="message-header">
        <div class="sender-info">
            <div class="sender-avatar {{ $message->sender_type === 'admin' ? 'admin' : 'user' }}">
                @if($message->sender_type === 'admin')
                    A
                @else
                    {{ strtoupper(substr($message->user->name ?? 'U', 0, 1)) }}
                @endif
            </div>
            <div>
                <div class="sender-name">
                    {{ $message->sender_type === 'admin' ? 'Admin' : $message->user->name }}
                </div>
                <div class="sender-meta">
                    <span><i class="fas fa-clock"></i> {{ $message->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="message-subject">
        <i class="fas fa-envelope"></i>
        {{ $message->subject }}
    </div>
    <div class="message-body">
        {{ $message->message }}
    </div>
</div>

<!-- Replies -->
@foreach($message->replies as $reply)
<div class="thread-message reply">
    <!-- Similar structure for replies -->
</div>
@endforeach
```

**Fitur:**
- ✅ Thread percakapan (original + semua replies)
- ✅ Avatar berbeda untuk user dan admin
- ✅ Admin avatar: Gradient biru-purple
- ✅ User avatar: Gradient hijau

## 🔄 Alur Data

### 1. User Melakukan Pesanan
```
User → Form Pesanan → PupukBibitController::konfirmasiPesanan()
↓
Simpan ke tabel orders dengan:
- user_id (dari Auth::id())
- product_id (dari produk dipilih)
- quantity, total_price, savings
- status: 'Pending'
- confirmed_by_user: true
```

### 2. Admin Update Status
```
Admin → Halaman Orders → Update Status
↓
AdminOrderController::updateStatus()
↓
Update field 'status' di tabel orders
(Pending → Processing → Ready → Completed)
```

### 3. User Lihat Profil
```
User → /profil → AuthController::showProfil()
↓
Query database:
- Total pesanan (count)
- Pupuk diterima (sum qty WHERE status IN ['Completed', 'Ready'])
- Bibit diterima (sum qty WHERE status IN ['Completed', 'Ready'])
- Total penghematan (sum savings)
↓
Tampilkan di statistik cards
```

### 4. User Lihat Riwayat
```
User → Scroll ke bawah di /profil
↓
Loop $orders->take(6)
↓
Tampilkan:
- Order number
- Status (dengan warna badge)
- Nama produk
- Quantity
- Total price
- Tanggal
- Penghematan (jika completed)
```

## 📊 Database Queries

### Query Statistik Profil
```php
// Total Pesanan
$totalPesanan = Order::where('user_id', Auth::id())
    ->where('confirmed_by_user', true)
    ->count();

// Pupuk Diterima
$pupukDiterima = Order::where('user_id', Auth::id())
    ->whereHas('product', function($q) {
        $q->where('tipe_produk', 'pupuk');
    })
    ->whereIn('status', ['Completed', 'Ready for Pickup'])
    ->sum('quantity');

// Bibit Diterima
$bibitDiterima = Order::where('user_id', Auth::id())
    ->whereHas('product', function($q) {
        $q->where('tipe_produk', 'bibit');
    })
    ->whereIn('status', ['Completed', 'Ready for Pickup'])
    ->sum('quantity');

// Total Penghematan
$totalPenghematan = Order::where('user_id', Auth::id())
    ->where('confirmed_by_user', true)
    ->sum('savings');
```

### Query Riwayat Pesanan
```php
$orders = Order::with(['user', 'product'])
    ->where('user_id', Auth::id())
    ->where('confirmed_by_user', true)
    ->orderBy('created_at', 'desc')
    ->get();
```

### Query Notifikasi
```php
// Unread Count
$unreadMessages = Message::where('user_id', Auth::id())
    ->where('sender_type', 'admin')
    ->where('status', 'unread')
    ->count();

// List Messages
$messages = Message::where('user_id', Auth::id())
    ->with(['replyToMessage', 'replies'])
    ->orderBy('created_at', 'desc')
    ->paginate(15);
```

## 🎨 UI/UX Improvements

### 1. **Status Badge Colors**
- **Completed**: Hijau (#c8e6c9 bg, #2e7d32 text)
- **Ready for Pickup**: Biru (#b3e5fc bg, #0277bd text)
- **Processing**: Kuning (#fff9c4 bg, #f57f17 text)
- **Pending**: Orange (#ffecb3 bg, #ff6f00 text)
- **Rejected**: Merah (#ffcdd2 bg, #c62828 text)

### 2. **Avatar Gradients**
- **User**: Linear gradient hijau (#10b981 → #059669)
- **Admin**: Linear gradient biru-purple (#6366f1 → #4f46e5)

### 3. **Empty State**
- Icon: Inbox (abu-abu)
- Text: "Belum ada riwayat pesanan"
- Button: "Mulai Belanja" → Link ke halaman pupuk-bibit

### 4. **Savings Display**
- Hanya tampil untuk status Completed atau Ready
- Warna hijau (#10b981)
- Format: "Hemat: Rp 50.000"

## 🔒 Security & Validation

### 1. **Authorization**
```php
// User hanya bisa lihat pesanannya sendiri
Order::where('user_id', Auth::id())

// Message hanya bisa diakses oleh user terkait
Message::where('user_id', Auth::id())->findOrFail($id)
```

### 2. **Middleware Protection**
```php
// routes/web.php
Route::middleware('auth')->group(function () {
    Route::get('/profil', [AuthController::class, 'showProfil']);
    Route::get('/notifikasi', [UserNotificationController::class, 'index']);
    Route::get('/notifikasi/{id}', [UserNotificationController::class, 'show']);
});
```

## 🚀 Testing Scenarios

### 1. **Test Profil dengan Data Kosong**
```
Login user baru (tidak ada pesanan)
→ Total Pesanan: 0
→ Pupuk Diterima: 0 Kg
→ Bibit Diterima: 0 Kg
→ Total Penghematan: Rp 0
→ Riwayat: Empty state "Belum ada riwayat pesanan"
```

### 2. **Test Profil dengan Pesanan Pending**
```
User punya 2 pesanan status Pending
→ Total Pesanan: 2
→ Pupuk Diterima: 0 Kg (karena belum Completed)
→ Bibit Diterima: 0 Kg
→ Total Penghematan: Rp XXX (dari savings)
→ Riwayat: 2 kartu dengan status badge kuning "Menunggu"
```

### 3. **Test Profil dengan Pesanan Completed**
```
User punya 2 pesanan Completed (1 pupuk 50Kg, 1 bibit 10Kg)
→ Total Pesanan: 2
→ Pupuk Diterima: 50 Kg
→ Bibit Diterima: 10 Kg
→ Total Penghematan: Rp XXX
→ Riwayat: 2 kartu dengan status badge hijau "Selesai"
→ Tampilkan "Hemat: Rp XXX"
```

### 4. **Test Notifikasi**
```
Admin balas pesan user
→ Badge notifikasi muncul dengan angka
→ Klik notifikasi → Lihat list pesan
→ Pesan dari admin ada badge "BARU"
→ Klik detail → Tampil thread percakapan
→ Pesan otomatis mark as read
```

## 📝 Summary

**File yang Dimodifikasi:**
1. ✅ `routes/web.php` - Update route profil
2. ✅ `app/Http/Controllers/AuthController.php` - Fix showProfil() method
3. ✅ `resources/views/user/ProfilUser.blade.php` - Statistik & riwayat real
4. ✅ `resources/views/layouts/user.blade.php` - Notification badge & avatar
5. ✅ `resources/views/user/notifications/show.blade.php` - Detail pesan (BARU)

**Fitur yang Ditambahkan:**
- ✅ Statistik profil dari database real
- ✅ Riwayat pesanan dengan status update dari admin
- ✅ Notification badge real-time unread count
- ✅ Avatar dengan initial jika tidak ada foto
- ✅ Detail pesan dengan thread percakapan
- ✅ Empty state untuk riwayat kosong
- ✅ Status badge dengan warna berbeda
- ✅ Penghematan hanya tampil untuk pesanan selesai

**Data Flow:**
```
User Order → Database → Admin Update Status → Database → User Profil View
User Message → Database → Admin Reply → Database → User Notification View
```

---

**Dokumentasi dibuat:** 4 Desember 2025  
**Laravel Version:** 12.28.1  
**Tested with:** Real database queries, Eloquent relationships
