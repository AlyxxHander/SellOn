Spesifikasi Kebutuhan Perangkat Lunak (SKPL)

User Story & Skenario Pengujian System
Platform Marketplace Kampus - Sellon

| Target Pembaca | Business Analyst (BA), Software Architect, QA Engineer & Developer |

| --- | --- |

| Versi Dokumen | 1.0 - Initial Draft |

| Status Sistem | Prototype Platform Marketplace Kampus |

| Tanggal Pembaruan | 28 September 2026 |

# DAFTAR ISI

DAFTAR ISI	2

1. Pendahuluan & Gambaran Umum Sistem	3

1.1 Latar Belakang	3

1.2 Arsitektur Sellon	3

1.3 Tujuan Dokumen	3

2. User Story, User Journey & Skenario Pengujian	3

2.1 Aktor: Penjual (Admin)	3

2.2 Aktor: Pembeli (Guest)	4

3. Aturan Bisnis Khusus (Business Rules)	5

3.1 Komunikasi Melalui Platform External:	5

3.2 Tidak Ada Nilai Finansial di Platform:	5

3.3 Verifikasi Identitas Pengguna:	6

3.4 Pencarian & Filter Produk:	6

4. Kebutuhan Non-Fungsional 	6

4.1 Functional Requirement

4.2. Non-Fungsional Requirement

4.3. Ruang Lingkup Sistem

5 Test Scenarios

5.1 Positive Test Scenarios

5.2. Negative Test Scenarios

6. Test Design Specification

6.1 Requirements

6.2 Feature Sets

6.3 Test Conditions

6.4 Coverage Items

6.5 Test Traceability Matrix (TTM)

6.6 Test Design Technique Summary

# 1. Pendahuluan & Gambaran Umum Sistem

## 1.1 Latar Belakang

Sellon adalah platform marketplace kampus yang memungkinkan penjual (admin) dan pembeli (guest), khususnya mahasiswa, untuk melakukan jual‑beli barang di lingkungan kampus. Platform ini tidak memiliki sistem checkout, tetapi memfasilitasi pertukaran kontak antara penjual dan pembeli yang tertarik. Platform ini dirancang untuk:

- Menyederhanakan proses transaksi antar mahasiswa tanpa kebutuhan pembayaran yang terintegrasi.

- Meningkatkan visibilitas barang di lingkungan kampus melalui katalog yang mudah diakses.

- Menjaga keamanan dengan memperkenalkan identitas kampus pada kedua belah pihak.

## 1.2 Arsitektur Sellon

Setiap toko memiliki ruang penyimpanan milik mereka sendiri. Semua data produk dan pengguna disimpan dalam skema database yang terpisah, sehingga data antar toko tidak dapat saling dilihat. Meskipun demikian, data berada dalam satu basis data utama yang terpusat untuk memudahkan manajemen dan pemantauan.

## 1.3 Tujuan Dokumen

Dokumen ini bertujuan untuk memberikan spesifikasi fungsional dan non‑fungsional yang lengkap serta user story untuk setiap aktor utama dalam ekosistem Sellon:

- Aktor Admin / Penjual: Mengelola katalog barang, mengatur detail produk, dan menanggapi permintaan pembeli.

- Aktor Guest / Pembeli: Menelusuri katalog barang, menghubungi penjual, dan mengatur pertemuan transaksi.

# 2. User Story, User Journey & Skenario Pengujian

Bagian ini merinci spesifikasi fungsional dalam format User Story, tahapan perjalanan pengguna (User Journey), serta kriteria penerimaan yang terbagi menjadi Skenario Utama (Main Acceptance Criteria) dan Skenario Edge Cases (Exception / Error Flow) untuk masing-masing aktor.

## 2.1 Aktor: Penjual (Admin)

| USER STORY & USER JOURNEY - PENJUAL (ADMIN) / User Story: Sebagai Penjual (Admin), saya ingin mengelola katalog barang, menambahkan deskripsi, harga, foto, serta menanggapi pembeli yang menghubungi, sehingga dapat menjual barang dengan mudah di dalam kampus. /  / User Journey: Admin masuk ke dashboard > Pilih Tambah Produk > Isi formulir > Simpan > Produk muncul di katalog > Pembeli menghubungi via tombol Contact Seller > Admin menerima notifikasi dan pesan pembeli via Whatsapp > Mengatur pertemuan transaksi > Selesai. |

