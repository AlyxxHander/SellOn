<h1 align="center">
  <br>
  🛍️ SellOn
  <br>
</h1>

<h4 align="center">Marketplace Eksklusif Mahasiswa Kampus — <em>Buy & Sell Within Your Campus</em></h4>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/TailwindCSS-4.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="TailwindCSS">
  <img src="https://img.shields.io/badge/Vite-7.x-646CFF?style=for-the-badge&logo=vite&logoColor=white" alt="Vite">
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</p>

<p align="center">
  <a href="#1--judul">Judul</a> •
  <a href="#2--tentang-aplikasi">Tentang</a> •
  <a href="#3--tujuan-aplikasi">Tujuan</a> •
  <a href="#4--fitur-utama">Fitur Utama</a> •
  <a href="#5-️-arsitektur-sistem">Arsitektur</a> •
  <a href="#6--struktur-database">Database</a> •
  <a href="#7--stack-teknologi">Teknologi</a> •
  <a href="#8--lisensi">Lisensi</a>
</p>

---

## 📌 Tentang Aplikasi

> **Catatan Operasional:**  
> Saat ini, aplikasi **SellOn masih dijalankan secara lokal (*Local Development Environment*)** untuk keperluan riset, pengembangan, dan pengujian fitur. Seluruh transaksi dan interaksi antarmahasiswa disimulasikan pada server lokal (`localhost:8000`).

**SellOn** adalah platform *e-commerce / marketplace* berbasis web yang dirancang **khusus untuk ekosistem civitas akademika kampus**. Aplikasi ini menjembatani mahasiswa untuk menjual dan membeli barang bekas layak pakai (*preloved*), makanan, minuman, hingga menawarkan jasa antar sesama mahasiswa di lingkungan kampus yang sama.

Dengan memadukan kemudahan transaksi instan melalui WhatsApp dan keamanan akun berbasis identitas mahasiswa (NIM & email kampus), SellOn menghadirkan pengalaman jual-beli yang praktis, cepat, dan minim risiko penipuan.

---

## 🎯 Tujuan Aplikasi

| Aspek | Deskripsi |
|---|---|
| **Ekosistem Terpercaya** | Membangun sarana jual-beli yang aman dan terverifikasi di internal kampus melalui validasi NIM dan email resmi mahasiswa. |
| **Pencegahan Fraud** | Mencegah penipuan jual-beli online berkat verifikasi identitas resmi serta sistem ulasan (*review & rating*). |
| **Sirkulasi Barang Kampus** | Memfasilitasi mahasiswa dalam menjual barang bekas layak pakai (*preloved*) seperti buku kuliah, alat praktikum, kalkulator saintifik, hingga perabotan kos. |
| **Wadah Kewirausahaan** | Menjadi wadah promosi bagi mahasiswa yang merintis usaha mandiri di bidang kuliner (*food & beverage*) maupun jasa (*service* tugas, fotografi, desain, rental, dll.). |
| **Transaksi Praktis (COD)** | Mengoptimalkan transaksi Cash on Delivery (COD) atau pertemuan langsung di area kampus dengan integrasi tombol WhatsApp satu-klik tanpa biaya admin atau potongan komisi. |

---

## ✨ Fitur Utama

### 🔐 Autentikasi & Keamanan
- **Registrasi Berbasis NIM & Email Kampus**: Pendaftaran mewajibkan pengisian Nomor Induk Mahasiswa (NIM) 15 digit yang unik serta email institusi mahasiswa.
- **Verifikasi Email Kampus (Signed URL)**: Menggunakan tautan berotentikasi (*signed URL*) yang dikirim ke email mahasiswa via protokol SMTP. Akses ke modul transaksi dan pengelolaan produk hanya terbuka setelah status akun `verified`.
- **Lupa & Reset Password**: Pengguna dapat mengajukan pemulihan kata sandi dengan tautan verifikasi aman yang memiliki batas kedaluwarsa.
- **Enkripsi & Sanitasi Data**: Password diamankan menggunakan algoritma `bcrypt` (12 *rounds*), seluruh form diproteksi token CSRF (`@csrf`), serta input teks disanitasi dari potensi serangan XSS menggunakan `strip_tags`.
- **Throttling & Session Security**: Pembatasan laju (*rate limiting*) pada pengiriman ulang email verifikasi (`throttle:1,1`) dan pembersihan sesi (*session invalidation*) saat logout.

