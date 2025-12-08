# 📊 Struktur & Alur API - Catalog & Sales

## 🏗️ Struktur Folder Lengkap

```
Project-SistemInformasiPupuk/
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── Api/
│   │           ├── Auth/
│   │           │   └── AuthController.php
│   │           │       ├── register()
│   │           │       ├── login()
│   │           │       └── logout()
│   │           │
│   │           ├── Catalog/
│   │           │   └── ProductController.php
│   │           │       ├── index()         # GET /products
│   │           │       ├── show($id)       # GET /products/{id}
│   │           │       └── checkStock($id) # GET /products/{id}/stock
│   │           │
│   │           └── Sales/
│   │               └── OrderController.php
│   │                   ├── store()         # POST /orders
│   │                   ├── show($id)       # GET /orders/{id}
│   │                   └── getProductFromCatalog($id) [PRIVATE]
│   │
│   └── Models/
│       ├── User.php       (HasApiTokens trait)
│       ├── Product.php
│       └── Order.php
│
├── routes/
│   └── api.php            (Semua routes /api/v1/...)
│
└── database/
    └── migrations/
        ├── users
        ├── produk
        └── orders
```

## 🔄 Flow Diagram - Create Order

```
┌─────────────────────────────────────────────────────────────────┐
│                     CLIENT APPLICATION                           │
│  (Mobile App / Web / Postman)                                   │
└────────────┬────────────────────────────────────────────────────┘
             │
             │ 1. POST /api/v1/orders
             │    Headers: Authorization: Bearer {token}
             │    Body: {product_id, quantity, address, phone}
             │
             ▼
┌─────────────────────────────────────────────────────────────────┐
│                      SALES FOLDER                                │
│  OrderController.php → store()                                  │
└────────┬────────────────────────────────────────────────────────┘
         │
         │ 2. Internal API Call
         │    GET /api/v1/products/{id}/stock
         │
         ▼
┌─────────────────────────────────────────────────────────────────┐
│                     CATALOG FOLDER                               │
│  ProductController.php → checkStock($id)                        │
│                                                                  │
│  Return: {                                                      │
│    product_id, nama_produk,                                     │
│    stock, available,                                            │
│    harga_subsidi, harga_normal                                  │
│  }                                                              │
└────────┬────────────────────────────────────────────────────────┘
         │
         │ 3. Data produk & stok
         │
         ▼
┌─────────────────────────────────────────────────────────────────┐
│                      SALES FOLDER                                │
│  OrderController.php                                            │
│                                                                  │
│  4. Validasi Stok:                                              │
│     ✓ Stok tersedia?                                            │
│     ✓ Hitung total harga                                        │
│     ✓ Generate order number                                     │
│                                                                  │
│  5. Buat Order di Database                                      │
│  6. Kurangi Stok Produk                                         │
└────────┬────────────────────────────────────────────────────────┘
         │
         │ 7. Response Order
         │
         ▼
┌─────────────────────────────────────────────────────────────────┐
│                     CLIENT APPLICATION                           │
│  Receive: Order berhasil dibuat                                 │
└─────────────────────────────────────────────────────────────────┘
```

## 🔑 Authentication Flow

```
┌──────────────┐
│   Register   │ POST /api/v1/auth/register
│   or Login   │ POST /api/v1/auth/login
└──────┬───────┘
       │
       │ Return: {user, token}
       ▼
┌──────────────────────────┐
│  Client Stores Token     │
│  (LocalStorage/Session)  │
└──────┬───────────────────┘
       │
       │ Use token for protected endpoints
       ▼
┌─────────────────────────────────────┐
│  Protected Endpoints:               │
│  - POST /orders                     │
│  - GET /orders/{id}                 │
│  - POST /auth/logout                │
│                                     │
│  Headers:                           │
│  Authorization: Bearer {token}      │
└─────────────────────────────────────┘
```

## 📦 Data Flow - Get Products

```
┌─────────────┐
│   Client    │
└──────┬──────┘
       │
       │ GET /api/v1/products?tipe_produk=pupuk&per_page=10
       │ (No Token Required)
       ▼
┌──────────────────────────┐
│  Catalog Folder          │
│  ProductController       │
│                          │
│  1. Query Database       │
│  2. Apply Filters        │
│  3. Pagination           │
│  4. Load Images          │
└──────┬───────────────────┘
       │
       │ Return: {products with pagination}
       ▼
┌─────────────┐
│   Client    │
│  Display    │
│  Products   │
└─────────────┘
```

