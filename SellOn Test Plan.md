# **Dokumen Rencana Pengujian (Test Plan)**

## ***SellOn — Campus Marketplace***

| Bidang | Detail |
| ----- | ----- |
| Identifikasi Test Plan | TP-SELLON-MOD1-[NIM] |
| Nama Aplikasi | SellOn |
| Versi | v1.0 |
| Peran yang Dipilih untuk Diuji | Admin (User yang telah melakukan autentikasi & verifikasi sehingga dapat mengakses seluruh fitur SellOn) |
| Nama Praktikan | [Diisi oleh praktikan] |
| NIM | [Diisi oleh praktikan] |
| Kelas | [Diisi oleh praktikan] |
| Tanggal Dibuat | 05 Oktober 2026 |
| Tanggal Terakhir Diperbarui | 05 Oktober 2026 |
| Status | Draft |

| Dokumen Referensi |
| :---- |
| Dokumen ini disusun berdasarkan template standar praktikum pengujian perangkat lunak dengan mengacu pada standar ISO/IEC/IEEE 29119-3. Seluruh konteks, item uji, risiko, dan lingkungan disesuaikan dengan arsitektur proyek SellOn. |

**Riwayat Revisi**

| Versi | Tanggal Revisi | Diperbarui Oleh | Deskripsi Perubahan |
| :---: | :---: | :---: | :---: |
| 1.0 | 05 Oktober 2026 | Praktikan | Draf awal Dokumen Test Plan proyek SellOn (Modul 1) |

---

# **DAFTAR ISI**

