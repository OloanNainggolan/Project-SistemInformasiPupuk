# Quick Testing Guide - Flexible Image Upload

## 🚀 Quick Start

1. **Start server**: `php artisan serve` atau `composer run dev`
2. **Login as admin**: `/admin/login` (admin / admin123)
3. **Test pages**:
   - Create: `/admin/products/create`
   - Edit: `/admin/products/{id}/edit`

## ✅ Testing Checklist

### A. Create Product Page

#### Basic Upload Flow
```
□ Klik "Tambah Gambar" → file picker muncul
□ Pilih 1 gambar JPG → preview muncul dengan nama & ukuran
□ Badge "Gambar Utama" muncul di gambar pertama
□ Counter menampilkan "1 gambar dipilih (maksimal 5)"
□ Klik "Tambah Gambar" lagi → bisa pilih lagi
□ Pilih gambar ke-2 → preview bertambah
□ Counter update ke "2 gambar dipilih"
```

#### Validation
```
□ Upload file .txt → ditolak dengan alert
□ Upload gambar 3MB → ditolak dengan alert
□ Upload sampai 5 gambar → tombol berubah "Maksimal gambar tercapai"
□ Tombol disabled setelah 5 gambar
□ Tidak bisa tambah gambar ke-6
```

#### Delete Function
```
□ Klik tombol X di preview → gambar hilang
□ Counter berkurang
□ Tombol "Tambah Gambar" enabled lagi
□ Bisa tambah gambar baru setelah hapus
```

#### Form Submission
```
□ Submit tanpa gambar → alert "Minimal 1 gambar"
□ Submit dengan 1 gambar → berhasil
□ Submit dengan 5 gambar → berhasil
□ Loading indicator muncul saat submit
□ Redirect ke index setelah sukses
□ Semua gambar tersimpan di database
□ File tersimpan di public/images/products/
```

### B. Edit Product Page

#### Display Existing Images
```
□ Gambar existing ditampilkan dalam grid
□ Badge "Utama" muncul di gambar primary
□ Tombol X untuk mark delete muncul
□ Counter menampilkan jumlah gambar existing
```

#### Mark Delete
```
□ Klik X di gambar existing → marked with strikethrough
□ Tombol berubah jadi undo icon
□ Counter berkurang
□ Hidden input disabled untuk marked images
□ Klik undo → gambar restored
□ Counter bertambah lagi
```

#### Add New Images
```
□ Klik "Tambah Gambar Baru" → file picker muncul
□ Pilih 1 gambar → preview muncul dengan badge "Baru"
□ Preview baru terpisah dari existing
□ Counter "X gambar baru akan ditambahkan"
□ Bisa tambah beberapa kali
```

#### Total Validation
```
□ Product dengan 5 gambar → tombol "Tambah Gambar Baru" disabled
□ Mark delete 2 gambar → tombol enabled
□ Total = (existing - marked) + new <= 5
□ Counter update real-time
```

#### Form Submission
```
□ Submit dengan hapus 2, tambah 0 → marked images dihapus
□ Submit dengan hapus 0, tambah 2 → new images ditambahkan
□ Submit dengan hapus 2, tambah 2 → both operations berhasil
□ Submit hapus semua → alert "Minimal 1 gambar"
□ Redirect setelah sukses
□ Database dan file system konsisten
```

## 🐛 Edge Cases

### Test Semua Skenario Ini
```
□ Upload gambar dengan nama panjang > 100 karakter
□ Upload gambar dengan special characters (@#$%^&*)
□ Upload gambar dengan nama bahasa Indonesia (ñ, ü, etc)
□ Upload gambar duplicate (nama sama)
□ Cancel file picker (tidak pilih file)
□ Pilih file → cancel → pilih lagi
□ Hapus gambar → tambah lagi → hapus lagi
□ Rapid click tombol "Tambah Gambar"
□ Submit form twice (double click submit)
□ Slow internet (test loading state)
□ Browser back button after upload
□ Refresh page after preview (data hilang = OK)
```

## 📱 Browser Compatibility

Test di berbagai browser:
```
□ Chrome (latest)
□ Firefox (latest)
□ Edge (latest)
□ Safari (jika ada Mac)
```

## 🔍 Console Checks

Buka Developer Tools → Console, pastikan:
```
□ Tidak ada error JavaScript
□ Tidak ada warning
□ Network tab: FormData terkirim dengan benar
□ Network tab: gambar[] array terisi
□ Response status 200 atau redirect 302
```

## 📸 Visual Checks

### Preview Display
```
□ Gambar aspect ratio maintained (tidak stretched)
□ Preview box sama ukuran (grid layout rapi)
□ Badge tidak overlapping dengan image
□ Tombol X tidak ke-hide oleh badge
□ Nama file truncate dengan ... jika panjang
□ Ukuran file dalam KB (2 decimal places)
```

### Button States
```
□ Tombol "Tambah Gambar" hover effect smooth
□ Tombol disabled abu-abu (clearly disabled)
□ Tombol X hover effect (scale & color)
□ Submit button loading spinner animasi
```

### Responsive
```
□ Desktop (1920px): Grid 5-6 columns
□ Laptop (1366px): Grid 4-5 columns
□ Tablet (768px): Grid 3 columns
□ Mobile (480px): Grid 2 columns
```

## 🎯 Success Criteria

**Passed jika:**
- ✅ Semua checklist di atas passed
- ✅ Tidak ada error di console
- ✅ UI/UX smooth dan responsive
- ✅ Data tersimpan dengan benar
- ✅ File tersimpan di file system

## 🆘 Common Issues & Solutions

### Issue: Preview tidak muncul
**Check:**
- Console error?
- File valid (JPG/PNG/GIF)?
- FileReader API supported?

**Fix:**
```javascript
// Tambahkan error handling di FileReader
reader.onerror = function(error) {
    console.error('FileReader error:', error);
    alert('Gagal membaca file!');
};
```

### Issue: Tombol tidak disabled
**Check:**
- `updateAddButton()` terpanggil?
- `selectedImages.length` correct?

**Debug:**
```javascript
console.log('Image count:', selectedImages.length);
console.log('Max images:', maxImages);
console.log('Button should be disabled:', selectedImages.length >= maxImages);
```

### Issue: Form tidak submit
**Check:**
- Network tab: request terkirim?
- Response status?
- CSRF token valid?

**Debug:**
```javascript
console.log('FormData entries:');
for (let pair of formData.entries()) {
    console.log(pair[0], pair[1]);
}
```

### Issue: Gambar tidak tersimpan
**Check:**
- Server validation error?
- Laravel log: `storage/logs/laravel.log`
- File permissions: `public/images/products/` writable?

**Fix:**
```powershell
# Check permissions
icacls public\images\products

# Set permissions (if needed)
icacls public\images\products /grant Users:F
```

## 📊 Performance Check

```
□ Initial page load < 2 seconds
□ Add image preview < 500ms
□ Remove image preview < 100ms
□ Form submission < 3 seconds (for 5 images)
□ No memory leaks (check Task Manager after 10 uploads)
```

## ✨ User Experience Check

Ask someone else to test and observe:
```
□ Do they understand how to add images?
□ Do they know they can add one by one?
□ Do they find the delete button easily?
□ Do they understand the counter?
□ Do they know when limit is reached?
□ Overall: Is it intuitive?
```

## 📝 Report Template

```markdown
## Test Report - Flexible Image Upload

**Date**: [Date]
**Tester**: [Name]
**Browser**: [Chrome/Firefox/Edge]
**Environment**: [Local/Staging/Production]

### Create Page
- Basic Upload: ✅/❌
- Validation: ✅/❌
- Delete: ✅/❌
- Submission: ✅/❌

### Edit Page
- Display: ✅/❌
- Mark Delete: ✅/❌
- Add New: ✅/❌
- Submission: ✅/❌

### Edge Cases
- [List failed cases]

### Issues Found
1. [Issue 1]
2. [Issue 2]

### Screenshots
[Attach screenshots of any issues]

### Overall Status
✅ PASSED / ❌ FAILED

### Notes
[Additional comments]
```

## 🎉 Final Checklist

Before marking as complete:
```
□ All tests passed
□ No console errors
□ Documentation updated
□ Code reviewed
□ User tested
□ Performance acceptable
□ Edge cases handled
□ Error messages clear
□ Loading states proper
□ Responsive on all devices
```

---

**Ready to test?** Start with the basic upload flow on create page, then move to advanced scenarios. Happy testing! 🚀
