# Manual Penggunaan Sistem Informasi Pupuk & Bibit Subsidi

## Daftar Isi
1. [Persiapan Awal](#persiapan-awal)
2. [Menjalankan Aplikasi](#menjalankan-aplikasi)
3. [Panduan Pengguna Umum](#panduan-pengguna-umum)
4. [Panduan Administrator](#panduan-administrator)
5. [Troubleshooting](#troubleshooting)

---

## Persiapan Awal

### 1. Requirement System
- PHP 8.2 atau lebih tinggi
- Composer
- Node.js & NPM
- MySQL (sudah terinstall via Laragon)
- Laragon (recommended) atau XAMPP

### 2. Instalasi Database

**Langkah 1: Buat Database**
```sql
CREATE DATABASE sistem_informasi_pupukdanbibit;
```

**Langkah 2: Konfigurasi Database**
File `.env` sudah dikonfigurasi dengan:
