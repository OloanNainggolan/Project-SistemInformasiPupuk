# Panduan Setup WhatsApp API dengan Fonnte

## 📱 Tentang Fonnte

Fonnte adalah layanan WhatsApp Business API yang mudah digunakan untuk mengirim pesan WhatsApp otomatis dari aplikasi.

Website: https://fonnte.com

## 🚀 Langkah-langkah Setup

### 1. Daftar Akun Fonnte

1. Kunjungi https://fonnte.com
2. Klik "Daftar" atau "Register"
3. Isi formulir pendaftaran dengan data yang valid
4. Verifikasi email Anda
5. Login ke dashboard Fonnte

### 2. Dapatkan API Token

1. Login ke dashboard Fonnte
2. Buka menu **"API"** atau **"Pengaturan"**
3. Temukan **"API Token"** Anda
4. Copy token tersebut (contoh format: `abc123xyz456...`)

### 3. Hubungkan WhatsApp

1. Di dashboard Fonnte, pilih menu **"Device"**
2. Klik **"Tambah Device"** atau **"Add Device"**
3. Scan QR Code menggunakan WhatsApp Anda:
   - Buka WhatsApp di HP
   - Tap menu (3 titik) → **"Linked Devices"**
   - Tap **"Link a Device"**
   - Scan QR Code yang muncul di Fonnte
4. Tunggu hingga status **"Connected"**

### 4. Konfigurasi Laravel

#### A. Edit file `.env`

```env
# WhatsApp Configuration (Fonnte)
FONNTE_API_TOKEN=your_actual_token_here
FONNTE_API_URL=https://api.fonnte.com/send
WHATSAPP_ENABLED=true
```

**Ganti `your_actual_token_here` dengan token asli dari Fonnte!**

#### B. Verify Config (Opsional)

File `config/services.php` sudah dikonfigurasi otomatis:

```php
'fonnte' => [
    'token' => env('FONNTE_API_TOKEN'),
    'url' => env('FONNTE_API_URL', 'https://api.fonnte.com/send'),
    'enabled' => env('WHATSAPP_ENABLED', false),
],
```

### 5. Format Nomor Telepon

Nomor telepon di database **harus** menggunakan format internasional Indonesia:

- **Format Benar**: `628123456789` (diawali 62, tanpa 0)
- **Format Salah**: `08123456789` (jangan pakai 0 di depan)
- **Format Salah**: `+628123456789` (jangan pakai tanda +)

**Sistem akan otomatis convert** format nomor, tapi lebih baik simpan dengan format benar dari awal.

### 6. Test Koneksi

#### A. Via Postman/API Client

Endpoint: `POST /api/v1/whatsapp/test`

**Request Body:**
```json
{
    "phone": "628123456789"
}
```

**Response (Success):**
```json
{
    "success": true,
    "message": "WhatsApp test message sent successfully",
    "details": {
        "phone": "628123456789",
        "status": "sent"
    }
}
```

**Response (Failed):**
```json
{
    "success": false,
    "message": "Failed to send WhatsApp message",
    "error": "Invalid token or device not connected"
}
```

#### B. Via Terminal (Laravel Tinker)

```bash
php artisan tinker
```

```php
$service = app(\App\Services\WhatsAppService::class);
$result = $service->testConnection('628123456789');
dd($result);
```

### 7. Cara Kerja Sistem

#### Notifikasi Otomatis Dikirim Saat:

1. **Order Baru Dibuat** (`POST /api/v1/orders`)
   - Customer langsung menerima WA konfirmasi order
   - Berisi detail produk, jumlah, total harga, pickup point

2. **Status Order Berubah** (`PATCH /api/v1/orders/{id}/status`)
   - Customer menerima update status pesanan
   - Contoh: "Pending" → "Processing" → "Ready" → "Completed"

#### Format Pesan WhatsApp

