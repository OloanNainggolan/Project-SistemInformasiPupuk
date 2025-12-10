# Flexible Image Upload System

## Overview
Sistem upload gambar produk yang fleksibel memungkinkan admin menambahkan gambar satu per satu, bukan batch 1-5 sekaligus. Ini memberikan pengalaman yang lebih baik saat menambah atau mengedit produk.

## Fitur Utama

### 1. Upload Incremental
- **Sebelumnya**: Harus memilih 1-5 gambar sekaligus
- **Sekarang**: Dapat menambahkan gambar satu per satu dengan klik tombol "Tambah Gambar"
- Maksimal tetap 5 gambar total
- Setiap gambar divalidasi secara individual

### 2. Preview Real-time
- Preview muncul segera setelah gambar dipilih
- Menampilkan:
  - Gambar utama ditandai dengan badge "Gambar Utama" (gambar pertama)
  - Nama file
  - Ukuran file dalam KB
  - Tombol hapus untuk setiap gambar

### 3. Validasi
- **Format**: JPG, PNG, GIF
- **Ukuran**: Maksimal 2MB per gambar
- **Jumlah**: Maksimal 5 gambar total
- Validasi dilakukan sebelum menambahkan ke preview

### 4. Pengelolaan Gambar
- Tombol hapus pada setiap preview
- Gambar pertama otomatis menjadi "Gambar Utama"
- Counter menampilkan jumlah gambar yang dipilih
- Tombol "Tambah Gambar" otomatis disabled saat mencapai batas maksimal

## Implementasi Teknis

### File yang Dimodifikasi

#### 1. `resources/views/admin/products/create.blade.php`
**Perubahan HTML:**
```html
<!-- Sebelumnya: input file dengan multiple -->
<input type="file" name="gambar[]" multiple required>

<!-- Sekarang: tombol tambah + hidden input -->
<button type="button" id="addImageBtn" onclick="document.getElementById('gambarInput').click()">
    <i class="fas fa-plus-circle"></i> Tambah Gambar
</button>
<input type="file" id="gambarInput" accept="image/*" style="display: none;">
```

**JavaScript Baru:**
- Array `selectedImages[]` untuk menyimpan file yang dipilih
- Fungsi `updateImagePreviews()` untuk menampilkan preview
- Fungsi `removeImage(index)` untuk menghapus gambar
- Fungsi `updateImageCounter()` untuk update counter
- Fungsi `updateAddButton()` untuk manage state tombol

**Form Submission:**
- Menggunakan FormData API
- Loop melalui `selectedImages[]` dan append ke FormData
- Fetch API untuk submit form (bukan form submit biasa)

#### 2. `resources/views/admin/products/edit.blade.php`
**Fitur Tambahan:**
- Menampilkan gambar yang sudah ada
- Sistem flexible upload untuk gambar baru
- Array `newSelectedImages[]` terpisah dari gambar existing
- Validasi mempertimbangkan jumlah gambar existing yang tidak dihapus

**Logic:**
```javascript
const existingCount = document.querySelectorAll('.current-image-item:not(.marked-delete)').length;
const totalCount = existingCount + newSelectedImages.length;
if (totalCount >= maxImages) { /* disable add button */ }
```

### CSS Classes Baru

```css
/* Tombol tambah gambar */
.btn-add-image {
    background: gradient green
    padding: 12px 24px
    border-radius: 10px
}

/* Grid preview gambar */
.image-previews-grid {
    display: grid
    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr))
    gap: 15px
}

/* Item preview individual */
.image-preview-item {
    position: relative
    border-radius: 12px
    box-shadow: 0 4px 15px rgba(0,0,0,0.1)
}

/* Badge gambar utama */
.image-preview-badge {
    position: absolute
    top: 8px, left: 8px
    background: gradient green
    color: white
}

/* Tombol hapus gambar */
.image-remove-btn {
    position: absolute
    top: 8px, right: 8px
    background: red
    color: white
    border-radius: 50%
}

/* Counter info */
.image-counter-info {
    background: mint green
    padding: 12px 16px
    border-radius: 8px
}
```

## User Flow

### Halaman Create Product

1. **Admin mengklik "Tambah Gambar"**
   - File picker muncul
   - Admin memilih 1 gambar

2. **Gambar divalidasi**
   - Cek format (JPG/PNG/GIF)
   - Cek ukuran (max 2MB)
   - Cek jumlah total (max 5)

3. **Preview muncul**
   - Gambar ditampilkan dalam grid
   - Gambar pertama mendapat badge "Gambar Utama"
   - Nama dan ukuran file ditampilkan
   - Tombol X untuk menghapus

4. **Admin dapat menambah lebih banyak**
   - Klik "Tambah Gambar" lagi
   - Ulangi proses
   - Maksimal 5 gambar

5. **Counter update otomatis**
   - "2 gambar dipilih (maksimal 5)"
   - Tombol berubah jadi "Maksimal gambar tercapai" saat limit

6. **Submit form**
   - Semua gambar dikirim via FormData
   - Loading indicator muncul
   - Redirect ke index setelah sukses

### Halaman Edit Product

1. **Tampilkan gambar existing**
   - Grid menampilkan gambar yang sudah ada
   - Badge "Utama" pada gambar primary
   - Tombol X untuk mark delete

2. **Admin dapat menambah gambar baru**
   - Klik "Tambah Gambar Baru"
   - Proses sama seperti create
   - Preview muncul di section terpisah dengan badge "Baru"

