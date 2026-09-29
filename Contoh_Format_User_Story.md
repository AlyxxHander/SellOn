# Spesifikasi Kebutuhan Perangkat Lunak (SKPL)
## User Story & Skenario Pengujian Sistem
### Platform Penerimaan Peserta Didik Baru (PPDB) Terpadu Multi-Tenant

| Atribut Dokumen | Keterangan Spesifikasi |
| :--- | :--- |
| **Target Pembaca** | Business Analyst (BA), Software Architect, QA Engineer & Developer |
| **Versi Dokumen** | 2.0 — Updated: Matriks Skenario Tanpa Kolom 'Then' |
| **Status Sistem** | Platform Multi-Tenant Terpadu (Sekolah, Yayasan & Perguruan Tinggi) |
| **Tanggal Pembaruan** | 22 September 2026 |

---

## 1. Pendahuluan & Gambaran Umum Sistem

Platform Penerimaan Peserta Didik Baru (PPDB) Terpadu merupakan sistem berbasis SaaS multi-tenant yang dirancang untuk membantu institusi pendidikan (sekolah, yayasan, dan perguruan tinggi) mengelola seluruh siklus penerimaan siswa atau mahasiswa baru secara daring. Sistem ini mengeliminasi kendala operasional, pemborosan waktu, serta biaya tinggi yang umum terjadi saat musim penerimaan peserta didik.

### 1.1 Arsitektur Multi-Tenant & Branding Institusi
Setiap institusi terdaftar dilayani dalam satu platform terpusat namun memiliki halaman pendaftaran khusus yang terisolasi secara visual dan fungsional. Halaman tersebut dilengkapi domain/subdomain independen, logo instansi, serta skema warna merek masing-masing. Seluruh alur kerja—mulai dari pendaftaran, pembayaran tagihan, unggah dokumen, verifikasi, hingga pengumuman kelulusan—terintegrasi secara *seamless*.

### 1.2 Matriks Peran & Aktor Sistem

| Aktor / Persona | Peran Utama | Fokus Operasional & Kebutuhan |
| :--- | :--- | :--- |
| **Superadmin** | Pengelola Platform Pusat | Mendaftarkan instansi, mengelola skema potongan biaya, pemantauan kesehatan platform, dan isolasi/pembekuan instansi penunggak. |
| **Admin Instansi** | Pengelola Sekolah/Kampus | Kustomisasi halaman branding, konfigurasi gelombang & kuota pendaftaran, formulir kustom, manajemen verifikator, dan ekspor laporan. |
| **Pendaftar** | Calon Peserta Didik | Pengisian data pribadi, draf otomatis, pengunggahan berkas ijazah/sertifikat, pembayaran tagihan bank, dan pemantauan kartu ujian & kelulusan. |
| **Verifikator** | Tim Penyeleksi Berkas | Verifikasi berkas *real-time* tanpa *download*, *approval* cepat, penolakan dengan catatan revisi, dan pencegahan manipulasi dokumen. |

---

## 2. User Story, User Journey & Skenario Pengujian

Bagian ini merinci spesifikasi fungsional dalam format User Story, tahapan perjalanan pengguna (User Journey), serta kriteria penerimaan yang terbagi menjadi Skenario Utama (*Happy Path / Main Flow*) dan Skenario Edge Cases (*Exception / Error Flow*) untuk masing-masing aktor. Sesuai preferensi analisis, tabel skenario berfokus pada kondisi prasyarat (**Given**) dan tindakan pemicu (**When**).

### 2.1 Aktor: Pengelola Platform (Superadmin)

> **User Story:**
> Sebagai Superadmin Platform, saya ingin mendaftarkan institusi baru, mengatur potongan biaya sewa/platform, memantau kesehatan sistem, dan membekukan institusi bermasalah agar operasional platform berjalan aman dan menguntungkan.
>
> **User Journey:**
> Superadmin masuk ke dasbor utama $\rightarrow$ Mendaftarkan nama instansi & reservasi subdomain $\rightarrow$ Sistem mengirimkan kredensial otomatis via email $\rightarrow$ Superadmin mengatur persentase potongan biaya per instansi $\rightarrow$ Memantau kesehatan transaksi pembayaran $\rightarrow$ Melakukan pembekuan halaman pendaftaran jika terjadi penunggakan biaya sewa.