| --- |

A. Skenario Pengujian Utama (Main Acceptance Criteria)

| No | Nama Skenario | Kondisi Awal (Given) | Tindakan (When) |

| --- | --- | --- | --- |

| 1 | Menambah Produk Baru | Admin berada di dashboard dan memilih Tambah Produk. | Mengisi semua bidang formulir dengan data valid dan menekan Simpan. |

| 2 | Mengedit Produk | Produk sudah ada di katalog. | Admin membuka detail produk, mengubah informasi, dan menekan Simpan. |

| 3 | Menghapus Produk | Produk ada di katalog. | Admin menekan tombol Hapus pada produk dan mengonfirmasi penghapusan. |

B. Skenario Edge Cases & Penanganan Pengecualian

| No | Skenario Edge Case | Kondisi Awal (Given) | Pemicu (When) |

| --- | --- | --- | --- |

| 1 | Foto Produk Melebihi Batas Ukuran | Admin mengupload foto berukuran > 2 MB. | Menyimpan produk. |

| 2 | Harga Negatif atau Nol | Admin memasukkan nilai harga ≤ 0. | Menyimpan produk. |

| 3 | Duplikasi Nama Produk | Produk dengan nama yang sama sudah ada. | Menambahkan produk baru dengan nama identik. |

## 2.2 Aktor: Pembeli (Guest)

| USER STORY & USER JOURNEY - PEMBELI (GUEST) / User Story: Sebagai Pembeli (Guest), saya ingin menelusuri katalog barang di kampus, melihat detail, dan menghubungi penjual melalui kontak yang disediakan, sehingga dapat mengatur transaksi secara langsung. /  / User Journey: Guest membuka halaman utama > Memfilter atau mencari produk > Memilih produk > Membuka halaman detail > Menekan tombol Contact Seller > Mengirim pesan > Penjual menerima notifikasi > Selesai. |

| --- |

A. Skenario Pengujian Utama (Main Acceptance Criteria)

| No | Nama Skenario | Kondisi Awal (Given) | Tindakan (When) |

| --- | --- | --- | --- |

| 1 | Menelusuri Katalog | Guest berada di halaman utama. | Memilih kategori atau menggunakan pencarian, hasil yang sesuai muncul. |

| 2 | Melihat Detail Produk | Guest memilih salah satu produk. | Membuka halaman detail dan melihat informasi lengkap (foto, deskripsi, harga, kontak). |

| 3 | Menghubungi Penjual | Guest berada di halaman detail produk. | Mengklik tombol Contact Seller, mengisi pesan, dan menekan Kirim. |

B. Skenario Edge Cases & Penanganan Pengecualian

| No | Skenario Edge Case | Kondisi Awal (Given) | Pemicu (When) |

| --- | --- | --- | --- |

| 1 | Tidak Ada Respon Penjual | Guest telah mengirim pesan kepada penjual. | Tidak ada balasan dalam 48 jam. |

| 2 | Kontak Penjual Tidak Tersedia | Produk tidak mencantumkan informasi kontak. | Guest menekan Contact Seller. |

| 3 | Gagal Mengirim Pesan Karena Koneksi | Guest berada pada jaringan tidak stabil. | Menekan Kirim pesan. |

# 3. Aturan Bisnis Khusus (Business Rules)

Berikut Aturan bisnis tingkat tinggi (High-Level Business Rules) yang diterapkan untuk menjaga kelancaran dan keamanan operasional marketplace Sellon:

## 3.1 Komunikasi Melalui Platform External:

Semua komunikasi antara penjual dan pembeli difasilitasi melalui tombol WhatsApp yang secara otomatis membuka chat WA penjual dengan nomor yang terdaftar pada profil penjual. Alamat email atau nomor telepon tidak ditampilkan secara langsung di deskripsi produk.

