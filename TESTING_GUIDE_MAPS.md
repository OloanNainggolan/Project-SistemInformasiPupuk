# 🎯 PANDUAN TESTING MAPS INTEGRATION - STEP BY STEP

## 🚀 QUICK START

**URL Test Page:**
```
http://127.0.0.1:8000/test-admin-maps
```

Buka URL di atas untuk akses semua test links dan checklist lengkap!

---

## 📍 TEST 1: Admin Detail Pesanan

### Langkah:
1. Login sebagai **Admin** (`admin` / `admin123`)
2. Buka salah satu link:
   - `http://127.0.0.1:8000/admin/orders/ORD-20251212-780630`
   - `http://127.0.0.1:8000/admin/orders/ORD-20251212-970F2F`

### Yang Harus Muncul:
```
┌─────────────────────────────────────────────┐
│  📍 Informasi Pengambilan Pesanan           │  ← Background hijau
│  (background: linear-gradient hijau)        │
│                                             │
│  ⏳ Mencari titik pengambilan terdekat...   │  ← Loading spinner
│     (hilang setelah 1-2 detik)              │
│                                             │
│  🏢 Titik Pengambilan Terdekat:             │
│     KAMPUS IT DEL                           │  ← Font besar, bold
│                                             │
│  📍 Alamat:                                 │
│     Sitoluama, Laguboti, Toba               │
│                                             │
│  🚗 Jarak dari Customer:                    │
│     0.46 km                                 │  ← Warna orange
│                                             │
│  💳 Metode Pembayaran:                      │
│     Tunai di Lokasi                         │
│                                             │
│  [🗺️ Buka Rute di Google Maps]            │  ← Tombol hijau
└─────────────────────────────────────────────┘
```

### Screenshot yang Diharapkan:
- Section hijau muncul setelah "Informasi Pelanggan"
- Sebelum "Produk yang Dipesan"
- **HANYA muncul jika status = Ready atau Completed**

---

## 📧 TEST 2: Notifikasi User

### Langkah:
1. **Trigger notifikasi Ready** (via Admin):
   - Login Admin → Dashboard → Pesanan
   - Pilih pesanan status "Processing"
   - Klik "Siap Diambil"
   - Confirm → pesanan jadi Ready
   - User otomatis dapat notifikasi

2. **Buka notifikasi** (via User):
   - Logout dari admin
   - Login sebagai user (`friskarevalinamanurung@gmail.com` / password)
   - Klik icon 🔔 Notifikasi (ada badge angka)
   - Klik notifikasi dengan judul "UPDATE STATUS PESANAN"

### Yang Harus Muncul di Detail Notifikasi:
```
━━━━━━━━━━━━━━━━━━━━━━━━━━
✅ UPDATE STATUS PESANAN ✅
━━━━━━━━━━━━━━━━━━━━━━━━━━

📋 No. Pesanan: #ORD-20251212-780630
📦 Produk: pupuk oloban
📊 Jumlah: 1 kg

🔄 Status Lama: ⏳ Menunggu Konfirmasi
✨ Status Baru: ✅ Siap Diambil

━━━━━━━━━━━━━━━━━━━━━━━━━━
✅ PESANAN SIAP DIAMBIL!
...
🗺️ LIHAT LOKASI PENGAMBILAN:
Klik notifikasi ini untuk melihat peta...

┌─────────────────────────────────────┐
│                                     │  ← Background gradient hijau
│          🗺️                         │  ← Icon 48px
│   Lihat Lokasi Pengambilan          │
│                                     │
│ ┌─────────────────────────────────┐ │
│ │ 🗺️ Buka Peta Lokasi Pengambilan│ │  ← Tombol hijau besar
│ └─────────────────────────────────┘ │
│                                     │
│ ℹ️ Sistem akan menunjukkan titik   │
│    pengambilan terdekat dengan     │
│    rute Google Maps                │
└─────────────────────────────────────┘
```

### Screenshot yang Diharapkan:
- Card hijau besar di bagian paling bawah detail notifikasi
- Tombol "Buka Peta Lokasi Pengambilan" dengan gradient hijau
- **HANYA muncul untuk notifikasi status Ready/Siap**

---

## 🗺️ TEST 3: Halaman Maps

### Langkah:
1. Dari notifikasi user, klik tombol "Buka Peta Lokasi Pengambilan"
2. **ATAU** langsung buka:
   ```
   http://127.0.0.1:8000/maps?order=ORD-20251212-780630
   ```

