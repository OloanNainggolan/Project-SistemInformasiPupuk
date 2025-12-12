# Fitur Google Maps - Lokasi Pengambilan Pesanan

## 📋 Overview

Fitur ini menampilkan peta interaktif Google Maps untuk membantu user menemukan lokasi pengambilan terdekat ketika pesanan sudah berstatus **Ready/Siap Diambil**. Sistem akan secara otomatis menghitung jarak dan menampilkan titik pengambilan paling dekat dari lokasi user.

---

## ✨ Fitur Utama

### 1. **Deteksi Status Pesanan**
- Tombol "Lihat Lokasi Pengambilan" **hanya muncul** ketika status pesanan = `Ready`
- Otomatis parsing order number dari notifikasi

### 2. **Pencarian Titik Terdekat**
- Menggunakan **Haversine Formula** untuk menghitung jarak
- Menampilkan jarak dalam kilometer
- Sorting otomatis berdasarkan kedekatan

### 3. **Peta Interaktif**
- **Marker Biru**: Lokasi User
- **Marker Hijau (beranimasi)**: Titik pengambilan terdekat
- **Marker Oranye**: Titik pengambilan lainnya
- **Polyline Hijau**: Rute dari user ke titik terdekat
- Keterangan/Legend di pojok kanan atas

### 4. **Integrasi Google Maps**
- Tombol "Buka di Google Maps" → Navigasi langsung
- Tombol "Gunakan Lokasi Saya" → Otomatis detect GPS user
- Directions API untuk menampilkan rute

---

## 🗂️ Struktur File

### 1. **Model**
```
app/Models/PickupPoint.php
```
**Methods:**
- `distanceFrom($lat, $lng)` - Hitung jarak menggunakan Haversine
- `findNearest($lat, $lng)` - Cari titik terdekat

### 2. **Controller**
```
app/Http/Controllers/MapsController.php
```
**Methods:**
- `show(Request $request)` - Tampilkan halaman maps
- `geocode(Request $request)` - Convert alamat ke koordinat
- `pickupPoints()` - API: Get all pickup points
- `nearestPickup(Request $request)` - API: Get nearest point

### 3. **View**
```
resources/views/user/maps.blade.php
```
Halaman peta interaktif dengan Google Maps API

### 4. **Notification Detail** (Updated)
```
resources/views/user/notifications/show-notification.blade.php
```
Menambahkan tombol Maps ketika `$isReady && $orderNumber`

### 5. **Migration**
```
database/migrations/2025_12_12_064524_create_pickup_points_table.php
```

### 6. **Seeder**
```
database/seeders/PickupPointSeeder.php
```
Data 6 lokasi pengambilan di area Medan/Deli Serdang

---

## 🛣️ Routes

```php
// Maps & Pickup Location Routes (di web.php)
Route::get('/maps', [MapsController::class, 'show'])->name('maps.show');
Route::post('/api/geocode', [MapsController::class, 'geocode'])->name('api.geocode');
Route::get('/api/pickup-points', [MapsController::class, 'pickupPoints'])->name('api.pickup-points');
Route::post('/api/nearest-pickup', [MapsController::class, 'nearestPickup'])->name('api.nearest-pickup');
```

---

## 🗄️ Database Schema

### Tabel: `pickup_points`

| Kolom | Type | Deskripsi |
|-------|------|-----------|
| `id` | bigint unsigned | Primary key |
| `name` | varchar(255) | Nama lokasi (contoh: "Balai Desa Simalingkar A") |
| `address` | varchar(255) | Alamat lengkap |
| `latitude` | double(10,6) | Koordinat latitude |
| `longitude` | double(10,6) | Koordinat longitude |
| `created_at` | timestamp | Waktu dibuat |
| `updated_at` | timestamp | Waktu diupdate |

---

## 📍 Data Lokasi Pengambilan

### Lokasi yang Sudah Tersedia:

