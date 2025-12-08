# 📚 API Documentation - Catalog & Sales System

## 📖 Overview

API Laravel terpisah dalam 3 folder utama:
- **Auth**: Autentikasi pengguna (register, login, logout)
- **Catalog**: Data produk (GET products)
- **Sales**: Pemesanan produk (POST/GET orders) - **Mengambil data dari Catalog API**

---

## 🔗 Base URL

```
http://localhost:8000/api/v1
```

---

## 🔐 Authentication

API menggunakan **Laravel Sanctum** (Token-based authentication).

### Cara Mendapatkan Token:
1. Register atau Login
2. Token akan diberikan dalam response
3. Gunakan token di header untuk endpoint yang dilindungi:

```
Authorization: Bearer {your_token}
```

### Endpoint Yang Memerlukan Token:
- ✅ `POST /api/v1/orders`
- ✅ `GET /api/v1/orders/{id}`
- ✅ `POST /api/v1/auth/logout`

### Endpoint Tanpa Token (Public):
- ❌ `POST /api/v1/auth/register`
- ❌ `POST /api/v1/auth/login`
- ❌ `GET /api/v1/products`
- ❌ `GET /api/v1/products/{id}`

---

## 📂 Struktur Folder

```
app/Http/Controllers/Api/
├── Auth/
│   └── AuthController.php          # Register, Login, Logout
├── Catalog/
│   └── ProductController.php       # Get Products, Check Stock
└── Sales/
    └── OrderController.php         # Create Order, Get Order
```

---

## 🔑 AUTH API

### 1. Register User

**Endpoint:** `POST /api/v1/auth/register`  
**Auth Required:** ❌ No

#### Request Body
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "phone": "081234567890",
  "address": "Jl. Contoh No. 123"
}
```

#### Response Success (201)
```json
{
  "success": true,
  "message": "User registered successfully",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "phone": "081234567890",
      "address": "Jl. Contoh No. 123"
    },
    "token": "1|abcdefghijklmnopqrstuvwxyz123456"
  }
}
```

#### Validation Rules
| Field | Required | Rules |
|-------|----------|-------|
| name | ✅ Yes | max:255 |
| email | ✅ Yes | valid email, unique |
| password | ✅ Yes | min:8, confirmed |
| phone | ❌ No | max:20 |
| address | ❌ No | - |

---

### 2. Login User

**Endpoint:** `POST /api/v1/auth/login`  
**Auth Required:** ❌ No

#### Request Body
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

#### Response Success (200)
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "phone": "081234567890",
      "address": "Jl. Contoh No. 123"
    },
    "token": "2|xyz987654321abcdefghijklmnop"
  }
}
```

#### Response Error (401)
```json
{
  "success": false,
  "message": "Invalid credentials"
}
```

---

### 3. Logout User

**Endpoint:** `POST /api/v1/auth/logout`  
**Auth Required:** ✅ Yes

#### Headers
```
Authorization: Bearer {your_token}
```

#### Response Success (200)
```json
{
  "success": true,
  "message": "Logout successful"
}
```

---

## 📦 CATALOG API (Products)

### 1. Get All Products

**Endpoint:** `GET /api/v1/products`  
**Auth Required:** ❌ No

#### Query Parameters
| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| tipe_produk | string | No | Filter: `pupuk` atau `bibit` |
| search | string | No | Search nama/deskripsi produk |
| per_page | integer | No | Items per page (default: 15) |

#### Example Request
```
GET /api/v1/products?tipe_produk=pupuk&search=urea&per_page=10
```

#### Response Success (200)
```json
{
  "success": true,
  "message": "Products retrieved successfully",
  "data": {
    "current_page": 1,
    "data": [
      {
        "id_produk": 1,
        "nama_produk": "Pupuk Urea Subsidi",
        "tipe_produk": "pupuk",
        "kategori": "Nitrogen",
        "deskripsi": "Pupuk urea berkualitas tinggi",
        "harga_normal": 100000,
        "harga_subsidi": 50000,
        "stok": 100,
        "images": [
          {
            "id": 1,
            "image_path": "images/products/12345.jpg",
            "is_primary": true,
            "order": 0
          }
        ],
        "created_at": "2024-01-01T00:00:00.000000Z"
      }
    ],
    "per_page": 10,
    "total": 25
  }
}
```

