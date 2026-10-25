# Spesifikasi Kebutuhan Perangkat Lunak (SKPL)
## Software Requirements Specification (SRS)

**Nama Produk:** Sellon — Platform Marketplace Komunitas Kampus  
**Versi Dokumen:** 1.0  
**Status:** Draf Awal Spesifikasi  
**Tanggal:** 21 Oktober 2026  

---

## Daftar Isi
- [1. Pendahuluan (Introduction)](#1-pendahuluan-introduction)
  - [1.1 Tujuan Dokumen (Purpose)](#11-tujuan-dokumen-purpose)
  - [1.2 Ruang Lingkup Produk (Product Scope)](#12-ruang-lingkup-produk-product-scope)
  - [1.3 Definisi, Akronim, dan Singkatan (Definitions, Acronyms, and Abbreviations)](#13-definisi-akronim-dan-singkatan-definitions-acronyms-and-abbreviations)
  - [1.4 Referensi (References)](#14-referensi-references)
  - [1.5 Gambaran Umum Dokumen (Document Overview)](#15-gambaran-umum-dokumen-document-overview)
- [2. Deskripsi Umum (Overall Description)](#2-deskripsi-umum-overall-description)
  - [2.1 Perspektif Produk (Product Perspective)](#21-perspektif-produk-product-perspective)
  - [2.2 Ringkasan Fungsi Utama Produk (Product Functions)](#22-ringkasan-fungsi-utama-produk-product-functions)
  - [2.3 Karakteristik dan Penggolongan Pengguna (User Characteristics)](#23-karakteristik-dan-penggolongan-pengguna-user-characteristics)
  - [2.4 Batasan Desain dan Implementasi (Constraints)](#24-batasan-desain-dan-implementasi-constraints)
  - [2.5 Asumsi dan Ketergantungan (Assumptions and Dependencies)](#25-asumsi-dan-ketergantungan-assumptions-and-dependencies)
- [3. Kebutuhan Fungsional (Functional Requirements)](#3-kebutuhan-fungsional-functional-requirements)
- [4. Kebutuhan Non-Fungsional (Non-Functional Requirements)](#4-kebutuhan-non-fungsional-non-functional-requirements)
- [5. Antarmuka Eksternal (External Interfaces)](#5-antarmuka-eksternal-external-interfaces)
  - [5.1 Antarmuka Pengguna (User Interfaces)](#51-antarmuka-pengguna-user-interfaces)
  - [5.2 Antarmuka Perangkat Keras (Hardware Interfaces)](#52-antarmuka-perangkat-keras-hardware-interfaces)
  - [5.3 Antarmuka Perangkat Lunak (Software Interfaces)](#53-antarmuka-perangkat-lunak-software-interfaces)
  - [5.4 Antarmuka Komunikasi (Communications Interfaces)](#54-antarmuka-komunikasi-communications-interfaces)

---

## 1. Pendahuluan (Introduction)

### 1.1 Tujuan Dokumen (Purpose)
Dokumen *Software Requirements Specification* (SRS) ini disusun untuk menetapkan spesifikasi kebutuhan perangkat lunak bagi platform **Sellon**. Dokumen ini menjadi acuan resmi bagi tim pengembang (*software engineers*), analis sistem, *quality assurance* (QA), dan pemangku kepentingan dalam memahami batasan, arsitektur antarmuka, serta landasan konseptual sistem Sellon sebelum masuk ke tahap perancangan detail dan implementasi fungsional menyeluruh.

### 1.2 Ruang Lingkup Produk (Product Scope)
**Sellon** adalah aplikasi berbasis web yang berfungsi sebagai wadah periklanan dan katalog pasar daring (*marketplace*) khusus bagi komunitas kampus (mahasiswa, dosen, dan staf). 

Fokus utama produk adalah memfasilitasi pertukaran informasi barang dan jasa di lingkungan kampus secara aman dan terorganisir. Sistem ini **tidak menyediakan layanan gerbang pembayaran terintegrasi (*integrated payment gateway*)** maupun mekanisme keranjang belanja (*checkout cart*). Alih-alih bertindak sebagai perantara finansial, Sellon berperan sebagai jembatan yang menghubungkan calon pembeli langsung dengan penjual melalui protokol komunikasi eksternal (WhatsApp) untuk kemudian melakukan transaksi tatap muka (*Cash on Delivery* / COD) di area kampus.

### 1.3 Definisi, Akronim, dan Singkatan (Definitions, Acronyms, and Abbreviations)
* **SRS / SKPL:** *Software Requirements Specification* / Spesifikasi Kebutuhan Perangkat Lunak.
* **Sellon:** Nama platform marketplace komunitas kampus yang dikembangkan.
* **COD (Cash on Delivery):** Metode transaksi pembayaran tunai yang diselesaikan secara langsung saat penjual dan pembeli bertemu secara fisik.
* **Guest / Pengunjung:** Pengguna yang mengakses sistem tanpa melakukan autentikasi login.
* **Registered User (User Terverifikasi):** Pengguna yang telah memiliki akun terdaftar dan berhasil melakukan verifikasi alamat surel kampus.
* **Seller / Store Admin:** Pengguna terverifikasi yang mengunggah dan mengelola katalog produk miliknya sendiri.
* **Deep Link:** Tautan protokol URL khusus yang langsung mengarahkan peramban pengguna untuk membuka aplikasi pesan instan pihak ketiga (WhatsApp Click-to-Chat).
* **CRUD:** *Create, Read, Update, Delete* (Operasi dasar manipulasi data).

### 1.4 Referensi (References)
* IEEE Std 830-1998, *IEEE Recommended Practice for Software Requirements Specifications*.
* ISO/IEC/IEEE 29148:2018, *Systems and software engineering — Life cycle processes — Requirements engineering*.
* Dokumentasi Resmi Framework Laravel 12.x (`https://laravel.com/docs/12.x`).
* Dokumen Riwayat User Story & Skenario Pengujian: `document/Software_Requirements_Document.md`.

### 1.5 Gambaran Umum Dokumen (Document Overview)
Dokumen ini disusun menjadi lima bab utama. Bab 1 memberikan pendahuluan dan konteks cakupan sistem. Bab 2 menguraikan gambaran umum produk, persona pengguna, dan batasan implementasi. Bab 3 dan Bab 4 dialokasikan secara khusus sebagai bagian spesifikasi kebutuhan fungsional dan non-fungsional. Bab 5 mendetailkan spesifikasi antarmuka eksternal perangkat lunak, mencakup antarmuka pengguna, perangkat keras, perangkat lunak penunjang, dan protokol komunikasi.

---

## 2. Deskripsi Umum (Overall Description)

### 2.1 Perspektif Produk (Product Perspective)
Sellon merupakan sistem perangkat lunak mandiri (*self-contained web application*) berbasis arsitektur client-server. Sistem dibangun menggunakan framework modern monolitik dengan pemisahan lapisan presentasi (Blade & Livewire), logika bisnis (Controllers & Eloquent ORM), serta penyimpanan data terpusat (MySQL).

Sellon beroperasi dalam ekosistem kampus dengan memanfaatkan infrastruktur komunikasi eksternal (WhatsApp) untuk interaksi langsung antara pengguna dan SMTP untuk notifikasi serta verifikasi surel institusi.

```
+-----------------------------------------------------------------------+
|                             KLIEN (BROWSER)                           |
|       [ Antarmuka Web Responsif: Blade, Tailwind CSS, Livewire ]      |
+-----------------------------------------------------------------------+
             |                                              |
      HTTPS Request /                             WhatsApp Direct Link
      Form Submissions                             (wa.me click-to-chat)
             |                                              |
             v                                              v
+-----------------------------+               +-------------------------+
|     SERVER APLIKASI         |               |     APLIKASI EKSTERNAL  |
|   Laravel 12 / PHP 8.2+     |               |         WHATSAPP        |
| - Routing & Middleware      |               |  (Komunikasi Penjual &  |
| - Autentikasi & Verifikasi  |               |        Pembeli)         |
| - Logika Bisnis & Sanitasi  |               +-------------------------+
+-----------------------------+
       |               |
  SQL Connection     SMTP Protocol
       v               v
+-------------+  +--------------------+
|  DATABASE   |  |    MAIL SERVER     |
| MySQL 8.x   |  | (Verifikasi Akun & |
|             |  |  Reset Password)   |
+-------------+  +--------------------+
```

### 2.2 Ringkasan Fungsi Utama Produk (Product Functions)
Secara garis besar, fungsionalitas utama yang disediakan oleh Sellon meliputi:
1. **Sistem Autentikasi dan Otorisasi Akun:**
   * Pendaftaran akun baru dengan validasi alamat surel institusi resmi kampus.
   * Mekanisme verifikasi alamat surel berbasis tautan berbatas waktu (*signed URL*).
   * Otentikasi masuk (*login*) dan keluar (*logout*) aman.
   * Pemulihan kata sandi (*forgot & reset password*) melalui pengiriman token via surel.
2. **Manajemen Katalog dan Produk (Product Management):**
   * Pembuatan, pembaruan, penampilan, dan penghapusan data produk oleh penjual yang berhak.
   * Pengelompokan produk berdasarkan kategori utama (*preloved, food, beverage, service*).
   * Pengelolaan informasi produk: foto, harga, deskripsi kondisi, dan penanda status ketersediaan.
3. **Pencarian, Penyaringan, dan Penjelajahan Katalog:**
   * Pencarian produk secara fleksibel berdasarkan kata kunci nama produk.
   * Penyaringan berdasarkan kategori barang/jasa dan pengurutan (*sorting*) berdasarkan harga atau waktu publikasi.
4. **Interaksi dan Penghubung Komunikasi Antar Pengguna:**
   * Fasilitasi kontak penjual menggunakan tombol aksi cepat yang membuka obrolan langsung WhatsApp dengan format pesan otomatis.
   * Fitur pemberian ulasan dan komentar pada produk.
   * Pengelolaan daftar produk favorit (*wishlist*) bagi pengguna terdaftar.
5. **Pengelolaan Profil Pengguna:**
   * Pembaharuan identitas profil, foto profil, dan nomor WhatsApp kontak transaksi.
   * Halaman etalase publik penjual (*seller store view*).

### 2.3 Karakteristik dan Penggolongan Pengguna (User Characteristics)
Pengguna sistem Sellon diklasifikasikan ke dalam 3 (tiga) peran utama:

| Peran Pengguna | Deskripsi & Hak Akses | Keterampilan Teknis yang Diharapkan |
| :--- | :--- | :--- |
| **Guest (Pengunjung Umum)** | Pengguna yang belum melakukan autentikasi ke dalam sistem. Memiliki akses hanya-baca (*read-only*) untuk menjelajahi katalog publik, melihat rincian barang, dan melihat ulasan. | Kemampuan dasar menggunakan peramban web (*web browser*). |
| **Pembeli Terverifikasi (Buyer)** | Mahasiswa atau sivitas akademika yang telah mendaftar dan memverifikasi alamat surel kampus. Dapat menandai produk favorit, menulis komentar/ulasan produk, dan mengakses tautan kontak WhatsApp penjual. | Pengoperasian aplikasi web dan kepemilikan aplikasi pesan instan WhatsApp aktif. |
| **Penjual (Seller / Store Admin)** | Mahasiswa atau sivitas akademika terverifikasi yang mengaktifkan etalase toko untuk menjual barang/jasa. Memiliki hak penuh untuk menambah, menyunting, dan menghapus produk miliknya sendiri, serta mengelola komentar pada produk miliknya. | Pemahaman dasar pengisian formulir digital dan manajemen gambar/foto produk. |

### 2.4 Batasan Desain dan Implementasi (Constraints)
* **Ketiadaan Gateway Pembayaran:** Sistem secara sadar tidak menyimpan data perbankan, saldo, dompet digital, atau memproses pembayaran digital apa pun. Seluruh transaksi moneter wajib diselesaikan secara mandiri di luar sistem Sellon.
* **Validasi Surel Institusi:** Sistem membatasi pendaftaran hanya bagi pemilik surel dengan domain resmi kampus yang telah ditentukan.
* **Kapasitas Unggah Media:** Berkas gambar/foto produk dibatasi maksimal 2 MB per unggahan untuk menjaga efisiensi penyimpanan server dan kecepatan waktu muat halaman.
* **Kepatuhan Perlindungan Data:** Sistem tidak menampilkan nomor telepon atau alamat surel penjual secara terbuka dalam bentuk teks bebas pada deskripsi publik untuk mencegah *scraping* dan penyalahgunaan data. Nomor telepon hanya diakses melalui parameter terenkapsulasi pada aksi tombol kontak.

### 2.5 Asumsi dan Ketergantungan (Assumptions and Dependencies)
* **Ketersediaan Layanan WhatsApp:** Sistem mengasumsikan pengguna penjual memiliki nomor telepon aktif yang terdaftar di platform WhatsApp, dan pengguna pembeli memiliki aplikasi WhatsApp terpasang pada perangkatnya atau dapat mengakses WhatsApp Web.
* **Layanan Pengiriman Surel (SMTP):** Fungsionalitas verifikasi akun dan reset kata sandi sangat bergantung pada keandalan server SMTP pihak ketiga atau infrastruktur surel kampus.
* **Perilaku Pengguna:** Pengguna diasumsikan beritikad baik dalam mematuhi aturan tata krama transaksi di lingkungan kampus serta menjaga kerahasiaan kredensial akun masing-masing.

---

## 3. Kebutuhan Fungsional (Functional Requirements)

> **Catatan:**  
> Sesuai dengan spesifikasi rencana penyusunan dokumen, bagian ini **dikosongkan** terlebih dahulu. Rincian spesifikasi kebutuhan fungsional (modul autentikasi, manajemen produk, filter katalog, interaksi ulasan, dan sistem profil) akan ditambahkan pada iterasi dokumen berikutnya.

---

## 4. Kebutuhan Non-Fungsional (Non-Functional Requirements)

> **Catatan:**  
> Sesuai dengan spesifikasi rencana penyusunan dokumen, bagian ini **dikosongkan** terlebih dahulu. Rincian spesifikasi kebutuhan non-fungsional (aspek keandalan, ketersediaan, waktu respons sistem, standar keamanan data, dan kepatuhan aksesibilitas peramban) akan ditambahkan pada iterasi dokumen berikutnya.

---

## 5. Antarmuka Eksternal (External Interfaces)

Spesifikasi kebutuhan antarmuka eksternal mencakup detail integrasi dan interaksi antara perangkat lunak Sellon dengan pengguna, perangkat keras, sistem perangkat lunak lain, serta protokol komunikasi jaringan.

### 5.1 Antarmuka Pengguna (User Interfaces)
Sistem menyediakan antarmuka grafis berbasis peramban web (*Web Graphical User Interface*) yang dirancang dengan prinsip *mobile-first* dan responsif di berbagai resolusi layar.

* **Karakteristik Tampilan UI:**
  * Dibangun menggunakan mesin template **Laravel Blade** dengan utilitas tata letak dari **Tailwind CSS**.
  * Dilengkapi dengan navigasi atas tetap (*sticky navigation bar*) yang menyediakan akses cepat ke menu Home, Katalog Kategori, Pencarian, Favorit Saya, Produk Saya, dan Profil.
  * Menggunakan palet warna modern yang konsisten, tipografi yang jelas, serta kartu produk (*product cards*) terstruktur yang memuat gambar utama, nama produk, kategori, harga berformat Rupiah, dan status stok.
* **Halaman Antarmuka Utama:**
  1. *Landing Page & Catalog View:* Menampilkan etalase produk unggulan, bilah pencarian, filter kategori, dan tombol pengurutan.
  2. *Authentication Pages:* Formulir masuk (*login*), pendaftaran akun (*register*), permohonan reset sandi, dan formulir kata sandi baru.
  3. *Email Verification Notice View:* Layar notifikasi yang menginstruksikan pengguna memeriksa kotak masuk surel serta menyediakan tombol kirim ulang surel verifikasi berbatas waktu (*rate-limited*).
  4. *Product Detail Page:* Menampilkan foto resolusi penuh, deskripsi detail, profil singkat penjual, tombol aksi cepat *Contact Seller* (WhatsApp), daftar ulasan pembeli, dan formulir pemberian komentar.
  5. *Product Management Form:* Formulir pembuatan dan penyuntingan produk dengan penanganan pratinjau foto langsung di sisi klien.
  6. *Profile & Store View:* Halaman publik dan privat untuk melihat riwayat dagangan penjual dan memperbarui biodata toko.
* **Penanganan Kesalahan Visual:**
  * Seluruh kesalahan input formulir (validasi sisi server) ditampilkan dalam bentuk pesan kesalahan kontekstual langsung di bawah masing-masing kolom masukan yang bermasalah.
  * Dilengkapi notifikasi *flash alert* atau *toast message* untuk konfirmasi operasi berhasil (misal: "Produk berhasil ditambahkan", "Profil berhasil diperbarui").

### 5.2 Antarmuka Perangkat Keras (Hardware Interfaces)
Sistem Sellon tidak terhubung secara langsung ke perangkat keras fisik khusus (*proprietary hardware*), melainkan beroperasi melalui antarmuka standar komputasi awan / server dan peramban klien.

* **Sisi Klien (Pengguna):**
  * Perangkat keras komputasi: Smartphone, tablet, laptop, atau komputer personal (PC).
  * Layar tampilan: Mendukung resolusi layar minimal 360 x 640 piksel (*viewport* smartphone standar) hingga resolusi desktop Full HD (1920 x 1080 piksel).
  * Perangkat masukan (*input device*): Layar sentuh (*touchscreen*), papan ketik (*keyboard*), dan tetikus (*mouse/touchpad*).
  * Kamera / Media Penyimpanan: Digunakan oleh penjual untuk memotret dan mengunggah gambar produk dari media penyimpanan lokal perangkat.
* **Sisi Server (Hosting / Infrastruktur):**
  * Prosesor: Arsitektur x86_64 atau ARM64 dengan minimal 1 vCPU (direkomendasikan 2 vCPU atau lebih untuk produksi).
  * Memori RAM: Minimal 1 GB (direkomendasikan minimal 2 GB untuk menunjang proses kompilasi aset Vite dan caching framework).
  * Media Penyimpanan: SSD / NVMe dengan kapasitas disesuaikan dengan volume pertumbuhan berkas media gambar produk (minimal alokasi awal 10 GB).

### 5.3 Antarmuka Perangkat Lunak (Software Interfaces)
Sellon berinteraksi dengan sejumlah komponen perangkat lunak dan pustaka (*libraries*) sistem:

| Komponen Perangkat Lunak | Versi / Spesifikasi | Fungsi & Peran Integrasi |
| :--- | :--- | :--- |
| **Sistem Operasi Server** | Linux (Ubuntu 22.04 LTS / Debian 12 disarankan) atau Windows Server | Lingkungan dasar eksekusi sistem operasi hosting. |
| **Web Server / Gateway** | Nginx, Apache HTTP Server, atau Laravel Octane / PHP Built-in Server | Menangani penerimaan permintaan HTTP/HTTPS dan meneruskannya ke PHP runtime. |
| **PHP Runtime Environment** | PHP Versi >= 8.2 | Mesin penerjemah bahasa utama untuk mengeksekusi logika backend aplikasi. Ekstensi wajib: `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `gd`/`imagick`, `curl`. |
| **Framework Backend** | **Laravel Framework versi 12.x** | Fondasi arsitektur MVC, ORM Eloquent, routing, proteksi CSRF, session handling, dan validasi data. |
| **Komponen Reaktif Frontend**| **Livewire versi 4.x** | Memfasilitasi interaktivitas antarmuka tanpa perlu memuat ulang seluruh halaman peramban. |
| **Database Management System** | **MySQL versi 8.0+** atau MariaDB versi 10.5+ | Penyimpanan data persisten relasional: tabel pengguna, produk, ulasan, favorit, dan sesi. |
| **Frontend Tooling & Bundler** | **Node.js (v18+) & Vite** | Mengompilasi dan mengoptimalkan aset skrip JavaScript dan utilitas CSS sebelum disajikan ke peramban. |
| **Mail Transport System** | SMTP Driver (Mailgun, Postmark, Google SMTP, atau Mailtrap untuk pengujian) | Pengiriman pesan surel verifikasi pendaftaran akun dan reset kata sandi. |

### 5.4 Antarmuka Komunikasi (Communications Interfaces)
Aplikasi Sellon mengandalkan standar protokol komunikasi jaringan terbuka untuk menghubungkan pengguna, server, dan pihak ketiga:

* **Protokol Web (HTTP / HTTPS):**
  * Seluruh pertukaran data antara peramban klien dan server aplikasi wajib menggunakan protokol aman **HTTPS** melalui port standar 443, dengan enkripsi TLS 1.2 atau TLS 1.3.
  * Transmisi data formulir menggunakan metode HTTP standar: `GET`, `POST`, `PUT`, dan `DELETE`.
  * Seluruh permintaan metode penulisan data (`POST`, `PUT`, `DELETE`) dilindungi oleh mekanisme keamanan **CSRF Token** (*Cross-Site Request Forgery*).
* **Integrasi WhatsApp Click-to-Chat (Deep Linking):**
  * Komunikasi langsung antara pembeli dan penjual memanfaatkan protokol URL scheme resmi WhatsApp:
    $$\text{URL: } \texttt{https://wa.me/\{nomor\_penjual\}?text=\{pesan\_otomatis\_terenkode\}}$$
  * Format nomor telepon secara otomatis dinormalisasi oleh sistem ke dalam kode negara internasional (misal: mengubah awalan `08` menjadi `628`).
  * Parameter pesan awal secara otomatis memuat konteks produk, mencakup nama produk dan tautan halaman rujukan agar penjual langsung mengenali produk yang ditanyakan oleh pembeli.
* **Protokol Surel (SMTP):**
  * Komunikasi pengiriman surel dari server aplikasi ke server pengirim surel dilakukan melalui protokol **SMTP** (*Simple Mail Transfer Protocol*) pada port 587 (STARTTLS) atau port 465 (SMTPS/SSL).
  * Pesan surel yang dikirimkan menggunakan format multipart MIME (teks polos dan HTML) yang memuat tautan aman bertanda tangan digital (*Signed URLs*) dengan waktu kedaluwarsa 60 menit.