1. **Balai Desa Simalingkar A**
   - Alamat: Jl. Pasar VI Simalingkar, Kec. Pancur Batu, Kab. Deli Serdang
   - Koordinat: 3.5896, 98.7156

2. **Balai Desa Pancur Batu**
   - Alamat: Jl. Raya Pancur Batu, Kec. Pancur Batu, Kab. Deli Serdang
   - Koordinat: 3.5730, 98.7089

3. **Kantor Dinas Pertanian Deli Serdang**
   - Alamat: Jl. Karya Wisata, Medan
   - Koordinat: 3.5670, 98.6789

4. **Balai Desa Tanjung Morawa**
   - Alamat: Jl. Raya Tanjung Morawa, Kec. Tanjung Morawa, Kab. Deli Serdang
   - Koordinat: 3.5350, 98.7850

5. **Balai Desa Bangun Rejo**
   - Alamat: Jl. Raya Tanjung Morawa, Bangun Rejo, Kec. Tanjung Morawa
   - Koordinat: 3.5250, 98.8120

6. **Kantor Kecamatan Medan Selayang**
   - Alamat: Jl. K.L. Yos Sudarso, Medan Selayang
   - Koordinat: 3.6189, 98.6711

---

## 🔧 Konfigurasi

### 1. **Google Maps API Key**

Pastikan sudah ada di file `.env`:
```env
GOOGLE_MAPS_KEY=AIzaSyCwIXTWR4ExkFrEYJgN4kk0OCh7PNL7mxA
```

### 2. **API Services yang Dibutuhkan**

Aktifkan di Google Cloud Console:
- ✅ Maps JavaScript API
- ✅ Geocoding API
- ✅ Directions API
- ✅ Places API (optional)

---

## 🚀 Cara Menggunakan

### **Dari Sisi User:**

1. User menerima notifikasi bahwa pesanan sudah **Ready**
2. Buka detail notifikasi
3. Akan muncul tombol hijau **"Lihat Lokasi Pengambilan"**
4. Klik tombol tersebut
5. Halaman maps akan terbuka menampilkan:
   - Lokasi user (marker biru)
   - Lokasi terdekat (marker hijau beranimasi)
   - Jarak dalam kilometer
   - Rute perjalanan
6. Klik **"Buka di Google Maps"** untuk navigasi langsung
7. Atau klik **"Gunakan Lokasi Saya"** untuk update dengan GPS

### **Dari Sisi Admin:**

Ketika mengubah status pesanan ke "Ready", sistem otomatis:
1. Mengirim notifikasi ke user
2. Notifikasi berisi informasi bahwa pesanan siap diambil
3. Tombol maps otomatis muncul di detail notifikasi

---

## 🎨 UI/UX Features

### **Halaman Maps:**

1. **Header Section**
   - Judul: "Lokasi Pengambilan Pesanan"
   - Subtitle: "Temukan lokasi terdekat untuk mengambil pesanan Anda"
   - Back button

2. **Info Card** (Sidebar Kiri)
   - Detail pesanan (No. pesanan, Status, Jumlah)
   - Informasi lokasi terdekat
   - Badge jarak dengan ikon
   - Action buttons (Buka di Google Maps, Gunakan Lokasi Saya)

3. **Map Container** (Main Area)
   - Google Maps fullscreen
   - Loading overlay saat pertama load
   - Legend/Keterangan di pojok kanan atas

4. **Responsive Design**
   - Desktop: Grid 2 kolom (sidebar + map)
   - Mobile: Stack vertical

---

## 🔍 Algoritma Pencarian Terdekat

### **Haversine Formula:**

```php
public function distanceFrom($latitude, $longitude)
{
    $earthRadius = 6371; // Radius bumi dalam kilometer

    $latFrom = deg2rad($this->latitude);
    $lonFrom = deg2rad($this->longitude);
    $latTo = deg2rad($latitude);
    $lonTo = deg2rad($longitude);

    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;

    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

    return $angle * $earthRadius;
}
```

