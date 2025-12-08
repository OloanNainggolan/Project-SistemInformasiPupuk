# 🧪 QUICK TEST GUIDE - Admin Overview Real Data

## 📋 PRE-TESTING CHECKLIST

```bash
# 1. Clear all caches
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 2. Start development server
php artisan serve
# atau
composer run dev
```

---

## ✅ TEST 1: Admin Dashboard Metrics

### Steps:
1. Buka browser: `http://127.0.0.1:8000/admin/login`
2. Login dengan credentials admin dari database `admins` table
3. Redirect otomatis ke `/admin/dashboard`
4. Verifikasi data yang ditampilkan:

**Expected Results:**
- ✅ **Total Pesanan**: 30 (dari database)
- ✅ **Total Pendapatan**: Rp 13.762.000 (dari completed orders)
- ✅ **Total Petani**: 16 (dari users table)
- ✅ **Total Produk**: 3 (dari produk table)
- ✅ **Status Breakdown**:
  - Pending: 4
  - Processing: 7
  - Ready: 5
  - Completed: 4
  - Rejected: 0

**Database Verification:**
```sql
-- Total Pesanan
SELECT COUNT(*) FROM orders WHERE confirmed_by_user = 1;

-- Total Pendapatan
SELECT SUM(total_amount) FROM orders 
WHERE confirmed_by_user = 1 AND status = 'Completed';

-- Total Petani
SELECT COUNT(*) FROM users;

-- Total Produk
SELECT COUNT(*) FROM produk;

-- Status Breakdown
SELECT status, COUNT(*) as total 
FROM orders 
WHERE confirmed_by_user = 1 
GROUP BY status;
```

---

## ✅ TEST 2: User Order Flow → Database → Admin

### Steps:

#### A. Create Order (User Side)
1. **Login sebagai user**: `http://127.0.0.1:8000/login`
2. **Browse produk**: `/user/pupuk-bibit`
3. **Pilih produk** → Click "Lihat Detail"
4. **Isi quantity** (contoh: 5) → Submit
5. **Isi form konfirmasi**:
   - Nama: "Test User"
   - No HP: "08123456789"
   - Alamat: "Jl. Test No. 123"
   - Catatan: "Test order dari sistem"
6. **Click "Konfirmasi Pesanan"**
7. **Verify SweetAlert2 popup** muncul dengan nomor pesanan
8. **Note nomor pesanan** (contoh: ORD-20251204-ABC123)

#### B. Verify Database
```sql
-- Check order tersimpan
SELECT * FROM orders 
WHERE order_number = 'ORD-20251204-ABC123';

-- Expected fields:
-- - user_id: [user yang login]
-- - product_id: [produk yang dipilih]
-- - quantity: 5
-- - customer_name: "Test User"
-- - customer_phone: "08123456789"
-- - customer_address: "Jl. Test No. 123"
-- - status: "Pending"
-- - confirmed_by_user: 1
-- - confirmed_at: [timestamp]

-- Check stok berkurang
SELECT stok_produk FROM produk WHERE id_produk = [product_id];
-- Stok harus berkurang sesuai quantity
```

#### C. Verify Admin Dashboard
1. **Login admin**: `/admin/login`
2. **View dashboard**: `/admin/dashboard`
3. **Verify**:
   - ✅ Total Pesanan bertambah 1 (sekarang 31)
   - ✅ Pending count bertambah 1 (sekarang 5)
   - ✅ Order baru muncul di "Pesanan Terbaru"
   - ✅ Customer name "Test User" terlihat

---

## ✅ TEST 3: API Endpoints

### A. Test Metrics API
```bash
# PowerShell
Invoke-WebRequest -Uri "http://127.0.0.1:8000/admin/api/metrics" `
  -Method GET | Select-Object -ExpandProperty Content | ConvertFrom-Json
```

**Expected Response:**
```json
{
  "success": true,
  "data": {
    "metrics": {
      "total_pesanan": 30,
      "total_pendapatan": 13762000,
      "total_petani": 16,
      "total_produk": 3
    },
    "growth": {
      "pesanan": 100,
      "pendapatan": 100
    },
    "status_breakdown": {
      "pending": 4,
      "processing": 7,
      "ready": 5,
      "completed": 4,
      "rejected": 0
    }
  },
  "timestamp": "2025-12-04 10:30:00"
}
```

### B. Test Orders API
```bash
# Get all orders
Invoke-WebRequest -Uri "http://127.0.0.1:8000/admin/api/orders" `
  -Method GET | Select-Object -ExpandProperty Content | ConvertFrom-Json

# Filter by status
Invoke-WebRequest -Uri "http://127.0.0.1:8000/admin/api/orders?status=Pending" `
  -Method GET | Select-Object -ExpandProperty Content | ConvertFrom-Json