---

### 2. Get Product by ID

**Endpoint:** `GET /api/v1/products/{id}`  
**Auth Required:** ❌ No

#### Example Request
```
GET /api/v1/products/1
```

#### Response Success (200)
```json
{
  "success": true,
  "message": "Product retrieved successfully",
  "data": {
    "id_produk": 1,
    "nama_produk": "Pupuk Urea Subsidi",
    "tipe_produk": "pupuk",
    "kategori": "Nitrogen",
    "deskripsi": "Pupuk urea berkualitas tinggi dengan subsidi pemerintah",
    "harga_normal": 100000,
    "harga_subsidi": 50000,
    "stok": 100,
    "images": [
      {
        "id": 1,
        "image_path": "images/products/12345.jpg",
        "is_primary": true
      }
    ]
  }
}
```

#### Response Error (404)
```json
{
  "success": false,
  "message": "Product not found"
}
```

---

### 3. Check Product Stock (Internal untuk Sales)

**Endpoint:** `GET /api/v1/products/{id}/stock`  
**Auth Required:** ❌ No (Internal API)

#### Example Request
```
GET /api/v1/products/1/stock
```

#### Response Success (200)
```json
{
  "success": true,
  "message": "Stock checked successfully",
  "data": {
    "product_id": 1,
    "nama_produk": "Pupuk Urea Subsidi",
    "stock": 100,
    "available": true,
    "harga_subsidi": 50000,
    "harga_normal": 100000
  }
}
```

**Note:** Endpoint ini digunakan oleh **Sales API** untuk cek stok sebelum membuat order.

---

## 🛒 SALES API (Orders)

### 1. Create Order

**Endpoint:** `POST /api/v1/orders`  
**Auth Required:** ✅ Yes

#### Headers
```
Authorization: Bearer {your_token}
Content-Type: application/json
```

#### Request Body
```json
{
  "product_id": 1,
  "quantity": 10,
  "delivery_address": "Jl. Contoh No. 123, Jakarta",
  "phone": "081234567890",
  "notes": "Mohon kirim pagi hari"
}
```

#### Response Success (201)
```json
{
  "success": true,
  "message": "Order created successfully",
  "data": {
    "order": {
      "id": 5,
      "order_number": "ORD-20241208-ABC123",
      "user_id": 1,
      "product_id": 1,
      "quantity": 10,
      "price_per_unit": 50000,
      "total_price": 500000,
      "delivery_address": "Jl. Contoh No. 123, Jakarta",
      "phone": "081234567890",
      "notes": "Mohon kirim pagi hari",
      "status": "pending",
      "created_at": "2024-12-08T10:30:00.000000Z"
    },
    "product_info": {
      "nama_produk": "Pupuk Urea Subsidi",
      "harga_normal": 100000,
      "harga_subsidi": 50000,
      "penghematan": 500000
    }
  }
}
```

#### Validation Rules
| Field | Required | Rules |
|-------|----------|-------|
| product_id | ✅ Yes | exists in produk table |
| quantity | ✅ Yes | min:1 |
| delivery_address | ✅ Yes | - |
| phone | ✅ Yes | max:20 |
| notes | ❌ No | - |

#### Response Error - Stok Tidak Cukup (400)
```json
{
  "success": false,
  "message": "Insufficient stock. Available: 5"
}
```

#### Response Error - Product Not Found (404)
```json
{
  "success": false,
  "message": "Product not found in catalog"
}
```

### 🔗 Proses Create Order (Sales → Catalog):

1. **Sales API** menerima request order
2. **Sales API** memanggil **Catalog API** (`GET /products/{id}/stock`)
3. **Catalog API** mengembalikan data stok & harga
4. **Sales API** validasi stok tersedia
5. **Sales API** buat order & kurangi stok
6. Return response ke client

```
Client → Sales API → Catalog API (Internal)
                  ↓
            Check Stock & Price
                  ↓
            Create Order + Reduce Stock
                  ↓
            Response to Client
```

---

### 2. Get Order by ID

**Endpoint:** `GET /api/v1/orders/{id}`  
**Auth Required:** ✅ Yes

#### Headers
```
Authorization: Bearer {your_token}
```

#### Example Request
```
GET /api/v1/orders/5
```