## 🗂️ Database Relations

```
┌─────────────┐         ┌──────────────┐         ┌─────────────────┐
│    users    │         │   produk     │         │ product_images  │
├─────────────┤         ├──────────────┤         ├─────────────────┤
│ id          │         │ id_produk    │◄────────│ product_id      │
│ name        │         │ nama_produk  │         │ image_path      │
│ email       │         │ tipe_produk  │         │ is_primary      │
│ password    │         │ kategori     │         │ order           │
│ no_telp     │         │ deskripsi    │         └─────────────────┘
│ alamat      │         │ harga_normal │
└─────┬───────┘         │ harga_subsidi│
      │                 │ stok         │
      │                 └──────┬───────┘
      │                        │
      │  hasMany               │ belongsTo
      │                        │
      │         ┌──────────────▼─────┐
      └────────►│     orders         │
                ├────────────────────┤
                │ id                 │
                │ order_number       │
                │ user_id            │
                │ product_id         │
                │ quantity           │
                │ price_per_unit     │
                │ total_price        │
                │ delivery_address   │
                │ phone              │
                │ status             │
                └────────────────────┘
```

## 🔐 Middleware Flow

```
Request
   │
   ▼
┌────────────────────────────────────┐
│  Route: /api/v1/...                │
└───────────┬────────────────────────┘
            │
            ▼
    Is Auth Required?
         / \
        /   \
       /     \
    YES      NO
     │        │
     │        └──► Controller → Response
     │
     ▼
┌─────────────────────────┐
│  auth:sanctum           │
│  Check Bearer Token     │
└────────┬────────────────┘
         │
    Token Valid?
       / \
      /   \
    YES    NO
     │      │
     │      └──► 401 Unauthorized
     │
     ▼
Controller → Response
```

## 📊 API Response Structure

### Success Response
```json
{
  "success": true,
  "message": "Operation successful",
  "data": {
    // Actual data here
  }
}
```

### Error Response
```json
{
  "success": false,
  "message": "Operation failed",
  "error": "Detailed error message"
}
```

### Validation Error
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "field_name": [
      "Error message 1",
      "Error message 2"
    ]
  }
}
```

## 🎯 Endpoint Permissions

| Endpoint | Method | Auth Required | Folder |
|----------|--------|---------------|--------|
| `/auth/register` | POST | ❌ No | Auth |
| `/auth/login` | POST | ❌ No | Auth |
| `/auth/logout` | POST | ✅ Yes | Auth |
| `/products` | GET | ❌ No | Catalog |
| `/products/{id}` | GET | ❌ No | Catalog |
| `/products/{id}/stock` | GET | ❌ No | Catalog |
| `/orders` | POST | ✅ Yes | Sales |
| `/orders/{id}` | GET | ✅ Yes | Sales |

## 🔄 Sales ↔ Catalog Integration

**Method:** HTTP Client Internal Call

```php
// Di Sales/OrderController.php

private function getProductFromCatalog($productId)
{
    $baseUrl = config('app.url');
    
    // Internal API call ke Catalog
    $response = Http::get("{$baseUrl}/api/v1/products/{$productId}/stock");
    
    if ($response->successful()) {
        return $response->json();
    }
    
    return ['success' => false];
}
```

**Keuntungan:**
- ✅ Separation of Concerns (setiap folder punya tanggung jawab sendiri)
- ✅ Catalog API bisa digunakan oleh folder lain juga
- ✅ Mudah di-test secara independen
- ✅ Scalable - bisa dijadikan microservice di masa depan

## 🚀 Deployment Flow

```
Development
    │
    ├── app/Http/Controllers/Api/Auth/
    ├── app/Http/Controllers/Api/Catalog/
    └── app/Http/Controllers/Api/Sales/
    │
    ▼
Testing
    │
    ├── Test Auth endpoints
    ├── Test Catalog endpoints  
    └── Test Sales endpoints (integration test)
    │
    ▼
Production
    │
    └── Base URL: https://api.yourapp.com/api/v1/
```

---

**Catatan:**
- Semua API menggunakan format JSON
- Auth menggunakan Laravel Sanctum (Token-based)
- Sales folder secara internal memanggil Catalog folder untuk data produk
- Struktur folder memudahkan pemisahan tanggung jawab dan maintainability
