# 🥥 Sistem Informasi Penjualan Es Kelapa (Aplikasi Es Kelapa)

Sistem Informasi Penjualan Es Kelapa adalah aplikasi berbasis web yang dibangun menggunakan Laravel. Aplikasi ini dirancang untuk mendigitalisasi dan memudahkan proses pengelolaan bisnis penjualan air kelapa atau es kelapa, mulai dari manajemen stok bahan baku, pencatatan transaksi penjualan harian, hingga penyerahan laporan pendapatan secara terstruktur.

---

## Fitur Utama

### Autentikasi & Manajemen Pengguna
*   **Sistem Hak Akses:** Pembatasan akses fitur yang aman antara pemilik bisnis (owner) dan kasir/petugas operasional.
*   **Kontrol Peran:** Memastikan pencatatan penjualan dan pengelolaan stok hanya bisa diakses oleh pengguna yang memiliki otoritas.

### Pengelolaan Stok & Bahan Baku
*   **Manajemen Produk:** Menambah, mengubah, dan memantau ketersediaan varian menu es kelapa beserta harganya.
*   **Pelacakan Bahan Baku:** Memantau sisa stok kelapa muda, sirup, gula, dan bahan pendukung lainnya untuk menghindari kekurangan persediaan.

### Manajemen Transaksi Penjualan
*   **Input Penjualan Instan:** Antarmuka kasir yang cepat untuk mencatat pesanan pelanggan secara real-time.
*   **Kalkulasi Otomatis:** Menghitung total belanjaan, jumlah kembalian, dan memotong stok bahan baku secara otomatis saat transaksi berhasil.
*   **Riwayat Transaksi:** Menyimpan log kronologis seluruh nota penjualan yang pernah diterbitkan.

### Pelaporan & Analisis Pendapatan
*   **Dashboard Grafik:** Memvisualisasikan statistik penjualan harian atau bulanan secara interaktif untuk memantau produk terlaris.
*   **Penyusunan Laporan:** Mengekspor laporan omzet dan keuntungan bersih ke dalam format PDF atau Excel untuk mempermudah evaluasi bisnis.

---

## Teknologi yang Digunakan

*   **Laravel Framework:** Framework PHP utama untuk menangani arsitektur dan logika bisnis aplikasi.
*   **Vite:** Asset bundler frontend modern untuk proses pengembangan yang cepat.
*   **Bootstrap CSS:** Framework UI untuk memastikan tampilan aplikasi responsif di perangkat komputer maupun tablet kasir.
*   **MySQL Database:** Menyimpan data master produk, stok bahan baku, serta seluruh rekam jejak transaksi penjualan.

---

## Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di komputer lokal Anda:

1. **Clone repositori**
```bash
   git clone [https://github.com/yonard1/Es_kelapa.git](https://github.com/yonard1/Es_kelapa.git)
   cd Es_kelapa