#### A. Skenario Pengujian Utama (Main Acceptance Criteria)

| No | Nama Skenario | Kondisi Awal (Given) | Tindakan (When) |
| :-: | :--- | :--- | :--- |
| 1 | Mendaftarkan Institusi Baru | Superadmin berada di halaman manajemen institusi. | Menginput nama institusi 'Universitas A' & subdomain 'univa'. |
| 2 | Mencegah Alamat Web Kembar | Subdomain 'univa' telah terdaftar aktif di database. | Mencoba membuat institusi baru dengan subdomain 'univa'. |
| 3 | Membekukan Institusi | Institusi 'Universitas A' berstatus aktif. | Menekan tombol 'Bekukan' dan memasukkan alasan penangguhan. |

#### B. Skenario Edge Cases & Penanganan Pengecualian

| No | Skenario Edge Case | Kondisi Awal (Given) | Pemicu (When) |
| :-: | :--- | :--- | :--- |
| 1 | Penolakan Nama Web Terlarang | Superadmin mencoba mendaftarkan subdomain cadangan sistem. | Menginput nama subdomain 'admin' atau 'api' lalu simpan. |
| 2 | Pencegahan Nama Web Tidak Baku | Formulir pendaftaran institusi terbuka. | Menginput nama subdomain menggunakan spasi/huruf kapital. |
| 3 | Pemulihan Otomatis Saat Email Gagal | Proses pendaftaran institusi sedang berjalan. | Layanan surel (*email gateway*) mengalami gangguan/down. |

---

### 2.2 Aktor: Pengelola Institusi (Admin Instansi)

> **User Story:**
> Sebagai Admin Instansi, saya ingin mengatur tampilan halaman pendaftaran, menentukan jadwal gelombang & kuota, membuat pertanyaan kustom pada formulir, mengelola akun verifikator, dan mengunduh laporan pendaftar agar penerimaan siswa baru berjalan sesuai aturan sekolah/kampus.
>
> **User Journey:**
> Admin masuk ke dasbor instansi $\rightarrow$ Mengatur warna merek & logo $\rightarrow$ Menentukan jadwal buka-tutup gelombang & kuota $\rightarrow$ Menambahkan kolom pertanyaan khusus (nilai rapor, ukuran baju) $\rightarrow$ Membuat akun verifikator $\rightarrow$ Mengunduh laporan pendaftar berformat *spreadsheet* di akhir gelombang.

#### A. Skenario Pengujian Utama (Main Acceptance Criteria)

| No | Nama Skenario | Kondisi Awal (Given) | Tindakan (When) |
| :-: | :--- | :--- | :--- |
| 1 | Penyesuaian Warna Aman (Kontras) | Admin berada di menu Pengaturan Tampilan Halaman. | Memilih warna latar belakang cerah (misal: kuning). |
| 2 | Membuat Pertanyaan Khusus | Admin sedang menyunting struktur formulir pendaftaran. | Menambahkan kolom unggah 'Sertifikat Lomba' (Max 2MB). |
| 3 | Mengunduh Laporan Bersih | Terdapat ratusan pendaftar dengan isian formulir kustom. | Menekan tombol 'Unduh Laporan Pendaftar'. |

#### B. Skenario Edge Cases & Penanganan Pengecualian

| No | Skenario Edge Case | Kondisi Awal (Given) | Pemicu (When) |
| :-: | :--- | :--- | :--- |
| 1 | Pencegahan Tanggal Terbalik | Admin sedang mengatur jadwal gelombang pendaftaran. | Memasukkan tanggal penutupan lebih awal dari tanggal pembukaan. |
| 2 | Penangkalan Berkas Logo Berbahaya | Admin mengunggah logo kampus di menu branding. | Mengunggah berkas *executable*/script yang disamarkan sebagai gambar. |
| 3 | Pembersihan Rumus Formula Bahaya | Pendaftar menginput nama dengan rumus *spreadsheet* (*Formula Injection*). | Admin mengunduh laporan pendaftar versi Excel/CSV. |