## 3.2 Tidak Ada Nilai Finansial di Platform:

Platform tidak memproses pembayaran. Penjual dan pembeli bertanggung jawab sepenuhnya untuk mengatur pertemuan fisik dan transaksi pembayaran secara offline. Platform tidak menanggung risiko kehilangan atau penipuan.

## 3.3 Verifikasi Identitas Pengguna:

Setiap akun pengguna (penjual maupun pembeli) harus terdaftar menggunakan email kampus resmi yang terverifikasi. Ini memastikan bahwa hanya anggota komunitas kampus yang dapat berpartisipasi.

## 3.4 Pencarian & Filter Produk:

Pada halaman katalog, pembeli dapat memfilter hasil pencarian berdasarkan preloved, food, beverage, dan service. Fitur ini telah diimplementasikan untuk memudahkan pengguna menemukan barang yang relevan dengan lingkungan akademik mereka.

# 4. Requirement 

## 4.1 Functional Requirements

Berikut adalah kebutuhan fungsional utama untuk proyek **Sellon** berdasarkan fitur yang diidentifikasi:

| No | Fitur | Kebutuhan Fungsional |
|---|-------|----------------------|
| 1 | **Login** | - Pengguna dapat memasukkan email kampus dan kata sandi untuk masuk ke sistem.<br>- Sistem melakukan validasi kredensial terhadap database.<br>- Setelah login berhasil, pengguna diarahkan ke dashboard yang sesuai dengan peran (Admin / Guest). |
| 2 | **Register** | - Pengguna baru dapat mendaftar dengan mengisi formulir yang mencakup nama, email kampus resmi, kata sandi, dan konfirmasi kata sandi.<br>- Email kampus harus diverifikasi (misalnya dengan link verifikasi).<br>- Setelah registrasi sukses, akun otomatis masuk (auto‑login) atau diarahkan ke halaman login. |
| 3 | **Forgot Password** | - Pengguna dapat meminta reset kata sandi dengan memasukkan email kampus terdaftar.<br>- Sistem mengirim tautan reset (atau kode OTP) ke email kampus.<br>- Pengguna dapat mengatur kata sandi baru melalui formulir yang aman. |
| 4 | **Profile Management** | - Pengguna dapat melihat dan mengubah data profil (nama, foto profil, nomor kontak yang ditampilkan secara terbatas).<br>- Admin dapat mengedit informasi toko (nama toko, deskripsi, logo).<br>- Semua perubahan disimpan ke database dan tercermin secara real‑time pada tampilan publik. |
| 5 | **Product Management** | - Admin dapat **menambah**, **mengedit**, dan **menghapus** produk.<br>- Setiap produk memiliki atribut: nama, deskripsi, foto (maks 2 MB), harga, kategori, dan status (tersedia / tidak tersedia).<br>- Sistem melakukan validasi (misalnya harga > 0, foto tidak melebihi ukuran). |
| 6 | **Comment Management** | - Pengguna (Guest) dapat menulis komentar pada halaman detail produk.<br>- Komentar harus melewati sanitasi untuk mencegah XSS.<br>- Admin dapat menghapus komentar yang tidak pantas. |
| 7 | **Filter and Sort System** | - Pengguna dapat memfilter produk berdasarkan kategori (preloved, food, beverage, service).<br>- Pengguna dapat mengurutkan hasil pencarian berdasarkan harga (naik/turun) atau tanggal penambahan). |
| 8 | **Favorites System** | - Pengguna dapat toggle produk sebagai favorit atau tidak.<br>- Daftar favorit disimpan per akun dan dapat diakses melalui halaman *Favorites*. |

## 4.2. Non-Fungsional Requirement

Selain pemenuhan kebutuhan fungsional, platform wajib memenuhi standar kualitas non-fungsional dan kenyamanan antarmuka pengguna (UX) sebagai berikut:

- Desain visual yang seragam: Warna, tipografi, dan ikon yang sama dipakai di seluruh halaman, menciptakan tampilan yang profesional, simpel, dan mudah dikenali.

