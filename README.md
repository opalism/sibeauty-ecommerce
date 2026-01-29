# 💄 SIBEAUTY - Premium E-Commerce Platform

![PHP](https://img.shields.io/badge/PHP-8.0%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Datbase-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![Status](https://img.shields.io/badge/Status-Completed-success?style=for-the-badge)

**SIBEAUTY** adalah aplikasi e-commerce modern berbasis web yang dibangun menggunakan **Native PHP dengan arsitektur MVC (Model-View-Controller)**. Aplikasi ini dirancang untuk toko kosmetik dan skincare dengan fitur lengkap mulai dari katalog produk responsif, sistem keranjang belanja, hingga manajemen pesanan (Invoice) yang siap cetak.

---

## 📸 Screenshots & Features

### 1. Halaman Depan (User)
Tampilan antarmuka yang bersih dan responsif di berbagai perangkat (Mobile/Tablet/Desktop).
- **Fitur:** Katalog Produk, Pencarian Realtime, Filter Kategori, & Sticky Navbar.

### 2. Halaman Detail Produk
Desain interaktif dengan fitur:
- 🛒 **Add to Cart** dengan validasi stok otomatis.
- 📱 **Mobile Friendly Layout** (Gambar & Deskripsi menyesuaikan layar).
- 💬 **Direct Purchase via WhatsApp**.

### 3. Dashboard Admin
Panel admin yang powerful untuk mengelola bisnis:
- 📊 **Statistik Penjualan** & Pendapatan.
- 📦 **Manajemen Produk** (CRUD + Upload Gambar).
- ⚡ **Restock Cepat** (Modal Popup).
- 📄 **Cetak Invoice** Transaksi.

---

## 🛠️ Teknologi yang Digunakan

* **Backend:** PHP Native (OOP Style), MVC Architecture.
* **Database:** MySQL (PDO Driver for Security).
* **Frontend:** Bootstrap 5.3, Custom CSS, Vanilla JavaScript.
* **Tools:** VS Code, XAMPP/Laragon, Git.

---

## 🚀 Cara Instalasi

Ikuti langkah ini untuk menjalankan project di komputer lokal Anda:

1.  **Clone Repository**
    ```bash
    git clone [https://github.com/opalism/sibeauty-ecommerce.git](https://github.com/opalism/sibeauty-ecommerce.git)
    ```

2.  **Setup Database**
    * Buat database baru di phpMyAdmin bernama `sibeauty`.
    * Import file `database/sibeauty.sql` ke dalamnya.

3.  **Konfigurasi Project**
    * Buka file `app/config/config.php`.
    * Sesuaikan `BASEURL` dengan folder project Anda, contoh:
        ```php
        define('BASEURL', 'http://localhost/sibeauty-ecommerce/public');
        ```
    * Pastikan konfigurasi DB (`DB_HOST`, `DB_USER`, `DB_PASS`) sudah sesuai.

4.  **Jalankan!**
    * Buka browser dan akses: `http://localhost/sibeauty-ecommerce/public`
    * **Akun Admin Default:**
        * Email: `admin@admin.com` (Sesuaikan dengan data di tabel users)
        * Password: `admin` (Atau buat user baru dengan role 'admin')

---

## 📂 Struktur Folder (MVC)

```text
sibeauty/
├── app/
│   ├── config/      # Konfigurasi Database & Baseurl
│   ├── controllers/ # Logika Bisnis (Admin, Auth, Product, Cart)
│   ├── core/        # Core System (App, Controller, Database Wrapper)
│   ├── models/      # Akses ke Database
│   └── views/       # Tampilan (HTML/PHP)
├── public/
│   ├── assets/      # CSS, JS, Images, Uploads
│   └── index.php    # Gateway Utama (Routing)
└── database/        # File SQL Backup