**Pesan Order Baru:**
```
🌾 Pesanan Baru #ABC123

📦 Produk: Pupuk Urea
📊 Jumlah: 50 kg
💰 Total: Rp 250.000

📍 Pickup Point: Kios Tani Makmur

Terima kasih telah memesan! 🙏
```

**Pesan Update Status:**
```
📬 Update Pesanan #ABC123

Status: PROCESSING ➜ READY

Pesanan Anda sudah siap diambil!

📍 Lokasi: Kios Tani Makmur
```

## 🧪 Testing Checklist

- [ ] Akun Fonnte sudah terdaftar
- [ ] API Token sudah didapat
- [ ] WhatsApp sudah terscan dan connected
- [ ] `.env` sudah diisi dengan token yang benar
- [ ] `WHATSAPP_ENABLED=true` di `.env`
- [ ] Test endpoint `/api/v1/whatsapp/test` berhasil
- [ ] Buat order baru → WA otomatis terkirim
- [ ] Update status order → WA notifikasi terkirim
- [ ] Format nomor HP di database sudah benar (62xxx)

## ⚠️ Troubleshooting

### 1. Pesan Tidak Terkirim

**Penyebab:**
- Token salah/expired
- Device WhatsApp tidak connected
- Nomor telepon format salah
- `WHATSAPP_ENABLED=false`

**Solusi:**
- Cek token di dashboard Fonnte
- Re-scan QR Code untuk reconnect WhatsApp
- Pastikan nomor HP format `628xxx` (tanpa 0 atau +)
- Set `WHATSAPP_ENABLED=true` di `.env`

### 2. Error "Invalid Token"

**Solusi:**
- Login ke Fonnte → Regenerate API Token
- Copy token baru ke `.env`
- Restart Laravel: `php artisan config:cache`

### 3. Error "Device Not Connected"

**Solusi:**
- Buka dashboard Fonnte → Menu Device
- Cek status device: harus "Connected" hijau
- Jika "Disconnected", scan ulang QR Code

### 4. User Tidak Punya Nomor HP

**Solusi:**
Sistem akan skip notifikasi jika `users.no_telp` kosong atau NULL.

**Log akan muncul:**
```
WhatsApp not sent: User has no phone number
```

## 📊 Monitoring

### Log File Location

WhatsApp activities tercatat di:
```
storage/logs/laravel.log
```

**Filter log WhatsApp:**
```bash
# Windows PowerShell
Get-Content storage/logs/laravel.log | Select-String "WhatsApp"

# Linux/Mac
tail -f storage/logs/laravel.log | grep WhatsApp
```

### Contoh Log Success

```
[2024-01-15 10:30:45] local.INFO: WhatsApp sent to 628123456789 for order ABC123
```

### Contoh Log Failed

```
[2024-01-15 10:30:45] local.ERROR: WhatsApp send failed: Invalid token
```

## 💰 Biaya Fonnte

- **Trial**: Biasanya dapat 100 pesan gratis
- **Berbayar**: Cek pricing di https://fonnte.com/pricing
- **Rekomendasi**: Mulai dengan paket murah untuk testing

## 📞 Support

- **Fonnte Support**: support@fonnte.com
- **Documentation**: https://fonnte.com/docs
- **WhatsApp Support**: +62 857-xxxx-xxxx (cek di dashboard)

## ✅ Production Checklist

Sebelum deploy ke production:

- [ ] Token production sudah didapat (beda dengan token testing)
- [ ] WhatsApp Business Account (opsional, bisa pakai personal)
- [ ] Backup device jika WhatsApp utama bermasalah
- [ ] Monitor credit balance Fonnte secara berkala
- [ ] Setup alert jika credit < 10%
- [ ] Test semua scenario (order baru, update status, cancel)
- [ ] Siapkan fallback jika Fonnte down (email notif?)

---

**Dibuat:** Januari 2024  
**Versi:** 1.0  
**Last Updated:** {{ date('Y-m-d') }}