**Keunggulan:**
- Akurat untuk jarak pendek (<< 1000 km)
- Performa cepat (pure calculation, no API calls)
- Tidak memerlukan kredit Google Maps

---

## 📱 Fitur Geolocation

### **Browser Geolocation API:**

Ketika user klik "Gunakan Lokasi Saya":
```javascript
navigator.geolocation.getCurrentPosition(
    (position) => {
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;
        // Reload page dengan koordinat baru
        window.location.href = `...?order=...&lat=${lat}&lng=${lng}`;
    },
    (error) => {
        alert('Tidak dapat mengakses lokasi');
    }
);
```

**Requirements:**
- HTTPS (untuk production)
- User permission izin lokasi
- Modern browser support

---

## 🔐 Security & Validation

### **Controller Validation:**

```php
// Pastikan order milik user yang login
$order = Order::where('order_number', $orderNumber)
    ->where('user_id', auth()->id())
    ->first();

// Pastikan status Ready
if ($order->status !== 'Ready') {
    return redirect()->back()->with('error', 'Pesanan belum siap');
}
```

### **Route Protection:**

Semua route maps berada di dalam `auth` middleware group.

---

## 📊 Testing

### **Test Scenario:**

1. ✅ User dengan pesanan Ready dapat akses maps
2. ✅ User dengan pesanan non-Ready tidak bisa (redirect dengan error)
3. ✅ Sistem menghitung jarak dengan benar
4. ✅ Marker dan polyline ditampilkan dengan benar
5. ✅ Google Maps navigation link berfungsi
6. ✅ Geolocation berhasil update koordinat
7. ✅ Tombol hanya muncul di notifikasi dengan status Ready

---

## 🐛 Troubleshooting

### **Masalah Umum:**

1. **Maps tidak tampil:**
   - Cek Google Maps API Key di `.env`
   - Cek quota Google Cloud
   - Cek console browser untuk error

2. **Tombol tidak muncul:**
   - Pastikan status pesanan = "Ready"
   - Pastikan parsing order number berhasil
   - Cek variable `$isReady` di Blade

3. **Jarak tidak akurat:**
   - Periksa koordinat pickup points di database
   - Koordinat harus dalam format desimal, bukan DMS

4. **Geolocation error:**
   - Harus menggunakan HTTPS
   - User harus allow permission
   - Browser harus support Geolocation API

---

## 🔄 Update & Maintenance

### **Menambah Lokasi Pickup Baru:**

```php
// Di database atau via seeder
PickupPoint::create([
    'name' => 'Nama Lokasi Baru',
    'address' => 'Alamat Lengkap',
    'latitude' => 3.xxxx,
    'longitude' => 98.xxxx,
]);
```

### **Update Koordinat:**

Gunakan Google Maps untuk mendapatkan koordinat:
1. Buka Google Maps
2. Klik kanan di lokasi
3. Copy koordinat (format: lat, lng)

---

## 📈 Future Improvements

### **Possible Enhancements:**

1. **Multiple Marker Selection**
   - User bisa pilih lokasi lain jika lebih nyaman

2. **Real-time Traffic**
   - Tampilkan estimasi waktu tempuh dengan traffic

3. **Opening Hours**
   - Tambah kolom jam operasional di pickup_points

4. **QR Code**
   - Generate QR untuk pickup verification

5. **Notifikasi Jarak**
   - Alert jika user mendekati lokasi (radius 500m)

6. **History Tracking**
   - Simpan riwayat lokasi yang pernah dikunjungi

---

## 📞 Support

Jika ada pertanyaan atau masalah:
- Cek log: `storage/logs/laravel.log`
- Browser console untuk error JavaScript
- Network tab untuk API errors

---

**Last Updated:** 12 Desember 2025  
**Version:** 1.0.0  
**Status:** ✅ Production Ready