#### Response Success (200)
```json
{
  "success": true,
  "message": "Order retrieved successfully",
  "data": {
    "id": 5,
    "order_number": "ORD-20241208-ABC123",
    "user_id": 1,
    "product_id": 1,
    "product": {
      "id_produk": 1,
      "nama_produk": "Pupuk Urea Subsidi",
      "harga_subsidi": 50000,
      "images": [
        {
          "image_path": "images/products/12345.jpg",
          "is_primary": true
        }
      ]
    },
    "quantity": 10,
    "price_per_unit": 50000,
    "total_price": 500000,
    "delivery_address": "Jl. Contoh No. 123, Jakarta",
    "phone": "081234567890",
    "notes": "Mohon kirim pagi hari",
    "status": "pending",
    "created_at": "2024-12-08T10:30:00.000000Z"
  }
}
```

#### Response Error (404)
```json
{
  "success": false,
  "message": "Order not found"
}
```

**Note:** User hanya bisa melihat order miliknya sendiri.

---

## 🎯 Response Format

### Success Response
```json
{
  "success": true,
  "message": "Success message here",
  "data": {
    // Response data
  }
}
```

### Error Response
```json
{
  "success": false,
  "message": "Error message here",
  "error": "Detailed error (optional)"
}
```

### Validation Error (422)
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "email": ["Email sudah terdaftar"],
    "password": ["Password minimal 8 karakter"]
  }
}
```

---

## 🔄 API Flow Diagram

### Register/Login Flow
```
Client
  ↓
POST /api/v1/auth/register
  ↓
Auth Controller
  ↓
Create User + Generate Token
  ↓
Return Token to Client
```

### Order Creation Flow (Sales ↔ Catalog)
```
Client (with token)
  ↓
POST /api/v1/orders
  ↓
Sales Controller
  ↓
Internal API Call → GET /api/v1/products/{id}/stock
  ↓
Catalog Controller
  ↓
Return Stock & Price Data
  ↓
Sales Controller validates & creates order
  ↓
Reduce product stock
  ↓
Return order data to Client
```

---

## 🧪 Testing dengan Postman/cURL

### 1. Register User
```bash
curl -X POST http://localhost:8000/api/v1/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

### 2. Login
```bash
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password123"
  }'
```

### 3. Get Products (No Token)
```bash
curl -X GET "http://localhost:8000/api/v1/products?per_page=5"
```

### 4. Create Order (With Token)
```bash
curl -X POST http://localhost:8000/api/v1/orders \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "product_id": 1,
    "quantity": 5,
    "delivery_address": "Jl. Test No. 123",
    "phone": "081234567890"
  }'
```

### 5. Get Order Detail (With Token)
```bash
curl -X GET http://localhost:8000/api/v1/orders/1 \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

---

## ⚡ Quick Start

### 1. Jalankan Server
```bash
php artisan serve
```

### 2. Test Health Check
```bash
curl http://localhost:8000/api/v1/health
```

Response:
```json
{
  "success": true,
  "message": "API is running",
  "version": "1.0.0",
  "timestamp": "2024-12-08T10:00:00.000000Z"
}
```

### 3. Testing Flow Lengkap:
1. **Register** → Dapat token
2. **Get Products** → Lihat produk tersedia
3. **Create Order** (dengan token) → Buat pesanan
4. **Get Order** (dengan token) → Lihat detail pesanan

---

## 🔒 Security Notes

1. **Token Authentication**: Semua endpoint Sales memerlukan token
2. **Password Hashing**: Password di-hash dengan bcrypt
3. **Validation**: Semua input divalidasi
4. **User Isolation**: User hanya bisa lihat order miliknya

---

## 📊 HTTP Status Codes

| Code | Meaning | Usage |
|------|---------|-------|
| 200 | OK | Request berhasil |
| 201 | Created | Resource berhasil dibuat (register, create order) |
| 400 | Bad Request | Stok tidak cukup, dll |
| 401 | Unauthorized | Token tidak valid/expired |
| 404 | Not Found | Resource tidak ditemukan |
| 422 | Validation Error | Input tidak valid |
| 500 | Server Error | Internal server error |

---

## 📞 Support

Untuk pertanyaan atau bantuan, hubungi tim development.

---

**Version:** 1.0.0  
**Last Updated:** 2024-12-08  
**Framework:** Laravel 10.x + Sanctum