- [DAFTAR ISI](#daftar-isi)
- [1. Konteks Pengujian](#1-konteks-pengujian)
  - [1.1 Item Uji](#11-item-uji)
  - [1.2 Cakupan Pengujian](#12-cakupan-pengujian)
  - [1.3 Peran yang Dipilih untuk Diuji](#13-peran-yang-dipilih-untuk-diuji)
  - [1.4 Asumsi dan Batasan](#14-asumsi-dan-batasan)
- [2. Daftar Risiko](#2-daftar-risiko)
- [3. Strategi Pengujian](#3-strategi-pengujian)
  - [3.1 Pendekatan Keseluruhan](#31-pendekatan-keseluruhan)
  - [3.2 Arah Pengujian yang Direncanakan](#32-arah-pengujian-yang-direncanakan)
  - [3.3 Kriteria](#33-kriteria)
- [4. Lingkungan Pengujian](#4-lingkungan-pengujian)
  - [4.1 Perangkat dan Perangkat Keras](#41-perangkat-dan-perangkat-keras)
  - [4.2 Perangkat Lunak dan Alat](#42-perangkat-lunak-dan-alat)
  - [4.3 Jaringan dan Backend](#43-jaringan-dan-backend)
  - [4.4 Data Uji](#44-data-uji)
- [5. Jadwal Pengujian](#5-jadwal-pengujian)
- [6. Luaran Pengujian](#6-luaran-pengujian)
- [Lampiran A: Glosarium](#lampiran-a-glosarium)

---

# **1. Konteks Pengujian**

Dokumen kebutuhan awal merupakan salah satu item kesiapan yang akan digunakan pada Modul 2. Pada Modul 1, praktikan cukup mengidentifikasi sumber kebutuhan yang tersedia dan mulai melengkapinya secara bertahap; dokumen tersebut belum harus selesai pada modul ini.

## **1.1 Item Uji**

| Bidang | Deskripsi |
| :---: | ----- |
| Nama Aplikasi | SellOn |
| Platform | Web Application |
| Versi | v1.0 |
| URL Deployment / Akses | Lokal: `http://localhost:8000` <br> Staging / Demo: `https://sellon.infinityfreeapp.com/` |
| Tumpukan Teknologi | PHP 8.2+, Laravel 12.x, Blade Engine, Tailwind CSS 4.x, Vite 7.x, MySQL, Mailtrap SMTP |
| Deskripsi Singkat | SellOn adalah platform marketplace eksklusif kampus berbasis web yang memfasilitasi transaksi jual-beli barang dan jasa antar mahasiswa dengan verifikasi identitas sivitas akademika (NIM & email institusi) serta transaksi langsung via kontak WhatsApp tanpa sistem checkout rumit. |

## **1.2 Cakupan Pengujian**

### **Fitur dalam Cakupan (In-Scope)**

Pengujian mencakup delapan fitur lengkap: tiga fitur autentikasi utama dan lima fitur tambahan pilihan dengan fungsi dan skenario pengujian yang jelas.

| No. | Nama Fitur | Jenis Fitur | Deskripsi Singkat |
| :---: | :---: | :---: | :--- |
| 1 | Login | Fitur Autentikasi | Autentikasi pengguna menggunakan email institusi (`@webmail.umm.ac.id`) dan password untuk mendapatkan hak akses ke sistem. |
| 2 | Register | Fitur Autentikasi | Pendaftaran akun mahasiswa baru dengan validasi data diri lengkap (Nama, NIM 15 digit, Jurusan, Email institusi, No. WhatsApp, dan Password terenkripsi). |
| 3 | Forgot Password | Fitur Autentikasi | Permintaan reset kata sandi melalui pengiriman tautan token khusus ke email institusi pengguna dan pembaruan password baru. |
| 4 | Manajemen Profil (Profile Management) | Fitur Tambahan 1 | Pengelolaan data profil pengguna (melihat profil publik, memperbarui nama, jurusan, no. WhatsApp, serta pergantian email yang memicu re-verifikasi akun). |
| 5 | Manajemen Produk (Product Management - CRUD) | Fitur Tambahan 2 | Pengelolaan siklus hidup barang dagangan (tambah produk dengan multi-gambar hingga 6 foto, lihat detail produk, perbarui informasi dan foto, serta hapus produk). |
| 6 | My Favorites (Sistem Favorit) | Fitur Tambahan 3 | Fitur penandaan produk yang diminati dengan mekanisme *toggle* (tambah/hapus) secara real-time serta halaman daftar katalog favorit pengguna. |
| 7 | Sistem Filter dan Sorting Katalog | Fitur Tambahan 4 | Penelusuran produk melalui pencarian nama (*search*), penyaringan kategori (Preloved, Food, Beverage, Service) dengan penghitung dinamis, dan pengurutan harga/tanggal. |
| 8 | Dashboard Produk Saya (My Products) | Fitur Tambahan 5 | Antarmuka khusus penjual untuk memantau inventaris produk yang diunggahnya sendiri secara terpusat, dilengkapi filter internal dan jalan pintas aksi edit/hapus. |

> **Catatan Fitur Tambahan ke-5**: *Dashboard Produk Saya (My Products)* dipilih untuk melengkapi 5 fitur tambahan karena merepresentasikan fungsionalitas esensial bagi peran Admin (penjual) dalam memonitor, mengaudit stok, dan mengelola portofolio produk dagangannya sendiri secara mandiri.

### **Di Luar Cakupan (Out-of-Scope)**

| No. | Fitur / Aspek | Alasan Pengecualian |
| :---: | ----- | ----- |
| 1 | Sistem Checkout & Payment Gateway In-App | Aplikasi sengaja dirancang tanpa sistem pembayaran terintegrasi untuk menyederhanakan transaksi langsung antar mahasiswa via WhatsApp. |
| 2 | Manajemen Multi-Kampus / Domain Luar | Sistem dibatasi khusus untuk lingkungan internal kampus UMM (email `@webmail.umm.ac.id`), sehingga validasi domain email eksternal tidak didukung. |
| 3 | Otentikasi Dua Faktor (2FA) / Biometrik | Fitur ini belum diimplementasikan pada arsitektur versi v1.0 dan berada di luar ruang lingkup praktikum. |

## **1.3 Peran yang Dipilih untuk Diuji**

| Bidang | Detail |
| :---: | ----- |
| Nama Peran | Admin (User Terautentikasi & Terverifikasi) |
| Deskripsi Peran | Pengguna (mahasiswa penjual) yang telah memiliki akun aktif dan berhasil melewati tahap verifikasi email institusi. Peran ini memiliki hak penuh untuk mengelola barang dagangan pribadi, mengakses seluruh fitur katalog, menandai favorit, dan memperbarui profil akun. |
| Fitur yang Dapat Diakses | 1. Autentikasi (Login, Register, Logout, Forgot Password, Verifikasi Email)<br>2. Manajemen Produk Lengkap (Create, Read Detail, Update, Delete)<br>3. Dashboard Produk Saya (My Products)<br>4. Sistem Favorit & Halaman My Favorites<br>5. Sistem Filter, Pencarian, dan Pengurutan Katalog<br>6. Manajemen Profil Pribadi |
| Alasan Pemilihan | Peran Admin dipilih karena memiliki cakupan hak akses terluas (*full features*) pada sistem SellOn. Pengujian pada peran ini memungkinkan evaluasi menyeluruh terhadap seluruh operasi CRUD, validasi masukan data (BVA/EP), *state transition*, proteksi rute middleware (`auth` dan `verified`), serta aturan otorisasi kepemilikan data. |

## **1.4 Asumsi dan Batasan**

| Jenis | Deskripsi |
| :---: | ----- |
| Asumsi | Server lokal (PHP Artisan & MySQL) atau server staging aktif dan dapat diakses dengan stabil selama sesi pengujian. |
| Asumsi | Layanan pendukung eksternal (SMTP Brevo untuk pengiriman email notifikasi dan DiceBear API untuk avatar) beroperasi secara normal. |
| Asumsi | Penyimpanan file lokal telah terhubung melalui symbolic link storage (`php artisan storage:link`). |
| Batasan | Pengujian difokuskan secara konsisten hanya pada satu peran yaitu **Admin** (User Terautentikasi). |
| Batasan | Pengujian antarmuka dibatasi pada platform Web Application melalui browser desktop modern. |
| Batasan | Pengiriman email verifikasi dan reset password dibatasi oleh kuota pengiriman harian akun SMTP dan batasan *throttle* (maksimal 1 pengiriman per menit). |

---

# **2. Daftar Risiko**

Daftar risiko di bawah ini memetakan potensi masalah teknis produk maupun manajerial proyek pengujian.  
*Prioritas = Dampak × Kemungkinan (skala 1–5).*

| ID Risiko | Deskripsi Risiko | Jenis | Dampak | Kemungkinan | Prioritas | Strategi Mitigasi |
| :---: | :--- | :---: | :---: | :---: | :---: | :--- |
| **R-01** | Kegagalan pengiriman email reset password atau verifikasi akun akibat kuota/gangguan SMTP Brevo. | Produk | 4 | 3 | **12** | Menyiapkan konfigurasi fallback driver log mailer lokal (`MAIL_MAILER=log`) untuk pengujian otomatis dan memeriksa kuota SMTP sebelum pengujian manual. |
| **R-02** | Kegagalan unggah gambar produk akibat ukuran file melebihi 5MB atau format file tidak sesuai. | Produk | 4 | 3 | **12** | Melakukan validasi pengujian batas nilai (BVA) pada batas 5120 KB dan format MIME serta memverifikasi bahwa direktori storage publik memiliki izin tulis (*write permission*). |
| **R-03** | Akses manipulasi atau penghapusan produk milik pengguna lain oleh Admin lain melalui manipulasi ID rute (IDOR). | Produk | 5 | 2 | **10** | Memverifikasi secara ketat pengujian logika otorisasi backend (`Auth::id() !== $product->user_id`) yang harus mengembalikan status HTTP 403 Forbidden. |
| **R-04** | Ketidakkonsistenan jumlah penghitung produk (*category counter*) saat fitur pencarian dan filter kategori digabungkan. | Produk | 3 | 3 | **9** | Menguji query cloning pada `ProductController` guna memastikan penghitungan counter dieksekusi sebelum kondisi filter kategori diterapkan. |
| **R-05** | Waktu pelaksanaan praktikum terbatas untuk menguji seluruh lima fitur tambahan. | Proyek | 3 | 3 | **9** | Memprioritaskan pengujian manual berdasarkan prioritas risikonya. |
| **R-06** | Perubahan alamat email pada menu edit profil menyebabkan akun kehilangan status verifikasi tanpa notifikasi yang jelas bagi pengguna. | Produk | 4 | 2 | **8** | Menguji skenario pergantian email untuk memastikan sistem mereset `email_verified_at` menjadi `null` dan me-redirect pengguna ke halaman instruksi verifikasi dengan pesan peringatan. |

---

# **3. Strategi Pengujian**

## **3.1 Pendekatan Keseluruhan**

| Bidang | Deskripsi |
| ----- | ----- |
| Pendekatan Pengujian | \<Belum ditetapkan; dilengkapi pada modul berikutnya\> |
| Tingkat Pengujian | \<Belum ditetapkan; dilengkapi pada modul berikutnya\> |
| Jenis Pengujian Utama | \<Belum ditetapkan; dilengkapi pada modul berikutnya\> |
| Fitur Berprioritas Tinggi | Manajemen Produk (CRUD & Upload Gambar - R-02, R-03) dan Autentikasi / Forgot Password (R-01) |

## **3.2 Arah Pengujian yang Direncanakan**

Pada Modul 1, arah dan teknik pengujian belum perlu ditentukan. Bagian ini dilengkapi secara bertahap setelah materi terkait dipelajari pada modul berikutnya.

| Aspek | Status | Catatan |
| :---: | ----- | :---: |
| Arah dan Teknik Pengujian | \<Belum ditetapkan\> | Dilengkapi setelah materi terkait dipelajari pada modul berikutnya. |

## **3.3 Kriteria**

| Jenis Kriteria | Deskripsi |
| :---: | ----- |
| Kriteria Masuk | 1. Aplikasi SellOn dapat dijalankan secara lokal atau diakses di URL staging tanpa kegagalan konfigurasi.<br>2. Database MySQL terhubung dan migrasi tabel berada dalam versi mutakhir.<br>3. Akun uji peran Admin telah disiapkan dan dapat login ke dalam sistem. |
| Kriteria Keluar | 1. Seluruh skenario pengujian yang direncanakan telah selesai dieksekusi.<br>2. Seluruh insiden cacat (*defect*) dengan tingkat keparahan Kritis/Tinggi telah dicatat dan dilaporkan.<br>3. Laporan luaran pengujian Modul 1 telah terdokumentasi secara lengkap. |
| Kriteria Lolos | Hasil aktual yang dihasilkan oleh sistem sesuai dengan hasil yang diharapkan (*expected result*) pada spesifikasi kasus uji tanpa menimbulkan galat sistem tak tertangani. |
| Kriteria Gagal | Hasil aktual menyimpang dari hasil yang diharapkan, sistem memunculkan error 500, data gagal tersimpan ke database, atau terjadi kebocoran hak akses. |
| Pengujian Ulang | Kasus uji yang berstatus gagal dieksekusi kembali setelah perbaikan kode sumber dilakukan untuk memverifikasi penyelesaian masalah. |
| Pengujian Regresi | Pengujian ulang terhadap alur kerja utama (seperti autentikasi dan pembuatan produk) setelah adanya perubahan kode untuk memastikan tidak terjadi efek samping (*regression defect*). |

---

# **4. Lingkungan Pengujian**

## **4.1 Perangkat dan Perangkat Keras**

| Item | Detail |
| :---: | ----- |
| Jenis Perangkat | Laptop / PC Desktop |
| Processor | Intel Core i5 / AMD Ryzen 5 (atau setara) |
| RAM | 8 GB / 16 GB |
| Sistem Operasi | Windows 11 (64-bit) |

## **4.2 Perangkat Lunak dan Alat**

| Alat / Perangkat Lunak | Versi / Detail | Tujuan |
| :---: | ----- | :---: |
| Google Chrome / Microsoft Edge | Versi 125+ (Modern Web Browser) | Eksekusi pengujian antarmuka pengguna (UI) |
| VS Code / Antigravity IDE | Markdown Editor & Source Inspector | Dokumentasi Test Plan dan inspeksi kode sumber |
| Snipping Tool / Lightshot | Versi Terbaru | Pengambilan tangkapan layar bukti eksekusi uji |
| Laragon / XAMPP (Apache & MySQL) | PHP 8.2+, MySQL 8.0 / MariaDB 10.4 | Web server dan basis data lokal |
| phpMyAdmin / DBeaver | Database Client GUI | Verifikasi langsung data dan relasi pada database |

## **4.3 Jaringan dan Backend**

| Item | Detail |
| :---: | ----- |
| Jaringan | Koneksi internet stabil (Wi-Fi / Hotspot minimal 10 Mbps untuk koneksi SMTP Brevo & CDN Tailwind/DiceBear) |
| Backend / API | Laravel 12.x Web Routing & Controller, MySQL Database Engine |
| URL Dasar Pengujian | Lokal: `http://localhost:8000` <br> Staging / Demo: `https://sellon.infinityfreeapp.com/` |

## **4.4 Data Uji**

Identifikasi jenis data uji secara umum yang dibutuhkan. Kumpulan data uji secara detail akan disiapkan pada modul berikutnya.

| Jenis Data | Deskripsi |
| :---: | ----- |
| Akun Uji Valid | [Dikosongkan - Akan dimasukkan oleh praktikan secara otomatis] |
| Akun Uji Tidak Valid | • Email dengan format/domain non-institusi (contoh: `user@gmail.com`).<br>• Email yang belum terdaftar di sistem.<br>• Password salah atau kurang dari 5 karakter.<br>• Pendaftaran dengan NIM atau email yang sudah terdaftar sebelumnya (duplikasi data). |
| Contoh Data Input | • **Input Produk Valid**: Nama produk (`"Kemeja Flanel Uniqlo"`), Deskripsi barang, Harga di rentang valid (`Rp 75.000`), Stok (`3`), Kategori (`Preloved`), Kondisi (`Bekas - Baik`), 1–3 file gambar format JPEG/PNG berukuran < 2MB.<br>• **Input Produk Invalid (BVA/EP)**: Harga di bawah batas minimum (`Rp 5.000`) atau melebihi batas maksimum (`Rp 2.000.000`), stok bernilai negatif (`-1`), unggahan gambar melebihi kuota 6 file atau ukuran file > 5120 KB, kategori `Service` dengan pengisian stok fisik.<br>• **Input Profil**: Pembaruan nama lengkap, perubahan nomor WhatsApp format `08xxxxxxxxxx`, dan pembaruan email baru. |
| Data Uji Tambahan | \<Belum ditetapkan; dilengkapi pada modul berikutnya\> |

---

# **5. Jadwal Pengujian**

Pada Modul 1, isi hanya jadwal dan luaran yang memang ditetapkan untuk Modul 1. Detail Modul 2 sampai Modul 6 dan UAP tetap berupa placeholder sampai modul terkait dibahas dan ditetapkan.

| Modul | Aktivitas Pengujian Utama | Perkiraan Waktu | Luaran Utama |
| :---: | ----- | :---: | ----- |
| Modul 1 | Perencanaan pengujian, analisis risiko, dan registrasi proyek | Minggu 1 – 2 | Dokumen Test Plan dan entri registrasi proyek |
| Modul 2 | \<Belum ditetapkan\> | \<Belum ditetapkan\> | \<Belum ditetapkan\> |
| Modul 3 | \<Belum ditetapkan\> | \<Belum ditetapkan\> | \<Belum ditetapkan\> |
| Modul 4 | \<Belum ditetapkan\> | \<Belum ditetapkan\> | \<Belum ditetapkan\> |
| Modul 5 | \<Belum ditetapkan\> | \<Belum ditetapkan\> | \<Belum ditetapkan\> |
| Modul 6 | \<Belum ditetapkan\> | \<Belum ditetapkan\> | \<Belum ditetapkan\> |
| UAP | \<Belum ditetapkan\> | \<Belum ditetapkan\> | \<Belum ditetapkan\> |

---

# **6. Luaran Pengujian**

Pada Modul 1, luaran yang perlu diselesaikan adalah dokumen Test Plan dan entri registrasi proyek. Luaran, format, dan status untuk Modul 2 sampai Modul 6 serta UAP belum ditetapkan pada dokumen ini.

| Modul | Luaran | Format | Status |
| :---: | ----- | :---: | :---: |
| Modul 1 | Dokumen Test Plan | DOCX / PDF / MD | Selesai |
| Modul 1 | Entri Lembar Registrasi Proyek | Google Sheets | Sedang Berjalan |
| Modul 2 | \<Belum ditetapkan\> | \<Belum ditetapkan\> | \<Belum ditetapkan\> |
| Modul 3 | \<Belum ditetapkan\> | \<Belum ditetapkan\> | \<Belum ditetapkan\> |
| Modul 4 | \<Belum ditetapkan\> | \<Belum ditetapkan\> | \<Belum ditetapkan\> |
| Modul 5 | \<Belum ditetapkan\> | \<Belum ditetapkan\> | \<Belum ditetapkan\> |
| Modul 6 | \<Belum ditetapkan\> | \<Belum ditetapkan\> | \<Belum ditetapkan\> |
| UAP | \<Belum ditetapkan\> | \<Belum ditetapkan\> | \<Belum ditetapkan\> |

---

| Lampiran A: Glosarium |
| :---: |

Istilah kunci yang digunakan dalam dokumen ini, berdasarkan ISO/IEC/IEEE 29119-1:

| Istilah | Definisi |
| :---: | ----- |
| **Item Uji** | Objek yang diuji. Dalam praktikum ini, objek tersebut adalah aplikasi web atau mobile yang dipilih oleh masing-masing praktikan. |
| **Dasar Pengujian** | Sumber diturunkannya sebuah *test condition*, dapat berupa kebutuhan, user story, atau perilaku yang sudah disepakati. |
| **Kondisi Pengujian** | Aspek dari aplikasi yang dapat diuji secara spesifik, dan menjadi dasar penulisan *test case*. |
| **Kasus Uji** | Input konkret, langkah-langkah, dan hasil yang diharapkan, yang digunakan untuk memeriksa satu *test condition*. |
| **Lingkungan Pengujian** | Perangkat, software, dan akses yang dibutuhkan untuk benar-benar menjalankan pengujian. |
| **Risk** | Kemungkinan terjadinya suatu masalah, baik pada produk itu sendiri (Risiko Produk) maupun pada proyek di sekitarnya, seperti tenggat waktu yang ketat (Risiko Proyek). |
| **Incident** | Segala sesuatu yang tidak terduga yang ditemukan selama pengujian dan perlu ditelusuri lebih lanjut. |
| **Traceability** | Kemampuan untuk menelusuri hubungan dari sebuah kebutuhan, ke sebuah fitur, hingga ke *test case* yang memeriksanya. |
| **Dampak** | Seberapa serius akibat yang akan timbul apabila sebuah risiko benar-benar terjadi, dinilai dengan skala 1 sampai 5. |
| **Kemungkinan** | Seberapa besar kemungkinan sebuah risiko benar-benar terjadi, dinilai dengan skala 1 sampai 5. |
| **Prioritas** | Tingkat kepentingan suatu risiko secara keseluruhan, dihitung sebagai Dampak dikalikan Kemungkinan. Digunakan untuk menentukan risiko mana yang perlu ditangani lebih dulu. |
| **Strategi Mitigasi** | Tindakan yang direncanakan untuk mengurangi dampak suatu risiko atau kemungkinan risiko tersebut terjadi. |
| **Kriteria Masuk** | Kondisi yang harus terpenuhi sebelum pengujian dapat dimulai. |
| **Kriteria Keluar** | Kondisi yang menandakan bahwa pengujian telah selesai. |
