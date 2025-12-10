# 📚 API Documentation Index

## 🚀 Quick Links

### 📖 Main Documentation
- **[API Documentation](API_DOCUMENTATION_CATALOG_SALES.md)** - Dokumentasi lengkap semua endpoint
- **[Quick Start Guide](README_API_CATALOG_SALES.md)** - Panduan cepat untuk memulai
- **[Structure & Diagrams](API_STRUCTURE_DIAGRAM.md)** - Diagram alur dan struktur API
- **[Project Summary](API_PROJECT_SUMMARY.md)** - Ringkasan proyek dan checklist

---

## 🎯 What You Need

### For Developers
1. **Getting Started**: Baca [Quick Start Guide](README_API_CATALOG_SALES.md)
2. **API Reference**: Lihat [API Documentation](API_DOCUMENTATION_CATALOG_SALES.md)
3. **Architecture**: Pahami [Structure Diagrams](API_STRUCTURE_DIAGRAM.md)

### For QA/Testing
1. **Endpoint List**: [API Documentation - Endpoint Summary](API_DOCUMENTATION_CATALOG_SALES.md#endpoint-summary)
2. **Test Examples**: [API Documentation - Testing Section](API_DOCUMENTATION_CATALOG_SALES.md#testing-dengan-postmancurl)
3. **Response Format**: [API Documentation - Response Format](API_DOCUMENTATION_CATALOG_SALES.md#response-format)

### For Project Managers
1. **Overview**: [Project Summary](API_PROJECT_SUMMARY.md)
2. **Status**: [Project Summary - Checklist](API_PROJECT_SUMMARY.md#testing-checklist)

---

## 📂 API Structure

```
/api/v1/
├── auth/
│   ├── POST   /register       # Register user baru
│   ├── POST   /login          # Login & dapat token
│   └── POST   /logout         # Logout (butuh token)
│
├── products/
│   ├── GET    /               # List produk
│   ├── GET    /{id}           # Detail produk
│   └── GET    /{id}/stock     # Cek stok (internal)
│
└── orders/
    ├── POST   /               # Buat order (butuh token)
    └── GET    /{id}           # Detail order (butuh token)
```

---

## 🔑 Key Features

### ✅ Folder Separation
- **Auth**: Autentikasi (register, login, logout)
- **Catalog**: Data produk (read-only, public)
- **Sales**: Pemesanan (protected, panggil Catalog API)

### ✅ API Communication
Sales API → Internal Call → Catalog API untuk cek stok & harga

### ✅ Authentication
Laravel Sanctum token-based authentication

### ✅ Documentation
4 file dokumentasi lengkap dengan contoh & diagram

---

## 🧪 Quick Test

```bash
# 1. Register
curl -X POST http://localhost:8000/api/v1/auth/register \
  -H "Content-Type: application/json" \
  -d '{"name":"Test","email":"test@test.com","password":"12345678","password_confirmation":"12345678"}'

# 2. Get Products (no token)
curl http://localhost:8000/api/v1/products

# 3. Create Order (with token)
curl -X POST http://localhost:8000/api/v1/orders \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"product_id":1,"quantity":5,"delivery_address":"Jl. Test","phone":"081234567890"}'
```

---

## 📊 Endpoint Summary

| Folder | Endpoints | Auth Required |
|--------|-----------|---------------|
| Auth | 3 | Login/Logout only |
| Catalog | 3 | ❌ No (Public) |
| Sales | 2 | ✅ Yes (Token) |
| **Total** | **9** | - |

---

## 🔍 Find What You Need

### "Saya ingin tahu cara register user"
→ [API Documentation - Auth Register](API_DOCUMENTATION_CATALOG_SALES.md#1-register-user)

### "Saya ingin lihat contoh request/response"
→ [API Documentation - Semua Endpoints](API_DOCUMENTATION_CATALOG_SALES.md)

### "Saya ingin tahu cara Sales panggil Catalog API"
→ [Structure Diagram - Order Flow](API_STRUCTURE_DIAGRAM.md#flow-diagram---create-order)

### "Saya ingin setup project dari awal"
→ [Quick Start Guide - Setup & Run](README_API_CATALOG_SALES.md#-setup--run)

### "Saya ingin lihat checklist apa yang sudah dibuat"
→ [Project Summary - Testing Checklist](API_PROJECT_SUMMARY.md#-testing-checklist)

---

## 🎓 Learning Path

### Beginner
1. Baca [Quick Start Guide](README_API_CATALOG_SALES.md)
2. Test endpoint Auth (register, login)
3. Test endpoint Catalog (get products)

### Intermediate
4. Pahami token authentication
5. Test endpoint Sales dengan token
6. Pahami response format & error handling

### Advanced
7. Baca [Structure Diagrams](API_STRUCTURE_DIAGRAM.md)
8. Pahami komunikasi Sales → Catalog
9. Lihat implementasi kode di Controllers

---

## 📞 Support Files

| File | Purpose |
|------|---------|
| `API_DOCUMENTATION_CATALOG_SALES.md` | Referensi lengkap semua endpoint |
| `README_API_CATALOG_SALES.md` | Quick start & overview |
| `API_STRUCTURE_DIAGRAM.md` | Diagram flow & database |
| `API_PROJECT_SUMMARY.md` | Status proyek & checklist |
| `API_INDEX.md` | File ini - navigasi dokumentasi |

---

## ✅ Status

**Version:** 1.0.0  
**Status:** ✅ Production Ready  
**Last Updated:** 2024-12-08

**Features:**
- ✅ Folder Catalog (Products API)
- ✅ Folder Sales (Orders API)
- ✅ Internal API Communication
- ✅ Laravel Sanctum Auth
- ✅ Complete Documentation

---

**Happy Coding! 🚀**