---

### 2.3 Aktor: Pendaftar (Calon Peserta Didik)

> **User Story:**
> Sebagai Calon Peserta Didik, saya ingin membaca informasi pendaftaran, mengisi data diri & dokumen, membayar biaya pendaftaran via bank, serta melihat pengumuman kelulusan agar dapat diterima di institusi impian.
>
> **User Journey:**
> Pendaftar membuka situs pendaftaran kampus $\rightarrow$ Memilih prodi & membaca syarat $\rightarrow$ Mengisi biodata & unggah berkas $\rightarrow$ Memeriksa ringkasan $\rightarrow$ Menyetujui *submit* data $\rightarrow$ Menerima *invoice* pembayaran $\rightarrow$ Membayar via bank $\rightarrow$ Status otomatis lunas $\rightarrow$ Mengunduh kartu ujian & memantau hasil verifikasi.

#### A. Skenario Pengujian Utama

| No | Nama Skenario | Kondisi Awal (Given) | Tindakan (When) |
| :-: | :--- | :--- | :--- |
| 1 | Penyimpanan Draf Otomatis | Pendaftar sedang menginput biodata pada Langkah 2. | Peramban (*browser*) tidak sengaja tertutup/crash. |
| 2 | Pencegahan Submit Ganda | Pendaftar berada di langkah konfirmasi akhir. | Menekan tombol 'Kirim Pendaftaran' 3 kali secara cepat. |
| 3 | Pembayaran Berhasil Otomatis | Pendaftar memiliki tagihan aktif ber-VA. | Pendaftar melunasi tagihan melalui perbankan/VA. |
| 4 | Mendapatkan Tagihan Baru | Tagihan pendaftar telah melewati masa berlaku 24 jam. | Menekan tombol 'Minta Tagihan Baru'. |

#### B. Skenario Edge Cases & Penanganan Kondisi Invalid

| No | Skenario Edge Case | Kondisi Awal (Given) | Pemicu (When) |
| :-: | :--- | :--- | :--- |
| 1 | Pemutusan Internet saat Unggah | Pendaftar sedang mengunggah berkas ijazah ukuran besar. | Koneksi internet terputus di tengah proses unggah. |
| 2 | Perebutan Sisa Kuota Terakhir | Sisa kuota prodi tinggal 1, ada 2 pendaftar *submit* bersamaan. | Pendaftar A *submit* 0.1 detik lebih cepat dibanding Pendaftar B. |
| 3 | Pendeteksian Pemalsuan Ekstensi | Pendaftar diwajibkan mengunggah dokumen PDF/Gambar. | Pendaftar mengubah ekstensi file video `.mp4` menjadi `.pdf`. |

---

### 2.4 Aktor: Verifikator (Tim Penyeleksi)

> **User Story:**
> Sebagai Verifikator, saya ingin melihat antrean pendaftar, mencocokkan biodata dengan foto dokumen secara langsung, menyetujui pendaftar valid, atau meminta revisi jika berkas tidak terbaca agar proses seleksi berjalan cepat dan jujur.
>
> **User Journey:**
> Verifikator membuka dasbor seleksi (Layar terpisah: Daftar nama di kiri, *Preview* dokumen di kanan) $\rightarrow$ Memeriksa dokumen tanpa unduh $\rightarrow$ Menekan tombol 'Lolos' $\rightarrow$ Sistem otomatis lompat ke pendaftar berikutnya $\rightarrow$ Jika dokumen buram, tekan 'Tolak' & ketik catatan revisi.

#### A. Skenario Pengujian Utama

| No | Nama Skenario | Kondisi Awal (Given) | Tindakan (When) |
| :-: | :--- | :--- | :--- |
| 1 | Tampilan Berkas Langsung | Verifikator berada di halaman antrean seleksi. | Memilih salah satu nama pendaftar di panel kiri. |
| 2 | Lolos Pemeriksaan Cepat | Verifikator sedang memeriksa berkas pendaftar urutan pertama. | Menekan tombol 'Loloskan Berkas'. |
| 3 | Pemeriksaan Menyicil (*Early Review*) | Pendaftar telah mengunggah berkas tetapi belum bayar tagihan. | Verifikator memeriksa dan menyetujui berkas. |
| 4 | Pencegahan Kecurangan Berkas | Pendaftar telah lolos verifikasi berkas lebih awal. | Pendaftar mencoba mengganti berkas unggahan secara paksa. |

