# 📱 Panduan WhatsApp Otomatis untuk Konfirmasi Pesanan

## ✅ Status Setup

**WhatsApp API sudah AKTIF dan TERHUBUNG!**

- ✅ Token Fonnte terkonfigurasi
- ✅ Device WhatsApp connected
- ✅ Test berhasil mengirim pesan
- ✅ Quota tersedia: 997/1000

---

## 🎯 Fitur WhatsApp Otomatis

### 1. **Konfirmasi Pesanan Baru** 
Saat user membuat order baru → WhatsApp otomatis terkirim ke nomor HP user

**Isi pesan:**
- Detail pesanan (nomor order, tanggal)
- Produk yang dipesan (nama, jumlah, harga)
- Total pembayaran
- Lokasi balai desa
- Status pesanan

### 2. **Update Status Pesanan**
Saat admin mengubah status order → WhatsApp notifikasi otomatis terkirim

**Status flow:**
```
Pending → Processing → Ready → Completed
```

**Isi pesan:**
- Nomor order
- Status lama → Status baru
- Informasi tambahan sesuai status

---

## 🚀 Cara Kerja Otomatis

### A. Via API (Production)

**Endpoint:** `POST /api/v1/orders`

**Contoh Request (Postman):**
```json
{
    "user_id": 1,
    "village_office": "Balai Desa Pematang Siantar",
    "items": [
        {
            "product_id": 1,
            "product_name": "Jagung",
            "quantity": 10,
            "price": 20000,
            "subtotal": 200000
        }
    ],
    "total_amount": 200000,
    "status": "Pending"
}
```

**Response:**
```json
{
    "success": true,
    "order": {
        "order_number": "ORD-2025-001",
        "user_id": 1,
        "total_amount": 200000,
        "status": "Pending"
    },
    "whatsapp_sent": true,
    "whatsapp_message": "WhatsApp message sent successfully"
}
```

**✨ WhatsApp otomatis terkirim ke nomor HP user!**

---

### B. Update Status Order

**Endpoint:** `PATCH /api/v1/orders/{order_number}/status`

**Contoh Request:**
```json
{
    "status": "Processing"
}
```

**✨ WhatsApp notifikasi update status otomatis terkirim!**

---

## 🧪 Testing

### Test 1: Konfirmasi Pesanan Baru

```bash
php test-order-whatsapp.php
```

**Hasil:**
- ✅ Membuat order baru otomatis
- ✅ Mengirim WhatsApp ke nomor user
- ✅ Menampilkan detail response

**Output:**
```
✅ SUCCESS! WhatsApp konfirmasi pesanan terkirim!
Order Number: ORD-2025-001
User: Oloan Nainggolan
HP: 6287773156762
```

---

### Test 2: Update Status

```bash
php test-status-update.php
```

**Hasil:**
- ✅ Update status order otomatis (Pending → Processing)
- ✅ Mengirim WhatsApp notifikasi update
- ✅ Menampilkan detail response

**Output:**
```
✅ SUCCESS! WhatsApp notifikasi update status terkirim!
Status: Pending ➜ Processing
HP: 6287773156762
```

---

### Test 3: Koneksi Dasar

```bash
php test-whatsapp.php
```

Test koneksi Fonnte tanpa membuat order.

---

## 📋 Syarat User Menerima WhatsApp

### ✅ User HARUS punya nomor HP di database

**Cek user dengan nomor HP:**
```bash
php check-users-hp.php
```

**Format nomor HP yang benar:**
- ✅ `6287773156762` (format internasional Indonesia)
- ✅ `628123456789` (diawali 62, tanpa 0)
- ❌ `087773156762` (jangan pakai 0)
- ❌ `+6287773156762` (jangan pakai +)

**Update nomor HP user:**
```sql
UPDATE users SET no_telp='6287773156762' WHERE id=1;
```

Atau via Tinker:
```bash
php artisan tinker
```
```php
$user = User::find(1);
$user->no_telp = '6287773156762';
$user->save();
```

---

## 📱 Contoh Pesan WhatsApp

### Konfirmasi Pesanan Baru:

```
🌾 Pesanan Pupuk & Bibit Bersubsidi

Halo Oloan Nainggolan,

Terima kasih telah melakukan pemesanan! ✅

📋 Detail Pesanan:
━━━━━━━━━━━━━━━━━━━━
📦 No. Pesanan: ORD-2025-001
📅 Tanggal: 14 Dec 2025, 15:30
🏛️ Balai Desa: Balai Desa Pematang Siantar

🛒 Produk yang Dipesan:
━━━━━━━━━━━━━━━━━━━━
• Jagung
  Jumlah: 10 unit
  Harga: Rp 20.000
  Subtotal: Rp 200.000

━━━━━━━━━━━━━━━━━━━━
💰 Total Pembayaran: Rp 200.000

📍 Status: ⏳ Pending

ℹ️ Informasi:
• Pesanan Anda sedang diproses oleh admin
• Anda akan menerima notifikasi lebih lanjut
• Cek status pesanan di dashboard

📱 Hubungi Kami:
Website: http://127.0.0.1:8000

_Pesan otomatis dari Sistem Informasi Pupuk & Bibit Bersubsidi_
```

---

### Update Status:

```
📬 Update Pesanan #ORD-2025-001

Status Diperbarui:
⏳ PENDING ➜ 🔄 PROCESSING

Halo Oloan Nainggolan,

Pesanan Anda sedang diproses! 🔄

💰 Total: Rp 200.000
🏛️ Balai Desa: Balai Desa Pematang Siantar

ℹ️ Informasi:
• Pesanan sedang dalam proses verifikasi
• Mohon tunggu konfirmasi selanjutnya
• Cek status terbaru di dashboard

Terima kasih atas kesabaran Anda! 🙏

_Pesan otomatis dari Sistem Informasi Pupuk & Bibit Bersubsidi_
```

---

## 🔧 Troubleshooting

### ❌ WhatsApp tidak terkirim

**Penyebab & Solusi:**

1. **User tidak punya nomor HP**
   ```bash
   # Cek user
   php check-users-hp.php
   
   # Tambah nomor HP
   UPDATE users SET no_telp='628xxxx' WHERE id=1;
   ```

2. **Format nomor salah**
   - Harus format: `628xxx` (tanpa 0 atau +)
   - Sistem auto-convert, tapi lebih baik simpan format benar

3. **Token Fonnte expired**
   - Login ke dashboard Fonnte
   - Copy token baru
   - Update `.env`: `FONNTE_API_TOKEN=new_token`
   - Jalankan: `php artisan config:cache`

4. **Device WhatsApp disconnected**
   - Buka dashboard Fonnte
   - Menu "Device" → cek status
   - Jika "Disconnected", scan ulang QR Code

5. **Quota habis**
   - Cek dashboard Fonnte → Quota
   - Top up jika quota < 10
   - Harga: cek di https://fonnte.com/pricing

---

## 📊 Monitoring

### Cek Log WhatsApp

**File:** `storage/logs/laravel.log`

**Filter log WhatsApp:**
```bash
# Windows PowerShell
Get-Content storage/logs/laravel.log | Select-String "WhatsApp"

# Linux/Mac
tail -f storage/logs/laravel.log | grep WhatsApp
```

**Contoh log sukses:**
```
[2025-12-14 15:30:45] local.INFO: WhatsApp notification sent for order {"order_number":"ORD-2025-001","user_id":1}
```

**Contoh log gagal:**
```
[2025-12-14 15:30:45] local.WARNING: WhatsApp message failed {"phone":"628xxx","response":{"reason":"Invalid token"}}
```

---

### Cek Quota Fonnte

```bash
php test-whatsapp.php
```

Output akan menampilkan sisa quota:
```json
"quota": {
    "remaining": 997,
    "used": 3
}
```

---

## 🎯 Alur Lengkap

### User Memesan Produk:

1. **User buka aplikasi** → Login
2. **User pilih produk** → Tambah ke keranjang
3. **User checkout** → Klik "Pesan Sekarang"
4. **Sistem buat order** → Save ke database
5. **✨ WhatsApp otomatis terkirim** → Konfirmasi pesanan
6. **User terima WA** → Buka HP, lihat detail pesanan

### Admin Update Status:

1. **Admin buka dashboard** → Menu "Kelola Pesanan"
2. **Admin pilih order** → Klik "Update Status"
3. **Admin ubah status** → Pending → Processing
4. **Sistem save perubahan** → Update database
5. **✨ WhatsApp otomatis terkirim** → Notifikasi update
6. **User terima WA** → Tahu status terbaru pesanan

---

## ⚙️ Konfigurasi

### File `.env`

```env
# WhatsApp Configuration (Fonnte)
FONNTE_API_TOKEN=cLHsdazxqiJJQkEEUP7Y
FONNTE_API_URL=https://api.fonnte.com/send
WHATSAPP_ENABLED=true
```

### File `config/services.php`

```php
'fonnte' => [
    'token' => env('FONNTE_API_TOKEN'),
    'url' => env('FONNTE_API_URL', 'https://api.fonnte.com/send'),
    'enabled' => env('WHATSAPP_ENABLED', false),
],
```

---

## 📝 Checklist Production

Sebelum deploy ke production:

- [x] Token Fonnte sudah dikonfigurasi
- [x] Device WhatsApp connected
- [x] Test endpoint berhasil
- [x] Format nomor HP semua user sudah benar (62xxx)
- [x] Log monitoring aktif
- [ ] Setup alert jika quota < 100
- [ ] Backup device WhatsApp (opsional)
- [ ] Test dengan nomor HP real user
- [ ] Dokumentasi untuk admin

---

## 🆘 Support

**Jika ada masalah:**

1. **Cek log:** `storage/logs/laravel.log`
2. **Test koneksi:** `php test-whatsapp.php`
3. **Cek user HP:** `php check-users-hp.php`
4. **Dashboard Fonnte:** https://fonnte.com

**Kontak Fonnte:**
- Email: support@fonnte.com
- Docs: https://fonnte.com/docs

---

## 📚 File Referensi

- `app/Services/WhatsAppService.php` - Service WhatsApp core
- `app/Http/Controllers/Api/Sales/OrderController.php` - Controller order dengan WhatsApp
- `routes/api.php` - API routes untuk orders
- `config/services.php` - Konfigurasi Fonnte
- `.env` - Environment variables

---

**Dibuat:** 14 Desember 2025  
**Status:** ✅ AKTIF & BERFUNGSI  
**Quota:** 997/1000 pesan
