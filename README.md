# Website Desa Sidomulyo Krian-Sidoarjo

Website resmi untuk promosi produk UMKM Desa Sidomulyo, Kecamatan Krian, Kabupaten Sidoarjo.

## Struktur File

```
sidomulyo-website/
├── index.html          # File HTML utama
├── style.css           # File CSS untuk styling
├── script.js           # File JavaScript untuk interaktivitas
├── logo-desa.png       # Logo Kabupaten Sidoarjo
├── product-placeholder.jpg # Gambar produk contoh
└── README.md           # File dokumentasi ini
```

## Fitur Website

### 1. Header Navigation
- Logo dan nama desa
- Menu navigasi dengan ikon
- Responsive design untuk mobile dan desktop

### 2. Halaman Belanja
- Grid produk UMKM
- Card produk dengan gambar, nama, rating, dan harga
- Pagination untuk navigasi halaman
- Modal detail produk (klik pada card produk)

### 3. Footer
- Informasi kontak pemerintah desa
- Nomor telepon penting
- Link ke website terkait
- Copyright information

### 4. Floating Elements
- Counter kunjungan harian
- Tombol pengaduan
- Tombol aksesibilitas

## Cara Menggunakan

### 1. Membuka Website
- Buka file `index.html` di browser web
- Atau gunakan live server di Visual Studio Code

### 2. Edit di Visual Studio Code
1. Buka folder `sidomulyo-website` di VS Code
2. Edit file sesuai kebutuhan:
   - `index.html` untuk struktur dan konten
   - `style.css` untuk tampilan dan styling
   - `script.js` untuk fungsi interaktif

### 3. Mengganti Konten

#### Mengganti Logo
- Ganti file `logo-desa.png` dengan logo yang diinginkan
- Pastikan ukuran sekitar 60x60 pixel untuk hasil terbaik

#### Mengganti Produk
- Edit bagian product-card di `index.html`
- Ganti gambar produk di folder yang sama
- Update nama, harga, dan deskripsi produk

#### Mengganti Informasi Kontak
- Edit bagian footer di `index.html`
- Update nomor telepon, email, dan alamat

## Teknologi yang Digunakan

- **HTML5**: Struktur website
- **CSS3**: Styling dan layout responsif
- **JavaScript**: Interaktivitas dan animasi
- **Font Awesome**: Ikon
- **Google Fonts**: Typography (Inter)

## Fitur Responsif

Website ini dirancang untuk bekerja optimal di:
- Desktop (1200px+)
- Tablet (768px - 1199px)
- Mobile (320px - 767px)

## Fitur JavaScript

### 1. Navigation
- Active state management
- Hover effects
- Click animations

### 2. Product Grid
- Product modal dengan detail
- Hover animations
- Loading animations

### 3. Pagination
- Page navigation
- Loading states

### 4. Floating Elements
- Animated visitor counter
- Complaint form modal
- Accessibility mode toggle

### 5. Responsive Features
- Mobile touch gestures
- Adaptive layout
- Performance optimizations

## Customization

### Mengubah Warna Theme
Edit variabel CSS di `style.css`:
```css
:root {
    --primary-color: #16bd1eff;
    --secondary-color: #ef4444;
    --accent-color: #fbbf24;
}
```

### Menambah Produk Baru
1. Duplikasi struktur product-card di HTML
2. Update informasi produk
3. Tambahkan gambar produk ke folder

### Mengubah Layout
- Edit grid system di CSS
- Sesuaikan breakpoint responsive
- Update JavaScript untuk layout baru

## Browser Support

- Chrome 60+
- Firefox 55+
- Safari 12+
- Edge 79+

## Performance

- Lazy loading untuk gambar
- Optimized CSS dan JavaScript
- Responsive images
- Minimal external dependencies

## Deployment

Website ini dapat di-deploy ke:
- GitHub Pages
- Netlify
- Vercel
- Web hosting tradisional

Cukup upload semua file ke server web hosting.

## Maintenance

### Update Konten
- Edit file HTML untuk konten statis
- Update gambar sesuai kebutuhan
- Test di berbagai device dan browser

### Backup
- Simpan backup file secara berkala
- Gunakan version control (Git) untuk tracking changes

## Support

Untuk bantuan teknis atau customization lebih lanjut, hubungi developer atau tim IT desa.

---

**Dibuat untuk Desa Sidomulyo, Kecamatan Krian, Kabupaten Sidoarjo**
*Powered by PT Digital Desa Indonesia*