### Yang Harus Muncul:
```
┌─────────────────────────────────────────────────────┐
│ Pesanan #ORD-20251212-780630                        │
│                                                     │
│ ┌─────────────────────────────────────────────────┐ │
│ │                  GOOGLE MAPS                    │ │
│ │                                                 │ │
│ │  📍 (biru) ← Lokasi Anda                       │ │
│ │      \                                          │ │
│ │       \_____ (polyline abu-abu)                │ │
│ │             \                                   │ │
│ │              📍 (hijau, bouncing)              │ │
│ │                 ← Kampus IT Del (terdekat)     │ │
│ │                                                 │ │
│ │  📍 (orange) ← Mr.DIY Balige                   │ │
│ │  📍 (orange) ← RSUD Porsea                     │ │
│ │                                                 │ │
│ │  Legend (kiri bawah):                          │ │
│ │  • Biru = Lokasi Anda                          │ │
│ │  • Hijau = Terdekat                            │ │
│ │  • Orange = Lokasi Lain                        │ │
│ └─────────────────────────────────────────────────┘ │
│                                                     │
│ Titik Pengambilan Terdekat: KAMPUS IT DEL          │
│ Alamat: Sitoluama, Laguboti, Toba                  │
│ Jarak: 0.46 km                                      │
│                                                     │
│ [🗺️ Buka di Google Maps]                          │
│ [📍 Gunakan Lokasi Saya]                           │
└─────────────────────────────────────────────────────┘
```

### Screenshot yang Diharapkan:
- 4 marker total (1 biru, 1 hijau bouncing, 2 orange)
- Garis rute dari biru ke hijau
- Info card di bawah peta
- 2 tombol aksi

---

## 🐛 TROUBLESHOOTING GUIDE

### ❌ Admin: Section Pickup Tidak Muncul
**Kemungkinan:**
1. Pesanan bukan status Ready/Completed → **Ubah status dulu**
2. JavaScript error → **F12 Console**, screenshot error
3. API endpoint error → **Test di** `http://127.0.0.1:8000/test-api`

**Solusi:**
```bash
# Clear all caches
php artisan view:clear
php artisan config:clear
php artisan cache:clear
php artisan route:clear

# Hard refresh browser
Ctrl + Shift + R
```

### ❌ User: Tombol Maps Tidak Ada di Notifikasi
**Kemungkinan:**
1. Notifikasi bukan untuk pesanan Ready → **Cek judul notifikasi**
2. Browser cache → **Ctrl + Shift + Delete** → Clear browsing data
3. Order number tidak terdeteksi → **Periksa format order number di pesan**

**Solusi:**
```bash
# Buka di Incognito Mode
Ctrl + Shift + N

# Atau logout + login ulang
```

### ❌ Maps: Error 404 / 403 / 419
**Kemungkinan:**
- CSRF token expired → **Logout + Login ulang**
- Route tidak terdaftar → **php artisan route:list | grep maps**
- Order tidak valid → **Pastikan order_number benar**

**Solusi:**
```bash
# Verify routes
php artisan route:list | findstr "maps"

# Should show:
# GET  /maps
# POST /api/nearest-pickup
```

### ❌ Maps: Marker Tidak Muncul
**Kemungkinan:**
1. Google Maps API key invalid
2. Database pickup_points kosong
3. JavaScript error

**Solusi:**
```sql
-- Check pickup points
SELECT * FROM pickup_points;
-- Harus ada 3 rows
```

```bash
# Re-seed if empty
php artisan db:seed --class=PickupPointSeeder
```

---

## 📊 VERIFICATION COMMANDS

### Database Check:
```sql
-- Pickup points (harus 3)
SELECT COUNT(*) FROM pickup_points;

-- Ready orders (minimal 1)
SELECT order_number, status FROM orders WHERE status = 'Ready';

-- Recent notifications (harus ada yang mention "SIAP")
SELECT title, SUBSTRING(message, 1, 100) 
FROM notifications 
WHERE message LIKE '%SIAP%' 
ORDER BY created_at DESC 
LIMIT 5;
```

### Laravel Check:
```bash
# Routes
php artisan route:list | findstr "maps"

# Migration status
php artisan migrate:status

# Cache status
php artisan view:clear
php artisan config:clear
```

### Browser Check:
1. **F12** → Console → No errors
2. **F12** → Network → API calls sukses (200 OK)
3. **F12** → Application → Cookies ada XSRF-TOKEN

---

## ✅ SUCCESS INDICATORS

### Admin Detail:
- ✅ Section hijau "Informasi Pengambilan Pesanan" muncul
- ✅ Loading spinner → data pickup point
- ✅ Tombol "Buka Rute di Google Maps" clickable
- ✅ Jarak ditampilkan (contoh: 0.46 km)

### User Notification:
- ✅ Card hijau besar di bawah detail notifikasi
- ✅ Icon 🗺️ besar (48px)
- ✅ Tombol "Buka Peta Lokasi Pengambilan"
- ✅ Hint text jelas

### Maps Page:
- ✅ 4 markers (1 biru, 1 hijau bouncing, 2 orange)
- ✅ Polyline rute muncul
- ✅ Legend di kiri bawah
- ✅ Info card dengan jarak
- ✅ 2 tombol aksi berfungsi

---

**📞 Support:**
- Jika semua masih gagal, kirim screenshot:
  1. Browser console (F12 → Console)
  2. Halaman yang error
  3. Output `php artisan route:list | findstr maps`
  4. Output `SELECT * FROM pickup_points;`