# Search by name
Invoke-WebRequest -Uri "http://127.0.0.1:8000/admin/api/orders?search=Test" `
  -Method GET | Select-Object -ExpandProperty Content | ConvertFrom-Json
```

### C. Test Update Status API
```bash
# Update order status to Processing
$body = @{
    status = "Processing"
    admin_notes = "Pesanan sedang diproses"
} | ConvertTo-Json

Invoke-WebRequest -Uri "http://127.0.0.1:8000/admin/api/orders/31/status" `
  -Method PATCH `
  -ContentType "application/json" `
  -Body $body
```

**Expected Response:**
```json
{
  "success": true,
  "message": "Status pesanan berhasil diperbarui",
  "data": {
    "id": 31,
    "order_number": "ORD-20251204-ABC123",
    "status": "Processing",
    "admin_notes": "Pesanan sedang diproses",
    "processed_at": "2025-12-04 10:35:00",
    "processed_by": 1
  }
}
```

### D. Test Revenue API
```bash
# This month revenue
Invoke-WebRequest -Uri "http://127.0.0.1:8000/admin/api/revenue?period=month" `
  -Method GET | Select-Object -ExpandProperty Content | ConvertFrom-Json

# This week revenue
Invoke-WebRequest -Uri "http://127.0.0.1:8000/admin/api/revenue?period=week" `
  -Method GET | Select-Object -ExpandProperty Content | ConvertFrom-Json
```

---

## ✅ TEST 4: Stok Management

### Scenario: Order dengan stok tidak cukup

1. **Check stok produk**:
```sql
SELECT id_produk, nama_produk, stok_produk FROM produk WHERE id_produk = 1;
-- Contoh: stok = 10
```

2. **Try order quantity > stok**:
   - Login user
   - Pilih produk dengan id_produk = 1
   - Isi quantity = 15 (lebih dari stok 10)
   - Submit konfirmasi

3. **Expected Result**:
   - ✅ SweetAlert2 error: "Stok tidak mencukupi. Tersedia: 10 unit"
   - ✅ Order TIDAK tersimpan di database
   - ✅ Stok TIDAK berkurang

4. **Verify**:
```sql
SELECT * FROM orders WHERE product_id = 1 ORDER BY id DESC LIMIT 1;
-- Tidak ada order baru dengan quantity = 15

SELECT stok_produk FROM produk WHERE id_produk = 1;
-- Stok tetap 10
```

### Scenario: Order berhasil dengan stok cukup

1. **Order dengan quantity valid** (contoh: 3 dari stok 10)
2. **Expected Result**:
   - ✅ Order tersimpan
   - ✅ Stok berkurang: 10 → 7

3. **Verify**:
```sql
-- Order tersimpan
SELECT * FROM orders WHERE product_id = 1 ORDER BY id DESC LIMIT 1;

-- Stok berkurang
SELECT stok_produk FROM produk WHERE id_produk = 1;
-- Expected: 7
```

---

## ✅ TEST 5: DB Transaction Rollback

### Scenario: Simulasi error saat order

**Manual Test (via Tinker):**
```bash
php artisan tinker
```

```php
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

// Get product
$produk = Product::find(1);
$stokAwal = $produk->stok_produk;
echo "Stok awal: {$stokAwal}\n";

// Simulate error during transaction
DB::beginTransaction();
try {
    // Create order
    $order = Order::create([
        'order_number' => 'TEST-ERROR-001',
        'user_id' => 1,
        'product_id' => 1,
        'quantity' => 5,
        'unit_price' => 100000,
        'subtotal' => 500000,
        'total_amount' => 500000,
        'customer_name' => 'Test',
        'customer_phone' => '08123',
        'customer_address' => 'Test',
        'status' => 'Pending',
        'confirmed_by_user' => true,
        'confirmed_at' => now()
    ]);
    
    // Decrement stock
    $produk->decrement('stok_produk', 5);
    
    // Force error
    throw new \Exception("Simulated error");
    
    DB::commit();
} catch (\Exception $e) {
    DB::rollBack();
    echo "Error: {$e->getMessage()}\n";
}

