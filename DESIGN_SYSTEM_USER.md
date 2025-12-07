# PEDOMAN KONSISTENSI DESAIN USER PAGES

## Sudah Diimplementasikan

✅ **CSS Design System** (`public/css/user-theme.css`)
- Color palette yang konsisten
- Typography scale
- Spacing system
- Component styles (buttons, cards, forms, tables, badges)
- Icon boxes
- Responsive breakpoints

✅ **Layout User** 
- Link ke user-theme.css sudah ditambahkan

✅ **Halaman Profil User** (`ProfilUser.blade.php`)
- Layout 320px sidebar + main content
- FontAwesome icons (bukan emoticon)
- Card design dengan gradient top border
- Stats cards 2x2 layout
- Modern button styles
- Hover effects yang smooth
- Typography konsisten
- Status badge "Berhasil" (bukan "Success")

## Yang Perlu Disesuaikan

### 1. Halaman Kontak (`kontak.blade.php`)
**Status**: Sedang diupdate
- ✅ Menggunakan CSS variables dari theme
- ⏳ Form styling perlu disesuaikan dengan form-group-user
- ⏳ Button perlu menggunakan btn-user-primary

### 2. Halaman Edit Profil (`EditProfil.blade.php`)
- ⏳ Card header perlu menggunakan card-user-header
- ⏳ Form groups perlu menggunakan form-group-user
- ⏳ Buttons perlu menggunakan btn-user classes
- ⏳ Icon boxes perlu konsisten

### 3. Halaman Dashboard (`dashboard.blade.php`)  
- ⏳ Hero section perlu disesuaikan spacing-nya dengan page-wrapper-user
- ⏳ Feature cards perlu menggunakan card-user
- ⏳ Icons perlu menggunakan icon-box-user
- ⏳ Buttons perlu konsisten

### 4. Halaman Pupuk & Bibit (`pupukdanbibit.blade.php`)
- ⏳ Product cards perlu menggunakan card-user
- ⏳ Buttons perlu menggunakan btn-user
- ⏳ Badges perlu menggunakan badge-user
- ⏳ Hero banner spacing

### 5. Halaman Notifikasi (`Notifikasi.blade.php`)
- ✅ Sudah bagus dengan gradient cards dan icons
- ⏳ Perlu verifikasi konsistensi spacing
- ⏳ Icon boxes perlu disesuaikan ukuran

### 6. Halaman Detail Notifikasi (`DetailNotif.blade.php`)
- ✅ Sudah bagus dengan dynamic content
- ⏳ Card styling perlu disesuaikan dengan card-user-bordered
- ⏳ Icon boxes perlu konsisten

### 7. Halaman Konfirmasi Pesanan (`konfirmasi-pesanan.blade.php`)
- ⏳ Perlu review lengkap
- ⏳ Form styling
- ⏳ Button styling

### 8. Halaman Lihat Detail Pesan (`lihat-detail-pesan.blade.php`)
- ⏳ Perlu review lengkap
- ⏳ Card styling
- ⏳ Typography

## Color Palette Standar

**Primary Colors:**
- Primary Green: `#4CAF50`
- Primary Green Dark: `#1b5e20`  
- Primary Green Medium: `#2e7d32`
- Primary Green Light: `#66BB6A`

**Accent Colors:**
- Blue: `#1e88e5`
- Purple: `#5e35b1`
- Red: `#e53935`
- Pink: `#d81b60`
- Orange: `#e65100`
- Yellow: `#f57f17`

**Neutral Colors:**
- Text Primary: `#1b5e20`
- Text Secondary: `#555`
- Text Tertiary: `#777`
- Border Light: `#f0f0f0`
- Border Medium: `#e8e8e8`

## Typography Standar

**Font Sizes:**
- Page Title: `2.25rem` (36px)
- Section Title: `1.5rem` (24px)
- Card Title: `1.25rem` (20px)
- Body Text: `1rem` (16px)
- Small Text: `0.875rem` (14px)

**Font Weights:**
- Headings: `700`
- Subheadings: `600`
- Body Bold: `600`
- Body Regular: `400`

## Button Styles

**Primary Button:**
```css
.btn-user-primary
- Background: linear-gradient(135deg, #4caf50 0%, #2e7d32 100%)
- Color: white
- Padding: 1rem 2rem
- Border-radius: 12px
- Shadow: 0 3px 10px rgba(76, 175, 80, 0.2)
```

**Secondary Button:**
```css
.btn-user-secondary
- Background: white
- Color: #4caf50
- Border: 2px solid #4caf50
```

