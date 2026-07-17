<h1 align="center">
  <br>
  🧠 Psychologia
  <br>
</h1>

<h4 align="center">Portal Artikel & Manajemen Informasi Kesehatan Mental — <em>Edukasi & Kelola Informasi Psikologi</em></h4>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/TailwindCSS-4.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="TailwindCSS">
  <img src="https://img.shields.io/badge/Vite-7.x-646CFF?style=for-the-badge&logo=vite&logoColor=white" alt="Vite">
  <img src="https://img.shields.io/badge/Livewire-4.x-FB70A9?style=for-the-badge&logo=livewire&logoColor=white" alt="Livewire">
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</p>

<p align="center">
  <a href="#-tentang-aplikasi">Tentang</a> •
  <a href="#-fitur-utama">Fitur</a> •
  <a href="#️-arsitektur-sistem">Arsitektur</a> •
  <a href="#-struktur-database">Database</a> •
  <a href="#-alur-sistem--algoritma">Algoritma</a> •
  <a href="#-stack-teknologi">Teknologi</a> •
  <a href="#-instalasi--setup">Instalasi</a>
</p>

## ℹ️ Tentang Aplikasi

**Psychologia** adalah sebuah aplikasi web portal edukatif berbasis Laravel yang berfokus pada publikasi informasi di bidang psikologi dan kesehatan mental. Aplikasi ini dirancang untuk memfasilitasi pembacaan artikel edukatif oleh masyarakat luas, pengelolaan profil organisasi, serta mempermudah administrator dalam memanajemen anggota dan konten artikel secara terintegrasi melalui panel admin yang intuitif.