// Check stock after rollback
$produk->refresh();
echo "Stok setelah rollback: {$produk->stok_produk}\n";
// Expected: Sama dengan stok awal (tidak berubah)

// Check order not saved
$testOrder = Order::where('order_number', 'TEST-ERROR-001')->first();
echo "Order tersimpan: " . ($testOrder ? 'YA (ERROR!)' : 'TIDAK (BENAR!)') . "\n";
```

**Expected Output:**
```
Stok awal: 10
Error: Simulated error
Stok setelah rollback: 10
Order tersimpan: TIDAK (BENAR!)
```

---

## ✅ TEST 6: Growth Percentage Calculation

### Scenario: Verify pertumbuhan percentage

**Database Check:**
```sql
-- Orders bulan ini
SELECT COUNT(*) as total_bulan_ini 
FROM orders 
WHERE confirmed_by_user = 1 
AND MONTH(created_at) = MONTH(NOW()) 
AND YEAR(created_at) = YEAR(NOW());

-- Orders bulan lalu
SELECT COUNT(*) as total_bulan_lalu 
FROM orders 
WHERE confirmed_by_user = 1 
AND MONTH(created_at) = MONTH(DATE_SUB(NOW(), INTERVAL 1 MONTH))
AND YEAR(created_at) = YEAR(DATE_SUB(NOW(), INTERVAL 1 MONTH));

-- Manual calculation
-- Growth = ((bulan_ini - bulan_lalu) / bulan_lalu) * 100
-- Example: (15 - 10) / 10 * 100 = 50%
```

**Verify di Dashboard:**
- ✅ Pertumbuhan Pesanan sesuai perhitungan
- ✅ Pertumbuhan Pendapatan sesuai perhitungan

---

## 🐛 TROUBLESHOOTING

### Issue: "Class 'App\Models\Order' not found"
**Solution:**
```bash
composer dump-autoload
php artisan config:clear
```

### Issue: "SQLSTATE[HY000]: General error"
**Solution:**
```bash
php artisan migrate:status
# Pastikan semua migration sudah run
php artisan migrate
```

### Issue: "Route not found"
**Solution:**
```bash
php artisan route:clear
php artisan route:list --path=admin
# Pastikan route admin/api/metrics ada
```

### Issue: "Stok tidak berkurang"
**Solution:**
- Check file: `PupukBibitController@storeOrder`
- Pastikan ada: `$produk->decrement('stok_produk', $quantity);`
- Check DB transaction: `DB::beginTransaction()` ... `DB::commit()`

### Issue: "Total Pesanan = 0 di dashboard"
**Solution:**
```sql
-- Check data orders
SELECT COUNT(*) FROM orders WHERE confirmed_by_user = 1;

-- Jika 0, berarti belum ada order
-- Test create order dari user side
```

---

## ✅ ACCEPTANCE CRITERIA

### Dashboard Admin harus menampilkan:
- [x] Total Pesanan dari database (real count)
- [x] Total Pendapatan dari Completed orders (real sum)
- [x] Total Petani dari users table (real count)
- [x] Total Produk dari produk table (real count)
- [x] Growth percentage bulan ini vs bulan lalu
- [x] Recent orders (10 latest)
- [x] Status breakdown (Pending, Processing, Ready, Completed, Rejected)

### User Order Flow harus:
- [x] Simpan ke database orders table
- [x] Decrement stok_produk
- [x] Generate order_number unique
- [x] Validasi stok sebelum order
- [x] Use DB transaction untuk safety
- [x] Return error jika stok tidak cukup
- [x] Tampil di admin dashboard setelah order

### API Endpoints harus:
- [x] Return real data dari database
- [x] Support pagination untuk orders
- [x] Support filter by status
- [x] Support search by name/order number
- [x] Update status dengan validation
- [x] Return proper HTTP status codes
- [x] Include timestamps

---

## 🎯 SUCCESS METRICS

**Semua test PASS jika:**
1. ✅ Dashboard metrics = database count
2. ✅ User order → tersimpan di DB
3. ✅ Stok berkurang saat order
4. ✅ Order tampil di admin dashboard
5. ✅ API return data real
6. ✅ DB transaction rollback jika error
7. ✅ Growth percentage calculated correctly
8. ✅ No dummy data / hardcoded values

**Sistem READY untuk production!** 🚀