- Navigasi yang selalu tersedia: Menu utama “sticky” tetap terlihat di bagian atas saat pengguna menggulir halaman, sehingga mereka dapat berpindah ke bagian lain kapan saja tanpa harus kembali ke atas.

- Aksesibilitas dasar: Semua tombol dan tautan dilengkapi label yang dapat dibaca pembaca layar, kontras warna cukup tinggi, dan dapat dioperasikan menggunakan keyboard.

- Pesan Kesalahan Ramah Pengguna: Sistem dilarang menampilkan istilah teknis yang membingungkan. Setiap kegagalan sistem harus ditranslasikan menjadi instruksi bahasa manusia yang ramah dan solutif.

## 4.3. Ruang Lingkup Sistem

**In Scope** (termasuk dalam pengembangan):
- Semua fitur yang tercantum pada Functional Requirements.
- Autentikasi dan otorisasi berbasis email kampus.
- Manajemen data produk, komentar, dan favorit.
- UI/UX responsif dengan desain modern.
- Integrasi tombol WhatsApp untuk menghubungi penjual (tanpa menampilkan nomor/email secara langsung).
- Validasi sisi klien dan sisi server untuk data input.
- Notifikasi untuk aktivitas penting (login, CRUD produk, pengiriman pesan).

**Out of Scope** (tidak termasuk dalam rencana saat ini):
- Sistem pembayaran atau checkout (platform tidak memproses transaksi finansial).
- Fitur marketplace lintas‑kampus atau multi‑tenant.
- Analitik lanjutan, rekomendasi produk berbasis AI.
- Pengelolaan inventaris otomatis atau integrasi dengan sistem ERP eksternal.

# 5 Test Scenarios

## 5.1 Positive Test Scenarios

| Feature | Expected Result |
|---|---|
| Login | Pengguna berhasil masuk dan diarahkan ke dashboard sesuai peran; bila kredensial salah muncul pesan error jelas. |
| Register | Akun baru dibuat, verifikasi email berhasil, dan pengguna otomatis masuk atau diarahkan ke halaman login. |
| Forgot Password | Email berisi tautan reset terkirim; pengguna dapat mengatur kata sandi baru dan login dengan kata sandi baru. |
| Profile Management | Perubahan profil tersimpan dan langsung terlihat pada halaman profil; admin dapat mengubah data toko. |
| Product Management | Produk dapat ditambah, diedit, dihapus; validasi harga >0 dan foto ≤2 MB; perubahan tercermin di katalog. |
| Comment Management | Komentar berhasil ditambahkan dan ditampilkan; admin dapat menghapus komentar tidak pantas. |
| Filter and Sort System | Produk difilter sesuai kategori dan diurutkan sesuai pilihan (harga, tanggal) dengan hasil yang tepat. |
| Favorites System | Produk ditoggle on atau off menjadi favorit pengguna. | 

## 5.2. Negative Test Scenarios

| Feature | Failure Scenario | Expected Failure Result |
|---|---|---|
| Login | Email atau password salah | Menampilkan pesan error “Kredensial tidak valid” dan tetap pada halaman login. |
| Register | Email sudah terdaftar | Menampilkan pesan error “Email sudah digunakan” dan meminta pengguna menggunakan email lain. |
| Forgot Password | Email tidak terdaftar | Menampilkan pesan error “The selected email is invalid.” tanpa mengirim tautan reset. |
| Profile Management | Upload foto melebihi 2 MB | Menampilkan pesan error “Ukuran foto terlalu besar” dan menolak penyimpanan. |
| Product Management | Harga ≤ 0 | Menampilkan pesan error “Harga harus lebih besar dari 0” dan menolak penyimpanan produk. |
| Comment Management | Komentar mengandung script berbahaya | Menolak komentar dan menampilkan pesan error “Komentar tidak diperbolehkan”. |
| Filter and Sort System | Hasil Filter kategori tidak ada | Menampilkan pesan “There is no product yet” dan menampilkan daftar kosong. |
| Favorites System | Tombol favorit tidak ditampilkan, jika belum melakukan autentikasi | Tombol favorit tidak ditampilkan |