### 🛒 Product Management (CRUD Lengkap)
- **Katalog & Input Produk**: Penjual dapat mengunggah produk dengan data nama, deskripsi, harga, kategori, kondisi barang, stok, serta foto produk.
- **Multi-Foto Produk**: Mendukung pengunggahan hingga **6 foto per produk** dengan galeri interaktif dan penentuan thumbnail otomatis.
- **Fleksibilitas Kategori & Stok Cerdas**: Penanganan cerdas terhadap kategori jasa (*Service*), di mana stok otomatis diset menjadi `NULL` karena tidak memerlukan kuantitas fisik.
- **Edit & Kelola Media**: Pemilik produk dapat memperbarui informasi produk, menambah foto baru, serta menghapus foto individual secara granular.
- **Proteksi Kepemilikan (*Ownership Protection*)**: Penjagaan ketat di sisi Controller sehingga hanya pemilik sah produk yang berhak mengedit atau menghapus item miliknya (`Auth::id() === $product->user_id`). File gambar di storage server akan dibersihkan secara otomatis ketika produk dihapus.

### 👤 Profile Management
- **Profil Publik Mahasiswa**: Halaman profil yang dapat diakses publik, memuat informasi nama lengkap (sesuai KTM), jurusan, identitas kampus, serta daftar produk yang sedang dijual oleh mahasiswa bersangkutan.
- **Edit Data Akun**: Pengguna dapat memperbarui nama, nomor WhatsApp, jurusan, dan alamat email.
- **Re-verifikasi Email Otomatis**: Apabila pengguna mengganti alamat email pada profil, sistem secara otomatis mereset status verifikasi (`email_verified_at = null`) dan mengirimkan kembali tautan verifikasi ke email yang baru.
- **Dashboard Produk Saya (*My Products*)**: Panel khusus untuk memantau, mengelola, mengedit, atau menghapus seluruh daftar produk yang pernah diunggah pengguna.
- **Avatar Dinamis**: Pembuatan avatar otomatis dan konsisten berbasis *DiceBear Avatars API* berdasarkan nama pengguna tanpa membebani penyimpanan lokal.

### 💬 Comment Management (Ulasan & Rating)
- **Rating & Ulasan Bintang 1–5**: Pembeli atau sesama mahasiswa yang telah terverifikasi dapat memberikan ulasan tertulis beserta rating skor 1 hingga 5 pada produk.
- **Kalkulasi Nilai Otomatis**: Model produk menghitung rata-rata rating (`average_rating`) secara dinamis hingga 1 desimal serta menampilkan total ulasan (`total_comments`).
- **Interaksi Real-Time via AJAX**: Form pengiriman ulasan serta tombol hapus ulasan dilengkapi penanganan JavaScript/AJAX dengan pembaruan visual instan tanpa memuat ulang (*reload*) halaman.
- **Kontrol Izin Penghapusan Komentar Multi-Level**:
  - Penjual (pemilik produk) berhak menghapus komentar yang ada di etalase produknya.
  - Penulis komentar berhak menghapus komentar buatannya sendiri.
  - Administrator memiliki wewenang penuh untuk memoderasi/menghapus komentar.

### 🔍 Search & Filter System
- **Pencarian Cepat (*Search*)**: Pencarian produk berbasis kata kunci pada nama produk secara dinamis menggunakan query SQL `LIKE`.
- **Filter Multi-Kategori**: Pengelompokan produk berdasarkan kategori utama: **All, Preloved, Food, Beverage, Service**.
- **Dynamic Category Counter**: Perhitungan jumlah produk aktif per kategori yang dihitung sebelum filter kategori diterapkan, sehingga angka pada tab kategori selalu sinkron dan mencerminkan hasil pencarian aktual.
- **Pengurutan Fleksibel (*Sorting*)**: Pilihan sortir produk: **Terbaru (Newest)**, **Harga: Terendah ke Tertinggi**, dan **Harga: Tertinggi ke Terendah**.
- **Paginasi Rapi**: Pembagian katalog sebanyak 20 produk per halaman dengan fungsi `withQueryString()` agar filter pencarian tidak hilang saat berpindah halaman.

### ❤️ Favorite System
- **Toggle Wishlist Instan**: Kemudahan menyimpan atau membatalkan produk favorit dengan satu kali klik (mendukung AJAX dengan animasi ikon hati maupun form standar).
- **Halaman Favorit Saya (*My Favorites*)**: Menu khusus bagi pengguna untuk melihat kembali seluruh produk yang telah ditandai sebagai favorit.
- **Indikator Status**: Penanda visual interaktif yang membedakan produk yang sudah masuk ke daftar favorit pengguna yang sedang login.

---

## 🏗️ Arsitektur Sistem

SellOn dibangun di atas pola arsitektur **Model-View-Controller (MVC)** menggunakan framework modern Laravel 12.

