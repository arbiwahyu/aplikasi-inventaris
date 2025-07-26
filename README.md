# Aplikasi Web Manajemen Inventaris

![Screenshot Aplikasi](URL_SCREENSHOT_ANDA)

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel 12">
  <img src="https://img.shields.io/badge/Tailwind_CSS-4-38B2AC?style=for-the-badge&logo=tailwind-css" alt="Tailwind CSS 4">
  <img src="https://img.shields.io/badge/MySQL-8-4479A1?style=for-the-badge&logo=mysql" alt="MySQL 8">
</p>

Aplikasi ini adalah sistem manajemen inventaris berbasis web yang dirancang untuk membantu perusahaan dalam mengelola, melacak, dan memonitor aset atau barang inventaris secara efisien. Dibangun dengan tumpukan teknologi modern, aplikasi ini menawarkan antarmuka yang bersih dan fungsionalitas yang lengkap untuk keperluan internal.

---

## **✨ Fitur Utama**

* **Manajemen Data Master (CRUD):** Mengelola data Barang, Lokasi, dan Kategori secara penuh.
* **Pelacakan Barang Detail:** Setiap barang memiliki atribut lengkap seperti kode unik, tanggal beli, kondisi, dan gambar.
* **Sistem Peminjaman & Pengembalian:** Fitur untuk meminjam dan mengembalikan barang, dengan status yang otomatis ter-update.
* **Cetak Label & QR Code:** Menghasilkan label dengan QR Code yang unik untuk setiap barang agar mudah diidentifikasi.
* **Laporan Fleksibel:** Filter laporan barang berdasarkan Lokasi dan rentang Tanggal Pembelian.
* **Pengecekan Ketersediaan:** Melihat daftar barang yang tersedia pada tanggal tertentu di masa depan untuk membantu perencanaan.
* **Manajemen Pengguna:** Sistem otentikasi (login & register) untuk banyak pengguna.

---

## **🛠️ Teknologi yang Digunakan**

<table>
  <tr>
    <td align="center"><a href="https://laravel.com/" target="_blank"><img src="https://upload.wikimedia.org/wikipedia/commons/9/9a/Laravel.svg" alt="laravel" width="40" height="40"/></a><br>Laravel</td>
    <td align="center"><a href="https://tailwindcss.com/" target="_blank"><img src="https://tailwindcss.com/_next/static/media/tailwindcss-mark.d52e9897.svg" alt="tailwind" width="40" height="40"/></a><br>Tailwind CSS</td>
    <td align="center"><a href="https://www.mysql.com/" target="_blank"><img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/mysql/mysql-original-wordmark.svg" alt="mysql" width="40" height="40"/></a><br>MySQL</td>
    <td align="center"><a href="https://vitejs.dev" target="_blank"><img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/vitejs/vitejs-original.svg" alt="vite" width="40" height="40"/></a><br>Vite</td>
    <td align="center"><a href="https://www.php.net" target="_blank"><img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/php/php-original.svg" alt="php" width="40" height="40"/></a><br>PHP</td>
  </tr>
</table>

---

## **🚀 Instalasi & Menjalankan Proyek**

Berikut adalah cara untuk menjalankan proyek ini di lingkungan lokal Anda.

**Prasyarat:**
* PHP (versi 8.2 atau lebih tinggi)
* Composer
* Node.js & NPM
* Database MySQL
* Lingkungan lokal seperti Laragon (direkomendasikan)

**Langkah-langkah:**

1.  **Clone repository ini:**
    ```bash
    git clone [https://github.com/NAMA_USER_ANDA/NAMA_REPO_ANDA.git](https://github.com/NAMA_USER_ANDA/NAMA_REPO_ANDA.git)
    ```
    2.  **Masuk ke direktori proyek:**
    ```bash
    cd nama-direktori-proyek
    ```

3.  **Install dependensi PHP:**
    ```bash
    composer install
    ```

4.  **Salin file environment:**
    ```bash
    cp .env.example .env
    ```

5.  **Generate application key:**
    ```bash
    php artisan key:generate
    ```

6.  **Konfigurasi file `.env`:**
    Buka file `.env` dan sesuaikan koneksi database Anda (DB_DATABASE, DB_USERNAME, DB_PASSWORD).
    ```env
    DB_CONNECTION=""
    DB_HOST=""
    DB_PORT=""
    DB_DATABASE=""
    DB_USERNAME=""
    DB_PASSWORD=""
    ```

7.  **Jalankan migrasi database:**
    ```bash
    php artisan migrate
    ```

8.  **Buat symbolic link untuk storage:**
    ```bash
    php artisan storage:link
    ```

9.  **Install dependensi JavaScript:**
    ```bash
    npm install
    ```

10. **Jalankan Vite development server:**
    ```bash
    npm run dev
    ```

11. Buka tab terminal baru dan jalankan server Laravel (jika tidak menggunakan Laragon):
    ```bash
    php artisan serve
    ```

Aplikasi sekarang dapat diakses di `http://localhost:8000` atau URL dari Laragon Anda.
