# PANDUAN UPLOAD GAMBAR PRODUK

## Langkah-langkah:

### 1. Save gambar dari attachment dengan nama yang PERSIS seperti ini:

**PUPUK:**
- Gambar 1 (pupuk urea) → `pupuk-urea.jpg`
- Gambar 2 (NPK Phonska) → `pupuk-phonska.jpg`
- Gambar 3 (Pupuk ZA) → `pupuk-za.jpg`

**BIBIT:**
- Gambar 4 (Bibit Padi Inpari) → `bibit-padi-inpari.jpg`
- Gambar 5 (Bibit Jagung Hibrida) → `bibit-jagung-hibrida.jpg`
- Gambar 6 (Bibit Kedelai Unggul) → `bibit-kedelai-unggul.jpg`

### 2. Simpan SEMUA gambar ke folder:
```
public/images/products/
```

### 3. Setelah semua gambar disimpan, jalankan perintah:
```bash
php update_product_images.php
```

### 4. Refresh halaman browser untuk melihat hasilnya!

---

## Checklist:
- [ ] pupuk-urea.jpg ada di public/images/products/
- [ ] pupuk-phonska.jpg ada di public/images/products/
- [ ] pupuk-za.jpg ada di public/images/products/
- [ ] bibit-padi-inpari.jpg ada di public/images/products/
- [ ] bibit-jagung-hibrida.jpg ada di public/images/products/
- [ ] bibit-kedelai-unggul.jpg ada di public/images/products/
- [ ] Jalankan: php update_product_images.php
- [ ] Refresh browser