#### B. Skenario Edge Cases & Penanganan Pengecualian

| No | Skenario Edge Case | Kondisi Awal (Given) | Pemicu (When) |
| :-: | :--- | :--- | :--- |
| 1 | Pencegahan Penolakan Tanpa Alasan | Dokumen pendaftar buram/tidak terbaca. | Verifikator menekan tombol 'Tolak' tanpa mengisi catatan. |
| 2 | Pemulihan Dokumen Gagal Muat | Verifikator membuka detail pendaftar. | Terjadi gangguan jaringan dari *cloud storage* saat muat dokumen. |
| 3 | Penanganan Akses Halaman Kosong | Total antrean pendaftar hanya ada 3 halaman. | Verifikator mengubah URL secara manual ke halaman 100. |

---

## 3. Aturan Bisnis Khusus

Guna menjamin integritas data, kedaulatan finansial instansi, serta kepatuhan tata kelola penerimaan peserta didik, sistem menerapkan aturan bisnis tingkat tinggi (*High-Level Business Rules*) berikut:

* **3.1 Immutabilitas Data Tersubmit (*Data Locking*):** Seketika pendaftar menekan tombol konfirmasi final ('Kirim Pendaftaran'), seluruh isian formulir dan dokumen unggahan terkunci dalam status *Read-Only*. Data tidak dapat disunting kembali oleh pendaftar kecuali jika Verifikator memberikan status 'Minta Perbaikan' beserta catatan resmi.
* **3.2 Isolasi Finansial & Auto-Split Tenant:** Seluruh dana pembayaran biaya pendaftaran yang dilakukan pendaftar disalurkan langsung ke rekening perbankan resmi institusi yang bersangkutan. Potongan biaya platform/sewa dihitung dan dipisah secara otomatis oleh sistem *gateway* tanpa mencampuradukkan aliran dana antar-institusi.
* **3.3 Masa Berlaku Tagihan & Kadaluarsa Virtual Account:** Setiap kode tagihan/Virtual Account memiliki batas waktu aktif maksimal 24 jam. Apabila melewati batas waktu tersebut, nomor bayar otomatis mati (*expired*) untuk mencegah risiko kesalahan rekonsiliasi transfer dari pendaftar.

---

## 4. Kebutuhan Non-Fungsional & Standar Pengalaman Pengguna (UX)

Selain pemenuhan kebutuhan fungsional, platform wajib memenuhi standar kualitas non-fungsional dan kenyamanan antarmuka pengguna (UX) sebagai berikut:

* **Keandalan Akses & High Concurrency:** Sistem harus tetap responsif (*response time* $< 2$ detik) dan stabil meskipun diakses secara bersamaan oleh puluhan ribu pendaftar pada hari pertama pembukaan gelombang pendaftaran.
* **Desain Responsif & Layar Sentuh Mobile:** Antarmuka formulir pendaftaran dirancang responsif (*Mobile-First Design*) sehingga nyaman diisi melalui *smartphone* tanpa ada tombol, tabel, atau inputan yang terpotong.
* **Efisiensi Aksesibilitas Keyboard (*Shortcut Navigation*):** Antarmuka verifikator mendukung navigasi penuh menggunakan papan ketik (tombol panah, Tab, Enter, dan *hotkey approval*) agar proses penyeleksian ribuan dokumen dapat dilakukan dengan sangat cepat tanpa bergantung pada *mouse*.
* **Pesan Kesalahan Ramah Pengguna (*Non-Technical Error Messages*):** Sistem dilarang menampilkan *stack trace*, kode error 500, atau istilah teknis yang membingungkan. Setiap kegagalan sistem harus ditranslasikan menjadi instruksi bahasa manusia yang ramah dan solutif (misal: *"Koneksi internet Anda terputus, silakan periksa sambungan Anda dan tekan Muat Ulang"*).