# 6. Test Design Specification

## 6.1 Requirements
- RQ-001: Sistem harus memungkinkan pengguna melakukan login dengan kredensial yang valid.
- RQ-002: Sistem harus memungkinkan pengguna mendaftar dengan email unik dan melakukan verifikasi email.
- RQ-003: Sistem harus menyediakan fungsi forgot password yang mengirimkan tautan reset ke email terdaftar.
- RQ-004: Sistem harus memungkinkan pengguna mengelola profil termasuk mengunggah foto berukuran <2 MB.
- RQ-005: Sistem harus memungkinkan manajemen produk termasuk CRUD produk dengan harga > 0.
- RQ-006: Sistem harus memungkinkan komentar pada produk dengan sanitasi konten.
- RQ-007: Sistem harus menyediakan filter dan sort produk berdasarkan kategori.
- RQ-008: Sistem harus memungkinkan pengguna toggle produk menjadi produk favorit atau tidak.


## 6.2 Feature Sets
| ID | Feature Set | Objective | Priority | Traceability |
|---|---|---|---|---|
| FS1 | Login | Pengguna dapat masuk ke sistem | High | RQ-001 |
| FS2 | Register | Pengguna dapat membuat akun baru | High | RQ-002 |
| FS3 | Forgot Password | Pengguna dapat mereset password | High | RQ-003 |
| FS4 | Profile Management | Pengguna dapat mengelola profil | Medium | RQ-004 |
| FS5 | Product Management | Pengguna dapat mengelola produk | High | RQ-005 |
| FS6 | Comment Management | Pengguna dapat menulis komentar | Medium | RQ-006 |
| FS7 | Filter and Sort System | Pengguna dapat memfilter dan mengurutkan produk | Medium | RQ-007 |
| FS8 | Favorites System | Pengguna dapat toggle produk sebagai favorit atau tidak | Low | RQ-008 |

## 6.3 Test Conditions
| ID | Feature Set | Description | Priority | Traceability |
|---|---|---|---|---|
| TC1 | FS1 | Login dengan kredensial valid | High | RQ-001 |
| TC2 | FS1 | Login dengan kredensial salah | High | RQ-001 |
| TC3 | FS2 | Register dengan email baru dan verifikasi berhasil | High | RQ-002 |
| TC4 | FS2 | Register dengan email sudah terdaftar | High | RQ-002 |
| TC5 | FS3 | Forgot Password dengan email terdaftar | High | RQ-003 |
| TC6 | FS3 | Forgot Password dengan email tidak terdaftar | High | RQ-003 |
| TC7 | FS4 | Update profil dengan foto < 2 MB | Medium | RQ-004 |
| TC8 | FS4 | Upload foto > 2 MB | Medium | RQ-004 |
| TC9 | FS5 | Tambah produk dengan data valid | High | RQ-005 |
| TC10 | FS5 | Simpan produk dengan harga ≤ 0 | High | RQ-005 |
| TC11 | FS6 | Tambah komentar sesuai batas panjang huruf maksimum | Medium | RQ-006 |
| TC12 | FS6 | Tambah komentar melebihi batas panjang huruf maksimum | Medium | RQ-006 |
| TC13 | FS7 | Filter produk berdasarkan kategori yang ada | Medium | RQ-007 |
| TC14 | FS7 | Hasil Filter kategori tidak ada | Medium | RQ-007 |
| TC15 | FS8 | Toggle on & off produk menjadi produk favorite | Low | RQ-008 |

