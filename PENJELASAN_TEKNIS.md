# Dokumentasi Standar Penulisan Kode (Coding Standard)

### Proyek: School Management System

Dokumen ini menjelaskan standar dan konvensi penulisan kode yang digunakan dalam pengembangan sistem ini. Tujuannya adalah untuk menjamin kualitas, keamanan, dan kemudahan perawatan (_maintainability_) sistem di masa depan.

## 1. Penggunaan Bahasa dalam Kode

Dalam pengembangan sistem ini, kami menerapkan **Standar Internasional** yang menggabungkan dua pendekatan bahasa:

### A. Logika & Fungsi (Bahasa Inggris)

Untuk logika pemrograman, fungsi, dan variabel sistem, kami menggunakan Bahasa Inggris.

- **Alasan**: Bahasa pemrograman (PHP, JavaScript, CSS) secara _native_ menggunakan sintaks Bahasa Inggris. Menggunakan variabel Bahasa Inggris menghindari kerancuan istilah dan mengikuti standar industri global.
- **Contoh dalam kode**:
  - `student_id`: Variabel untuk identitas unik siswa (standar global untuk _Unique Identifier_).
  - `calculate_percentage`: Fungsi untuk menghitung persentase nilai secara otomatis.
  - `get_status`: Fungsi logika untuk menentukan status LULUS atau GAGAL.

### B. Database & Tampilan (Bahasa Indonesia)

Untuk struktur penyimpanan data (_database_) dan tampilan yang dilihat pengguna (_User Interface_), kami menggunakan Bahasa Indonesia agar sesuai dengan konteks operasional sekolah.

- **Contoh**:
  - Tabel `nilai`, kolom `nama_siswa`, kolom `mata_pelajaran`.
  - Label tampilan: "Rekap Nilai", "Tahun Ajaran", "Kepala Sekolah".

## 2. Penggunaan Teknologi Tailwind CSS

Sistem ini dibangun menggunakan **Tailwind CSS**, sebuah kerangka kerja desain (_design framework_) modern yang paling populer saat ini.

- **Keunggulan**: Memungkinkan pembuatan antarmuka yang modern, responsif (bisa dibuka di HP/Laptop), dan ringan.
- **Istilah Teknis**: Karena Tailwind CSS adalah teknologi internasional, kode gaya (_styling_) menggunakan istilah Inggris baku seperti:
  - `text-center`: Untuk membuat teks rata tengah.
  - `bg-green-200`: Untuk memberikan latar warna hijau pada status Lulus.
  - `flex-row`: Untuk mengatur tata letak agar rapi secara horizontal.

## 3. Kesimpulan

Percampuran istilah (Inggris untuk _backend/logic_ dan Indonesia untuk _frontend/database_) adalah **praktik wajar dan profesional** dalam pembuatan perangkat lunak. Hal ini memastikan sistem Anda dibangun dengan fondasi yang kuat secara teknis namun tetap mudah digunakan oleh staf sekolah.
