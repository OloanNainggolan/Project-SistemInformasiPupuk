# 🚀 API Laravel - Catalog & Sales System

## 📋 Overview

API Laravel dengan struktur folder terpisah:
- **Auth** → Autentikasi (register, login, logout)
- **Catalog** → Data produk (read-only)
- **Sales** → Pemesanan produk (mengambil data dari Catalog API)

## 🏗️ Struktur Folder

```
app/Http/Controllers/Api/
├── Auth/
│   └── AuthController.php          # POST register, login, logout
├── Catalog/
│   └── ProductController.php       # GET products, stock check
└── Sales/
    └── OrderController.php         # POST/GET orders (panggil Catalog API)
```

## 🔗 Endpoint Summary

### 🔐 Auth (Public)
- `POST /api/v1/auth/register` - Register user baru
- `POST /api/v1/auth/login` - Login & dapat token
- `POST /api/v1/auth/logout` - Logout (butuh token)

### 📦 Catalog (Public)
- `GET /api/v1/products` - List semua produk
- `GET /api/v1/products/{id}` - Detail produk
- `GET /api/v1/products/{id}/stock` - Cek stok (internal untuk Sales)

### 🛒 Sales (Protected - Butuh Token)
- `POST /api/v1/orders` - Buat pesanan baru
- `GET /api/v1/orders/{id}` - Detail pesanan

## 🔄 Komunikasi Antar Folder

**Sales → Catalog Flow:**
```
Client (POST /orders)
    ↓
Sales OrderController
    ↓
Internal API Call → GET /products/{id}/stock (Catalog API)
    ↓
Catalog ProductController (return stock & price)
    ↓
Sales validates & creates order
    ↓
Response to Client
```

**Kode di OrderController:**
```php
// Sales memanggil Catalog API untuk cek stok & harga
private function getProductFromCatalog($productId)
{
    $baseUrl = config('app.url');
    $response = Http::get("{$baseUrl}/api/v1/products/{$productId}/stock");
    
    return $response->json();
}
```

## 🧪 Quick Test

### 1. Register User
```bash
curl -X POST http://localhost:8000/api/v1/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

**Response:**
```json
{
  "success": true,
  "data": {
    "user": {...},
    "token": "1|abc123..."
  }
}
```

### 2. Get Products (No Token)
```bash
curl http://localhost:8000/api/v1/products
```

### 3. Create Order (With Token)
```bash
curl -X POST http://localhost:8000/api/v1/orders \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "product_id": 1,
    "quantity": 5,
    "delivery_address": "Jl. Test",
    "phone": "081234567890"
  }'
```

## 📚 Dokumentasi Lengkap

Lihat `API_DOCUMENTATION_CATALOG_SALES.md` untuk:
- ✅ Detail semua endpoint
- ✅ Contoh request & response lengkap
- ✅ Validation rules
- ✅ Error handling
- ✅ Flow diagram

## 🔐 Token Authentication

**Endpoint yang BUTUH token:**
- `POST /api/v1/orders`
- `GET /api/v1/orders/{id}`
- `POST /api/v1/auth/logout`

**Cara pakai token:**
```
Authorization: Bearer {your_token}
```

**Endpoint TANPA token (public):**
- Auth: register, login
- Catalog: semua endpoint products

## ⚡ Setup & Run

```bash
# Install dependencies
composer install

# Setup database
php artisan migrate

# Jalankan server
php artisan serve
```

API berjalan di: `http://localhost:8000/api/v1`

## 🎯 Response Format

**Success:**
```json
{
  "success": true,
  "message": "Success message",
  "data": {...}
}
```

**Error:**
```json
{
  "success": false,
  "message": "Error message",
  "error": "Detail error"
}
```

## 📊 HTTP Status Codes

| Code | Meaning |
|------|---------|
| 200 | Success |
| 201 | Created |
| 400 | Bad Request |
| 401 | Unauthorized |
| 404 | Not Found |
| 422 | Validation Error |
| 500 | Server Error |

## 🔍 Health Check

```bash
curl http://localhost:8000/api/v1/health
```

Response:
```json
{
  "success": true,
  "message": "API is running",
  "version": "1.0.0"
}
```

## 📞 Lihat Routes

```bash
php artisan route:list --path=api/v1
```

---

**Version:** 1.0.0  
**Framework:** Laravel 10.x + Sanctum  
**Author:** Information Systems - Del Institute of Technology