**Danger Button:**
```css  
.btn-user-danger
- Background: linear-gradient(135deg, #e53935 0%, #d32f2f 100%)
- Color: white
```

## Card Styles

**Standard Card:**
```css
.card-user
- Background: white
- Border-radius: 24px
- Shadow: 0 4px 20px rgba(0,0,0,0.06)
- Border: 1px solid #f0f0f0
```

**Card with Top Border:**
```css
.card-user-bordered
- Same as card-user
- Plus 5px gradient top border
```

## Icon Box Styles

**Default:**
```css
.icon-box-user
- Size: 40x40px
- Background: #fafafa
- Border-radius: 12px
- Color: #4caf50
```

**Primary:**
```css
.icon-box-user-primary
- Background: linear-gradient(135deg, #4caf50, #2e7d32)
- Color: white
- Shadow: 0 4px 16px rgba(76, 175, 80, 0.2)
```

## Spacing Scale

- Extra Small: `0.5rem` (8px)
- Small: `0.75rem` (12px)
- Medium: `1rem` (16px)
- Large: `1.5rem` (24px)
- Extra Large: `2rem` (32px)
- 2XL: `2.5rem` (40px)
- 3XL: `3rem` (48px)
- 4XL: `4rem` (64px)

## Border Radius Scale

- Small: `8px`
- Medium: `12px`
- Large: `16px`
- XL: `20px`
- 2XL: `24px`
- Full: `9999px` (circular)

## Shadow Scale

- Small: `0 2px 8px rgba(0, 0, 0, 0.04)`
- Medium: `0 4px 20px rgba(0, 0, 0, 0.06)`
- Large: `0 8px 30px rgba(0, 0, 0, 0.08)`
- XL: `0 12px 40px rgba(0, 0, 0, 0.12)`
- Green: `0 4px 16px rgba(76, 175, 80, 0.2)`

## Page Layout

**Standard Wrapper:**
```css
.page-wrapper-user
- Margin-top: 170px
- Margin-bottom: 4rem
- Min-height: calc(100vh - 250px)
```

**Container Sizes:**
- XL: `1400px`
- Large: `1200px`
- Medium: `900px`
- Small: `640px`

## Form Elements

**Input:**
```css
.form-input-user
- Padding: 1rem 1.5rem
- Border: 2px solid #e8e8e8
- Border-radius: 12px
- Font-size: 1rem
```

**Focus State:**
```css
- Border-color: #4caf50
- Box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1)
```

## Badge/Tag Styles

**Success:**
```css
- Background: #c8e6c9
- Color: #2e7d32
- Border: #81c784
```

**Warning:**
```css
- Background: #fff3e0  
- Color: #e65100
- Border: #ffcc80
```

**Info:**
```css
- Background: #e3f2fd
- Color: #1565c0
- Border: #90caf9
```

## Alert Styles

**Success Alert:**
```css
- Background: linear-gradient(135deg, #d4edda, #c8e6c9)
- Color: #155724
- Border: 2px solid #81c784
```

**Error Alert:**
```css
- Background: linear-gradient(135deg, #f8d7da, #ffcdd2)
- Color: #721c24
- Border: 2px solid #ef9a9a
```

## Table Styles

**Header:**
```css
- Background: #fafafa
- Font-weight: 600
- Text-transform: uppercase
- Letter-spacing: 0.5px
```

**Rows:**
```css
- Border-bottom: 1px solid #f0f0f0
- Hover background: #fafafa
```

## Checklist Implementasi

### Priority 1 (Critical)
- [x] Create CSS design system
- [x] Update ProfilUser.blade.php
- [ ] Update EditProfil.blade.php
- [ ] Update kontak.blade.php

### Priority 2 (Important)
- [ ] Update pupukdanbibit.blade.php
- [ ] Update dashboard.blade.php
- [ ] Verify Notifikasi.blade.php
- [ ] Verify DetailNotif.blade.php

### Priority 3 (Nice to have)
- [ ] Update konfirmasi-pesanan.blade.php
- [ ] Update lihat-detail-pesan.blade.php
- [ ] Create component documentation
- [ ] Add transition animations

## Notes

1. Semua emoticon harus diganti dengan FontAwesome icons
2. Gunakan CSS variables dari theme untuk konsistensi
3. Spacing harus mengikuti scale (8px increments)
4. Shadow harus subtle (tidak terlalu gelap)
5. Hover effects harus smooth dengan transition 0.3s
6. Border radius untuk cards: 24px
7. Border radius untuk buttons: 12-14px
8. Text tidak boleh diubah (keep original Indonesian text)
9. Green color palette sebagai primary
10. Gradient direction: 135deg untuk konsistensi