## 6.4 Coverage Items
| ID | Description | Related Test Condition | Priority | Traceability |
|---|---|---|---|---|
| CI1 | Verifikasi proses login berhasil | TC1 | High | RQ-001 |
| CI2 | Verifikasi penolakan login dengan kredensial salah | TC2 | High | RQ-001 |
| CI3 | Verifikasi registrasi berhasil dan verifikasi email | TC3 | High | RQ-002 |
| CI4 | Verifikasi penolakan registrasi dengan email duplikat | TC4 | High | RQ-002 |
| CI5 | Verifikasi proses reset password berhasil | TC5 | High | RQ-003 |
| CI6 | Verifikasi penolakan reset password untuk email tidak terdaftar | TC6 | High | RQ-003 |
| CI7 | Verifikasi update profil dan penyimpanan data | TC7 | Medium | RQ-004 |
| CI8 | Verifikasi penolakan upload foto terlalu besar | TC8 | Medium | RQ-004 |
| CI9 | Verifikasi CRUD produk dengan data valid | TC9 | High | RQ-005 |
| CI10 | Verifikasi validasi harga produk tidak boleh ≤ 0 | TC10 | High | RQ-005 |
| CI11 | Verifikasi penambahan komentar yang bersih | TC11 | Medium | RQ-006 |
| CI12 | Verifikasi sanitasi komentar berbahaya | TC12 | Medium | RQ-006 |
| CI13 | Verifikasi filter produk berdasarkan kategori yang ada | TC13 | Medium | RQ-007 |
| CI14 | Verifikasi penanganan filter kategori tidak ada | TC14 | Medium | RQ-007 |
| CI15 | Verifikasi toggle on & off menjadi produk favorit baru | TC15 | Low | RQ-008 |

## 6.5 Test Traceability Matrix (TTM)

| Requirement | Feature Set | Test Condition | Coverage Item |
|---|---|---|---|
| RQ-001 | FS1 | TC1 | CI1 |
| RQ-001 | FS1 | TC2 | CI2 |
| RQ-002 | FS2 | TC3 | CI3 |
| RQ-002 | FS2 | TC4 | CI4 |
| RQ-003 | FS3 | TC5 | CI5 |
| RQ-003 | FS3 | TC6 | CI6 |
| RQ-004 | FS4 | TC7 | CI7 |
| RQ-004 | FS4 | TC8 | CI8 |
| RQ-005 | FS5 | TC9 | CI9 |
| RQ-005 | FS5 | TC10 | CI10 |
| RQ-006 | FS6 | TC11 | CI11 |
| RQ-006 | FS6 | TC12 | CI12 |
| RQ-007 | FS7 | TC13 | CI13 |
| RQ-007 | FS7 | TC14 | CI14 |
| RQ-008 | FS8 | TC15 | CI15 |

## 6.6 Test Design Technique Summary

| Test Condition ID | Test Design Technique | Test Purpose |
|---|---|---|
| TC1 | Equivalence Partitioning (EP) | Verifikasi login berhasil dengan kredensial yang valid |
| TC2 | Equivalence Partitioning (EP) | Verifikasi login gagal dengan kredensial yang salah |
| TC3 | Equivalence Partitioning (EP) | Verifikasi registrasi berhasil dan verifikasi email |
| TC4 | Equivalence Partitioning (EP) | Verifikasi penolakan registrasi dengan email duplikat |
| TC5 | Equivalence Partitioning (EP) | Verifikasi pengiriman email reset password untuk email yang terdaftar |
| TC6 | Equivalence Partitioning (EP) | Verifikasi penanganan reset password untuk email yang tidak terdaftar |
| TC7 | Boundary Value Analysis (BVA) | Verifikasi pembaruan profil dengan ukuran foto yang dapat diterima |
| TC8 | Boundary Value Analysis (BVA) | Verifikasi penolakan pembaruan profil untuk foto yang terlalu besar |
| TC9 | Equivalence Partitioning (EP) | Verifikasi pembuatan produk dengan data yang valid |
| TC10 | Boundary Value Analysis (BVA) | Verifikasi penolakan pembuatan produk dengan harga non-positif |
| TC11 | Input Validation (IV) | Verifikasi penambahan komentar yang bersih |
| TC12 | Security Testing (ST) | Verifikasi sanitasi komentar yang mengandung script berbahaya |
| TC13 | Equivalence Partitioning (EP) | Verifikasi hasil filter produk berdasarkan kategori yang ada |
| TC14 | Equivalence Partitioning (EP) | Verifikasi penanganan filter kategori tidak ada |
| TC15 | Equivalence Partitioning (EP) | Verifikasi toggle on & off menjadi produk favorit baru |