```
sellon/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ProductController.php          # Manajemen CRUD produk, katalog, search, filter
│   │   │   ├── UserController.php             # Registrasi, login, logout, edit profil
│   │   │   ├── ProductCommentController.php   # Store & destroy ulasan / rating produk
│   │   │   ├── FavoriteController.php         # Toggle wishlist & daftar produk favorit
│   │   │   ├── VerificationController.php     # Logika verifikasi email kampus (signed URL)
│   │   │   └── ForgotPasswordController.php   # Penanganan reset & ubah kata sandi
│   │   └── Middleware/                        # Proteksi rute (auth, verified, guest, throttle)
│   ├── Models/
│   │   ├── User.php                           # Identitas mahasiswa, relasi produk, ulasan, & favorit
│   │   ├── Product.php                        # Data produk, relasi user, gambar, ulasan, & rating
│   │   ├── ProductImage.php                   # Relasi multi-gambar per produk
│   │   ├── ProductComment.php                 # Ulasan, rating 1-5, dan relasi user-product
│   │   └── Favorite.php                       # Tabel pivot wishlist mahasiswa-produk
│   └── Notifications/
│       ├── VerifyEmailNotification.php        # Template email verifikasi kustom
│       └── ResetPasswordNotification.php      # Template email reset password
├── database/
│   ├── migrations/                            # Skema DDL tabel database
│   └── seeders/                               # Data dummy pengujian lokal
├── resources/
│   ├── css/                                   # Konfigurasi Tailwind CSS v4
│   ├── js/                                    # Skrip AJAX (komentar, wishlist, preview gambar)
│   └── views/
│       ├── auth/                              # Tampilan login, register, forgot password, verify
│       ├── layouts/                           # Master template layout aplikasi
│       ├── partials/                          # Komponen reusable (navbar, footer, toast)
│       ├── products/                          # View katalog, detail, form produk, dan ulasan
│       └── users/                             # View profil publik & dashboard produk saya
└── routes/
    └── web.php                                # Definisi seluruh endpoint & rute aplikasi
```

### Mekanisme Middleware & Proteksi Akses
- `guest`: Membatasi halaman login, register, dan forgot password hanya untuk pengunjung yang belum login.
- `auth`: Mewajibkan pengguna untuk melakukan autentikasi sebelum mengakses dashboard atau profil.
- `verified`: Memastikan hanya mahasiswa dengan email kampus terverifikasi yang dapat menambah produk, mengunggah foto, memberi ulasan, atau menyimpan produk favorit.
- `signed`: Memvalidasi integritas URL verifikasi email dan reset password dari manipulasi parameter pihak ketiga.
- `throttle:1,1`: Mencegah *spamming* permintaan pengiriman ulang email verifikasi.

---

## 🗄️ Struktur Database

SellOn mengelola **5 entitas tabel utama** yang saling berelasi:

```
┌─────────────────────────────────────────┐
│                  users                  │
├─────────────────────────────────────────┤
│ id                 (BIGINT, PK, Auto)   │
│ name               (VARCHAR 255)        │ ← Nama lengkap sesuai KTM
│ nim                (VARCHAR 15, UNIQUE) │ ← NIM 15 digit mahasiswa
│ major              (VARCHAR 255)        │ ← Jurusan / Program Studi
│ email              (VARCHAR 255, UNIQUE)│ ← Email kampus
│ whatsapp_no        (VARCHAR 15)         │ ← No. WhatsApp aktif
│ role               (VARCHAR 255)        │ ← Role ('user', 'admin')
│ password           (VARCHAR 255)        │ ← Hash bcrypt
│ email_verified_at  (TIMESTAMP, NULL)    │ ← NULL jika belum verifikasi
│ remember_token     (VARCHAR 100)        │
│ created_at / updated_at                 │
└────────────────────┬────────────────────┘
                     │ 1
                     │
       ┌─────────────┼───────────────┬────────────────────────┐
       │ hasMany     │ hasMany       │ hasMany                │ hasMany
       ▼ N           ▼ N             ▼ N                      ▼ N
┌──────────────┐ ┌──────────────┐ ┌────────────────────┐ ┌────────────────────┐
│   products   │ │  favorites   │ │  product_comments  │ │      sessions      │
└──────┬───────┘ └──────────────┘ └────────────────────┘ └────────────────────┘
       │ 1
       │ hasMany
       ▼ N
┌──────────────┐
│product_images│
└──────────────┘
```

### Skema Detail Kolom Database

#### 1. Tabel `users`
Menyimpan kredensial dan identitas mahasiswa:
- `id` (BigInt, PK, Auto Increment)
- `name` (String, Nama lengkap mahasiswa sesuai KTM)
- `nim` (String[15], Unique, Nomor Induk Mahasiswa 15 digit)
- `major` (String, Jurusan / Program Studi)
- `email` (String, Unique, Email resmi kampus)
- `whatsapp_no` (String[15], Nomor WhatsApp untuk komunikasi pembeli)
- `role` (String, Default: `'user'`)
- `password` (String, Password terenkripsi bcrypt)
- `email_verified_at` (Timestamp, Nullable — penanda verifikasi email)
- `remember_token` (String, Token "ingat saya")
- `created_at` & `updated_at` (Timestamp)