### Live Website
Demo aplikasi website dapat langsung diakses melalui link di bawah ini:
* **URL**: [https://301-pixel-vault.infinityfreeapp.com/](https://301-pixel-vault.infinityfreeapp.com/)
* **Akun Demo (Admin)**:
  * **Email**: `director1@gmail.com`
  * **Password**: `password`

---

## 🌟 Fitur Utama

- **Portal Artikel Publik (Landing Page)**: Pengunjung (guest) dapat mengakses Beranda, Hubungi Kami, Katalog Artikel, dan membaca Detail Artikel tanpa perlu mendaftar/login.
- **Sistem Autentikasi**: Fitur login aman bagi administrator dengan sistem proteksi rute berbasis middleware.
- **Dashboard Admin**: Panel kontrol terpusat untuk memantau ringkasan statistik sistem serta mengakses Pusat Bantuan (Help Center).
- **Manajemen Anggota (CRUD)**: Kontrol penuh bagi administrator untuk mengelola data anggota organisasi (tambah, lihat, sunting profil, hapus).
- **Manajemen Artikel (CRUD)**: Memungkinkan admin mengelola konten artikel (tambah dengan editor WYSIWYG TinyMCE, atur status draft/published, pin artikel, kategori, tags, serta hapus).
- **Manajemen Profil & Visi Misi**: Memungkinkan pembaruan data profil admin serta pembaruan data Visi & Misi organisasi secara dinamis.

---

## 🏗️ Arsitektur Sistem

Psychologia dibangun menggunakan pola arsitektur **MVC (Model-View-Controller)** yang merupakan standar dari framework Laravel.

```mermaid
graph TD
    Client[Client / Web Browser] -->|HTTP Request| Router[Router web.php]
    Router -->|Guest/Auth| Middleware[Route Middleware]
    Middleware -->|Pass| Controller[Controllers\nAuthController, UserController, AdminController]
    Controller <-->|Read/Write| Model[Models / Eloquent ORM]
    Model <-->|Query| Database[(Database MySQL)]
    Controller -->|Render Data| View[Views / Blade Templates & Livewire]
    View -->|HTML / CSS / JS| Client
```

### Sistem Middleware & Proteksi Rute
Aplikasi ini secara ketat memisahkan hak akses menggunakan sistem proteksi rute (Route Protection) dengan Middleware bawaan Laravel:
- **`guest` Middleware**: Diterapkan pada rute autentikasi (`/`, `/login`). Memastikan bahwa hanya pengguna yang belum login yang dapat melihat form login.
- **`auth` Middleware**: Diterapkan pada seluruh rute manajerial (grup rute `/admin/*` dan `/logout`). Memastikan bahwa halaman Dashboard Admin, Manajemen Anggota, dan Manajemen Artikel hanya dapat diakses oleh administrator yang sah. Akses ilegal akan otomatis dialihkan kembali ke form login.
- **Public Routes**: Rute landing page (grup `/landing/*`) dibiarkan terbuka (tanpa middleware pembatasan) agar edukasi psikologi dapat dijangkau oleh khalayak umum.

---

## 📊 Struktur Database

Aplikasi menggunakan database relasional dengan tabel-tabel utama sebagai berikut:

```mermaid
erDiagram
    POSITIONS ||--o{ USERS : "assigned to"
    POSITIONS ||--o{ MEMBERS : "assigned to"
    USERS ||--o{ ARTICLES : "writes"
    ARTICLE_CATEGORIES ||--o{ ARTICLES : "categorizes"

    USERS {
        bigint id PK
        foreignId position_id FK
        string full_name
        string email UK
        string password
        string profile_photo
        string imagekit_file_id
    }
    MEMBERS {
        bigint id PK
        foreignId position_id FK
        string full_name
        string email UK
        date join_date
        string profile_photo
        string imagekit_file_id
    }
    POSITIONS {
        bigint id PK
        string position UK
    }
    ARTICLES {
        bigint id PK
        foreignId author_id FK
        foreignId category_id FK
        string title
        longText content
        json tags
        string status
        boolean is_pinned
        string thumbnail_photo
        string imagekit_file_id
    }
    ARTICLE_CATEGORIES {
        bigint id PK
        string category UK
    }
    VISION_MISSIONS {
        bigint id PK
        enum type
        text content
    }
    FAQS {
        bigint id PK
        enum type
        text question
        text answer
    }
```

### Deskripsi Tabel
1. **`users`**: Menyimpan data administrator yang mengelola sistem.
2. **`members`**: Menyimpan data anggota organisasi/psikolog yang ditampilkan di profil/organisasi.
3. **`positions`**: Master data untuk jabatan anggota/admin (misal: "Director", "Developer", "Psychologist").
4. **`articles`**: Menyimpan data artikel psikologi dan kesehatan mental.
5. **`article_categories`**: Menyimpan kategori artikel (misal: "Mental Health", "Relationship").
6. **`vision_missions`**: Menyimpan data Visi & Misi organisasi.
7. **`faqs`**: Pusat data FAQ untuk memandu pengunjung dan admin.

---

## 🔄 Alur Sistem & Algoritma

### 1. Alur Publikasi Artikel
Proses di mana administrator membuat, mengunggah media, dan mempublikasikan artikel kesehatan mental ke portal publik.

```mermaid
flowchart TD
    A[Admin: Buat Artikel Baru] --> B{Pilih Status}
    B -- Draft --> C[Simpan ke DB dengan status 'draft']
    B -- Published --> D[Upload Gambar ke ImageKit]
    D --> E[Simpan ke DB dengan status 'published']
    C --> F[Artikel Hanya Terlihat di Panel Admin]
    E --> G[Artikel Muncul di Landing Page & Katalog Publik]
```

### 2. Alur Autentikasi & Proteksi Middleware
Menjamin bahwa halaman manajerial terlindungi dan hanya bisa diakses oleh admin setelah proses verifikasi kredensial berhasil.

```mermaid
flowchart TD
    A[Akses URL Admin /admin/*] --> B{Apakah Session Aktif?}
    B -- Ya --> C[Izinkan Akses Halaman Admin]
    B -- Tidak --> D[Redirect ke Form Login /]
    D --> E[Input Email & Password]
    E --> F{Kredensial Valid?}
    F -- Ya --> G[Buat Session & Redirect ke Dashboard]
    F -- Tidak --> H[Kembali ke Form Login + Pesan Error]
```

---

## 🛠️ Stack Teknologi

- **Backend Framework**: [Laravel 12.0](https://laravel.com/) (PHP ^8.2) — Mengelola routing, controller, ORM database, middleware, dan keamanan sistem.
- **Frontend & Styling**: Blade Templates & [Tailwind CSS v4](https://tailwindcss.com/) — Digunakan untuk antarmuka pengguna yang responsif dan modern dengan utility classes terbaru.
- **Dynamic Component**: [Livewire v4.x](https://livewire.laravel.com/) — Digunakan untuk interaksi UI yang dinamis tanpa full-page reload (misal pada filter pencarian dan load artikel).
- **Bundler & Build Tool**: [Vite v7.x](https://vite.dev/) — Untuk manajemen aset JavaScript dan CSS agar load-time aplikasi lebih cepat.
- **Database**: [MySQL](https://www.mysql.com/) — Tempat penyimpanan seluruh data relasional aplikasi.
- **Text Editor (WYSIWYG)**: [TinyMCE](https://www.tiny.cloud/) — Digunakan untuk mempermudah penulisan konten artikel dengan formatting kaya (rich text).
- **Asset Storage & CDN**: [ImageKit](https://imagekit.io/) — Digunakan untuk manajemen penyimpanan dan optimasi gambar profil serta thumbnail artikel secara cloud-based.

---

## ⚙️ Instalasi & Setup

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek Psychologia di lingkungan lokal:

### Prasyarat (Prerequisites)
Pastikan Anda sudah menginstal:
* PHP >= 8.2
* Composer
* Node.js & npm
* SQLite / MySQL Database

### Langkah Instalasi
```bash
# 1. Clone repositori ini
git clone https://github.com/username/psychologia.git
cd psychologia

# 2. Jalankan setup otomatis
# Perintah ini akan menginstal dependensi PHP/JS, menyalin .env, generate key, dan menjalankan migrasi database.
composer install
composer run setup
```

### Konfigurasi Environment (`.env`)
Buka file `.env` di root direktori proyek, lalu sesuaikan konfigurasi database dan ImageKit:
```env
# Database Configuration (Contoh menggunakan SQLite)
DB_CONNECTION=sqlite

# ImageKit Configuration (Wajib diisi jika ingin fitur unggah gambar berfungsi)
IMAGEKIT_PUBLIC_KEY=your_public_key
IMAGEKIT_PRIVATE_KEY=your_private_key
IMAGEKIT_URL_ENDPOINT=your_endpoint_url
```

### Menjalankan Server Lokal
Untuk menjalankan server Laravel, queue worker, real-time logging, dan Vite development server secara bersamaan, jalankan perintah berikut:
```bash
composer run dev
```
Aplikasi dapat diakses melalui browser pada alamat [http://127.0.0.1:8000](http://127.0.0.1:8000).

---

## 📄 Lisensi
Proyek ini bersifat open-source dan dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT). Anda bebas menggunakan, memodifikasi, dan mendistribusikan kode sumber aplikasi ini.