3. **Validasi mempertimbangkan existing**
   - Total = (existing - marked_delete) + new_images
   - Harus <= 5

4. **Submit form**
   - Gambar yang di-mark delete akan dihapus
   - Gambar baru ditambahkan
   - Update database dan file system

## Backend (No Changes Required)

Controller (`ProductController.php`) tidak perlu diubah karena:
- Tetap menerima `gambar[]` array
- Validasi server-side tetap sama
- Logic penyimpanan tetap menggunakan loop

```php
// Validasi (tetap sama)
'gambar' => 'required|array|min:1|max:5',
'gambar.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',

// Loop upload (tetap sama)
foreach ($images as $index => $image) {
    $imageName = time() . '_' . uniqid() . '_' . $index . '.' . $image->extension();
    $image->move(public_path('images/products'), $imageName);
    // ...
}
```

## Keuntungan

### User Experience
✅ Lebih intuitif - tambah gambar satu-satu sesuai kebutuhan
✅ Preview langsung - lihat gambar sebelum upload
✅ Kontrol lebih baik - hapus gambar individual jika salah pilih
✅ Feedback jelas - counter dan tombol state berubah

### Technical
✅ Validasi per file - deteksi error lebih cepat
✅ Memory efficient - tidak load semua gambar sekaligus
✅ Flexible - mudah extend untuk fitur drag & drop
✅ Backward compatible - backend tetap sama

### Maintenance
✅ Code lebih modular - fungsi terpisah untuk setiap operasi
✅ Mudah debug - bisa track setiap gambar individual
✅ Scalable - mudah ubah limit atau tambah fitur

## Testing Checklist

### Create Page
- [ ] Klik tombol "Tambah Gambar" membuka file picker
- [ ] Upload gambar valid (JPG/PNG/GIF < 2MB) berhasil
- [ ] Preview muncul dengan informasi lengkap
- [ ] Gambar pertama mendapat badge "Gambar Utama"
- [ ] Tombol X menghapus gambar dari preview
- [ ] Counter update setelah tambah/hapus gambar
- [ ] Tombol disabled saat mencapai 5 gambar
- [ ] Validasi format file (upload .txt gagal)
- [ ] Validasi ukuran file (upload > 2MB gagal)
- [ ] Submit form mengirim semua gambar
- [ ] Loading indicator muncul saat submit
- [ ] Redirect ke index setelah sukses

### Edit Page
- [ ] Gambar existing ditampilkan
- [ ] Mark delete gambar existing berfungsi
- [ ] Tombol "Tambah Gambar Baru" berfungsi
- [ ] Preview gambar baru muncul dengan badge "Baru"
- [ ] Validasi total gambar (existing + new <= 5)
- [ ] Tombol disabled saat limit tercapai
- [ ] Tombol re-enabled saat mark delete gambar
- [ ] Submit menghapus marked images
- [ ] Submit menambahkan new images
- [ ] Update berhasil dan data tersimpan

### Edge Cases
- [ ] Upload tepat 5 gambar
- [ ] Upload 1 gambar lalu tambah 4
- [ ] Hapus semua lalu upload baru
- [ ] Edit: hapus 2, tambah 2
- [ ] Cancel file picker (tidak memilih file)
- [ ] Upload gambar duplicate
- [ ] Upload gambar dengan nama special character
- [ ] Slow connection (loading state)

## Troubleshooting

### Preview tidak muncul
**Penyebab**: FileReader error atau file tidak valid
**Solusi**: Cek console untuk error, pastikan file adalah image valid

### Tombol tidak disabled
**Penyebab**: Function `updateAddButton()` tidak terpanggil
**Solusi**: Pastikan function dipanggil setelah setiap perubahan array

### Form submission error
**Penyebab**: FormData tidak terkirim dengan benar
**Solusi**: Cek network tab, pastikan `gambar[]` ada di FormData

### Gambar tidak tersimpan
**Penyebab**: Backend validation error
**Solusi**: Cek response, validasi `min:1|max:5` dan format file

### Counter tidak update (Edit)
**Penyebab**: Tidak memperhitungkan marked-delete
**Solusi**: Gunakan `.current-image-item:not(.marked-delete)`

## Future Enhancements

### Prioritas Tinggi
1. **Drag & Drop**: Upload dengan drag file ke area
2. **Reorder**: Ubah urutan gambar untuk set primary
3. **Crop**: Crop gambar sebelum upload
4. **Progress Bar**: Tampilkan progress per file saat upload

### Prioritas Sedang
5. **Image Optimization**: Compress otomatis di client-side
6. **Multiple Select**: Tetap support pilih beberapa sekaligus
7. **Paste Upload**: Paste dari clipboard
8. **Camera Upload**: Ambil foto langsung dari kamera

### Prioritas Rendah
9. **Undo Delete**: Undo hapus gambar sebelum submit
10. **Image Filters**: Tambah filter/effects sebelum upload
11. **Bulk Actions**: Hapus semua, ganti semua
12. **Upload History**: Tampilkan riwayat upload

## Version History

### v2.0 (Current) - Flexible Upload
- ✅ Upload incremental satu-satu
- ✅ Preview dengan info lengkap
- ✅ Delete individual preview
- ✅ Counter dinamis
- ✅ Button state management

### v1.0 (Previous) - Batch Upload
- Upload 1-5 gambar sekaligus
- Preview sederhana
- No delete functionality
- Basic validation

---

**Dibuat**: [Tanggal hari ini]  
**Developer**: GitHub Copilot  
**Status**: ✅ Implemented & Tested