#### 2. Tabel `products`
Menyimpan informasi barang dan jasa yang dipasarkan:
- `id` (BigInt, PK, Auto Increment)
- `user_id` (BigInt, FK → `users.id`, On Delete Cascade)
- `name` (String, Nama produk / jasa)
- `description` (Text, Deskripsi lengkap produk)
- `price` (Decimal 15,2, Harga jual dalam Rupiah)
- `stock` (Integer, Nullable — bernilai `NULL` otomatis jika kategori *Service*)
- `category` (String, Pilihan: `Preloved`, `Food`, `Beverage`, `Service`)
- `condition` (String, Kondisi barang e.g. Baru, Bekas Layak Pakai)
- `image_url` (String, Nullable, Path foto thumbnail utama)
- `created_at` & `updated_at` (Timestamp)

#### 3. Tabel `product_images`
Menyimpan galeri multi-foto pendukung produk (maks. 6 foto):
- `id` (BigInt, PK, Auto Increment)
- `product_id` (BigInt, FK → `products.id`, On Delete Cascade)
- `image_url` (String, Path file di storage lokal)
- `created_at` & `updated_at` (Timestamp)

#### 4. Tabel `product_comments`
Menyimpan data ulasan dan rating produk dari pembeli:
- `id` (BigInt, PK, Auto Increment)
- `user_id` (BigInt, FK → `users.id`, On Delete Cascade)
- `product_id` (BigInt, FK → `products.id`, On Delete Cascade)
- `rating` (Unsigned TinyInteger, Skor penilaian 1–5)
- `comment` (Text, Isi ulasan teks)
- *Index*: `['product_id', 'created_at']`
- `created_at` & `updated_at` (Timestamp)

#### 5. Tabel `favorites`
Tabel relasi penanda produk favorit pengguna (*wishlist*):
- `id` (BigInt, PK, Auto Increment)
- `user_id` (BigInt, FK → `users.id`, On Delete Cascade)
- `product_id` (BigInt, FK → `products.id`, On Delete Cascade)
- `created_at` & `updated_at` (Timestamp)

---

## 📦 Stack Teknologi

### Backend & Core
- **PHP ^8.2** — Bahasa pemrograman server-side modern.
- **Laravel ^12.0** — Web application framework dengan arsitektur MVC yang tangguh dan skalabel.
- **Livewire ^4.2** — Pustaka komponen dinamis reaktif untuk antarmuka interaktif.
- **Laravel Tinker ^2.10** — *Interactive REPL debugger* untuk eksplorasi data Eloquent.

### Frontend & UI Styling
- **Blade Template Engine** — Mesin *templating server-side* bawaan Laravel yang modular dan ringan.
- **Tailwind CSS ^4.2** — Utility-first CSS framework untuk antarmuka yang modern, responsif, dan rapi.
- **Vite ^7.0** — *Frontend tooling & bundler* berkecepatan tinggi.
- **Axios ^1.11** — *HTTP client* berbasis Promise untuk mengeksekusi operasi AJAX (wishlist & komentar).
- **Font Awesome 6 (CDN)** — Ikonografi antarmuka pengguna yang lengkap dan konsisten.
- **DiceBear Avatars API** — Generator avatar ilustrasi dinamis berbasis seed nama pengguna.

### Database, Media Storage & Komunikasi
- **MySQL Database** — Sistem manajemen basis data relasional utama.
- **Laravel File Storage Disk (`public`)** — Pengelolaan penyimpanan file gambar produk lokal via tautan simbolik (`storage:link`).
- **SMTP Protocol (Brevo / Mailtrap)** — Pengiriman email notifikasi verifikasi akun dan pemulihan kata sandi.
- **WhatsApp Direct URL Scheme** — Integrasi pengalihan percakapan langsung ke aplikasi WhatsApp penjual (`https://wa.me/`).

### Development & Tooling
- **Composer** — Manajemen dependensi ekosistem PHP.
- **NPM** — Manajemen paket dependensi JavaScript dan CSS.
- **Concurrently** — Menjalankan server `artisan serve`, antrean `queue:listen`, log `pail`, dan bundler `vite` secara serentak dalam satu perintah terminal (`composer run dev`).

---

## 📄 Lisensi

Proyek ini didistribusikan di bawah lisensi resmi **[MIT License](LICENSE)**. Anda bebas menggunakan, memodifikasi, dan mengembangkan perangkat lunak ini baik untuk keperluan personal maupun edukasi.

---

<p align="center">
  Dikembangkan dengan integritas untuk memajukan ekosistem wirausaha mahasiswa 🎓
  <br>
  <strong>SellOn</strong> — <em>Connecting Campus Buyers and Sellers</em>
</p>
