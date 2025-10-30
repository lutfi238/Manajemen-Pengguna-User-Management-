# Warehouse Management System

> **Repository:** [github.com/lutfi238/Manajemen-Pengguna-User-Management-](https://github.com/lutfi238/Manajemen-Pengguna-User-Management-)

Sistem Manajemen Gudang berbasis web menggunakan PHP dan MySQL untuk mengelola data produk dengan fitur keamanan lengkap.

## 📋 Deskripsi

Aplikasi web ini memungkinkan **Admin Gudang** untuk:
- Mendaftar dan mengaktivasi akun via email ✉️
- Mengelola produk (Create, Read, Update, Delete) 📦
- Mengelola profil pribadi 👤
- Mengubah password dan reset password via email 🔐
- Melihat dashboard dengan statistik gudang 📊

## 🛠️ Teknologi

- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Frontend**: HTML, CSS (minimal)
- **Email**: PHPMailer (untuk aktivasi & reset password)
- **Server**: XAMPP (Apache + MySQL)
- **Dependency Management**: Composer

## 📦 Instalasi

### 1. Persiapan Environment

Pastikan XAMPP sudah terinstall dengan komponen:
- Apache
- MySQL
- PHP 7.4 atau lebih tinggi

### 2. Clone atau Download Project

```bash
# Letakkan folder project di:
C:\xampp\htdocs\webpro_intro\tugas_2_UTS
```

### 3. Install Dependencies

```bash
# Buka terminal di folder tugas_2_UTS/configuration
cd C:\xampp\htdocs\webpro_intro\tugas_2_UTS\configuration

# Install PHPMailer via Composer
composer install
```

Jika belum punya Composer, download di [getcomposer.org](https://getcomposer.org/)

### 4. Import Database

1. Buka **phpMyAdmin** di browser: `http://localhost/phpmyadmin`
2. Buat database baru bernama `uts_web` (jika belum ada)
3. Pilih database `uts_web`
4. Klik tab **Import**
5. Pilih file `database.sql` dari root folder project
6. Klik **Go** untuk import

Database akan berisi:
- Tabel `users` dengan 3 akun demo
- Tabel `products` dengan sample produk

### 5. Konfigurasi Database Connection

Edit file `connect.php` jika perlu:

```php
$servername = "localhost";
$username = "root";      // Sesuaikan dengan MySQL username Anda
$password = "";          // Sesuaikan dengan MySQL password Anda
$dbname = "uts_web";
```

### 6. Konfigurasi Email ✉️

**✅ Status: Email SUDAH DIKONFIGURASI dan SIAP PAKAI!**

**Untuk sekarang tinggal coba saja** karena email sudah dikonfigurasi dengan Gmail yang valid. **TIDAK PERLU konfigurasi `email_config.php` lagi** untuk testing/demo.

Email akan **otomatis terkirim** untuk:
- ✉️ **Aktivasi akun** setelah registrasi
- 🔐 **Reset password** saat lupa password

Sistem siap digunakan langsung tanpa setup tambahan!

---

**📋 Informasi Email Config (sudah terkonfigurasi):**

File `configuration/email_config.php` sudah berisi:
- SMTP Host: Gmail (smtp.gmail.com)
- Port: 587 (TLS)
- Email pengirim: prcfpbl@gmail.com
- App Password: sudah valid dan aktif

**🎯 Untuk Demo/Testing:**
- Langsung jalankan sistem
- Registrasi user baru → Email aktivasi akan terkirim otomatis
- Reset password → Email reset akan terkirim otomatis
- Cek folder Spam/Junk jika email tidak masuk di Inbox

**🔧 Jika Ingin Ganti Email Sendiri (Opsional):**

Edit `configuration/email_config.php` dengan kredensial Anda:

```php
return [
    'smtp_host' => 'smtp.gmail.com',
    'smtp_port' => 587,
    'smtp_username' => 'your-email@gmail.com',
    'smtp_password' => 'your-app-password',  // Gunakan App Password Gmail
    'from_email' => 'your-email@gmail.com',
    'from_name' => 'Warehouse Management System'
];
```

**Cara buat Gmail App Password:**
1. Buka [Google Account Security](https://myaccount.google.com/security)
2. Enable **2-Step Verification**
3. Cari **App passwords** → Generate untuk "Mail"
4. Copy password 16 karakter ke `smtp_password`

**🛡️ Fallback:** Jika email gagal terkirim, sistem otomatis menampilkan link manual untuk aktivasi/reset.

## 🚀 Cara Menjalankan

1. **Start XAMPP**
   - Buka XAMPP Control Panel
   - Start **Apache**
   - Start **MySQL**

2. **Akses Aplikasi**
   - Buka browser
   - Kunjungi: `http://localhost/webpro_intro/tugas_2_UTS/`

3. **Timezone Setting**
   - Sistem menggunakan timezone **Asia/Jakarta (WIB)**
   - Token reset password berlaku **1 jam penuh**
   - Sudah sinkron antara PHP dan MySQL

## 👥 Akun Demo

Gunakan akun berikut untuk testing (password: `password123`):

| Email | Password | Nama | Produk |
|-------|----------|------|--------|
| `admin@warehouse.com` | `password123` | Admin Gudang Utama | 5 produk |
| `budi@warehouse.com` | `password123` | Budi Santoso | 3 produk |
| `siti@warehouse.com` | `password123` | Siti Nurhaliza | 3 produk |

## ✨ Fitur Sistem

### 1. **Registrasi & Aktivasi** ✉️
- User mendaftar sebagai **Admin Gudang**
- Email harus unik (tidak boleh duplikat)
- Sistem otomatis mengirim email aktivasi dengan link unik
- Link aktivasi menggunakan token 64-karakter (secure)
- Jika email gagal, tersedia link manual sebagai fallback
- Klik link aktivasi untuk mengaktifkan akun

### 2. **Login**
- Login menggunakan **email** dan **password**
- Hanya akun yang sudah aktif yang bisa login
- Setelah login, redirect ke **Dashboard**

### 3. **Dashboard**
- Menampilkan statistik:
  - Total produk
  - Produk dengan stok rendah (< 10)
- Menampilkan 5 produk terbaru
- Quick links ke fitur utama

### 4. **Manajemen Produk (CRUD)**
- **Create**: Tambah produk baru dengan kode unik
- **Read**: Lihat semua produk milik user
- **Update**: Edit data produk
- **Delete**: Hapus produk dengan konfirmasi
- Setiap user hanya bisa mengelola produk miliknya sendiri

### 5. **Manajemen Profil**
- Lihat profil lengkap (nama, email, role, status)
- Edit nama dan email
- Ubah password (dengan verifikasi password lama)

### 6. **Lupa Password** 🔐
- Masukkan email untuk request reset password
- Sistem otomatis kirim email dengan link reset (token-based)
- Link berlaku **1 jam** (timezone WIB sudah diatur)
- Token 64-karakter untuk keamanan
- Jika email gagal, tersedia link manual sebagai fallback
- Klik link dan masukkan password baru
- Token otomatis dihapus setelah password direset

## 📁 Struktur Project

```
tugas_2_UTS/
├── authentication/
│   ├── login.html           # Form login
│   ├── login.php            # Proses login
│   ├── logout.php           # Logout handler
│   ├── profile.php          # Tampilan profil user
│   └── edit_profile.php     # Form & proses edit profil
├── configuration/
│   ├── connect.php          # Konfigurasi database
│   ├── email_config.php     # Konfigurasi email SMTP
│   ├── composer.json        # Composer dependencies
│   ├── create_tbl_users.php # Script create table users
│   ├── create_tbl_products.php # Script create table products
│   └── vendor/              # PHPMailer library
├── password-management/
│   ├── reset_password.html  # Form request reset password
│   ├── send_reset_link.php  # Kirim link reset
│   ├── reset_password.php   # Form & proses reset password
│   ├── change_password.php  # Form ubah password (logged in)
│   ├── update_password.php  # Proses ubah password
│   └── activate.php         # Aktivasi akun via token
├── product-management/
│   ├── view_all_products.php # Daftar semua produk
│   ├── add_product.php      # Form & proses tambah produk
│   ├── edit_product.php     # Form edit produk
│   ├── update_product.php   # Proses update produk
│   └── delete_product.php   # Hapus produk
├── registration/
│   ├── registration.php     # Form registrasi
│   └── create_account.php   # Proses registrasi
├── connect.php              # Database connection (root)
├── dashboard.php            # Dashboard utama
├── index.php                # Homepage
├── database.sql             # Database schema & sample data
└── README.md                # Dokumentasi ini
```

## 🗄️ Struktur Database

### Tabel: `users`

| Field | Type | Deskripsi |
|-------|------|-----------|
| `id` | INT (PK) | User ID |
| `name` | VARCHAR(100) | Nama lengkap |
| `email` | VARCHAR(100) UNIQUE | Email (username) |
| `password` | VARCHAR(255) | Password (bcrypt hashed) |
| `role` | ENUM | Role (warehouse_admin) |
| `is_active` | TINYINT(1) | Status aktif (0/1) |
| `activation_token` | VARCHAR(255) | Token aktivasi email |
| `reset_token` | VARCHAR(255) | Token reset password |
| `reset_token_expiry` | DATETIME | Waktu expire token reset |
| `created_at` | TIMESTAMP | Waktu registrasi |

### Tabel: `products`

| Field | Type | Deskripsi |
|-------|------|-----------|
| `id` | INT (PK) | Product ID |
| `product_code` | VARCHAR(50) UNIQUE | Kode produk |
| `product_name` | VARCHAR(100) | Nama produk |
| `description` | TEXT | Deskripsi produk |
| `stock` | INT | Jumlah stok |
| `price` | DECIMAL(15,2) | Harga produk |
| `created_at` | TIMESTAMP | Waktu ditambahkan |
| `updated_at` | TIMESTAMP | Waktu terakhir update |
| `user_id` | INT (FK) | ID admin yang mengelola |

**Foreign Key:** `products.user_id` → `users.id` (ON DELETE CASCADE)

## 🔒 Keamanan

- **Password Hashing**: Menggunakan `password_hash()` dengan bcrypt (cost 10)
- **Session Management**: Session-based authentication dengan timeout
- **XSS Prevention**: `htmlspecialchars()` pada semua output user
- **Token-based Activation**: Random 64-character token (SHA-256) untuk aktivasi email
- **Token-based Reset**: Random 64-character token dengan expiry 1 jam (timezone-aware)
- **Ownership Verification**: User hanya bisa mengelola produk miliknya sendiri
- **Email Validation**: Cek duplikasi email saat registrasi
- **Password Strength**: Minimal 8 karakter untuk semua password
- **Timezone Sync**: PHP dan MySQL menggunakan Asia/Jakarta untuk konsistensi waktu

## 🐛 Troubleshooting

### Database Connection Error
- Pastikan MySQL di XAMPP sudah running
- Cek konfigurasi di `connect.php` (default: `uts_web`)
- Pastikan database `uts_web` sudah dibuat dan di-import
- Cek username/password MySQL (default: root/kosong)

### Email Tidak Terkirim
- Email **sudah aktif** dengan Gmail SMTP
- Jika gagal kirim, sistem otomatis tampilkan link manual
- Cek folder **Spam/Junk** di Gmail
- Pastikan App Password Gmail masih valid
- Tunggu 1-2 menit untuk delay pengiriman
- Untuk production, update SMTP settings di `configuration/email_config.php`

### Token Reset Password Kadaluarsa
- Token berlaku **1 jam** sejak request
- Timezone sudah diset ke **Asia/Jakarta (WIB)**
- Jika tetap masalah, request reset password baru
- Token otomatis dihapus setelah digunakan

### Halaman Blank/Error
- Enable error reporting di PHP:
  ```php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  ```
- Cek Apache error log di `C:\xampp\apache\logs\error.log`

### Login Gagal
- Pastikan akun sudah diaktivasi (is_active = 1)
- Gunakan email (bukan username)
- Password default demo: `password123`

## 📝 Catatan Penting

1. **Email Sudah Aktif**: 
   - Sistem sudah dikonfigurasi dengan Gmail SMTP
   - Email otomatis terkirim untuk aktivasi & reset password
   - Link manual tersedia sebagai fallback jika email gagal

2. **Timezone**: 
   - Sistem menggunakan **Asia/Jakarta (WIB)**
   - Token reset password berlaku 1 jam penuh
   - PHP dan MySQL sudah sinkron

3. **Password Default Demo**: 
   - Semua akun demo: `password123`
   - Email: `admin@warehouse.com`, `budi@warehouse.com`, `siti@warehouse.com`

4. **Low Stock Alert**: 
   - Produk dengan stok < 10 ditandai **merah** 
   - Alert muncul di dashboard dan daftar produk

5. **GitHub Repository**:
   - Link: [github.com/lutfi238/Manajemen-Pengguna-User-Management-](https://github.com/lutfi238/Manajemen-Pengguna-User-Management-)
   - Clone dengan: `git clone git@github.com:lutfi238/Manajemen-Pengguna-User-Management-.git`

6. **Untuk Production**: 
   - Ganti SMTP credentials di `configuration/email_config.php`
   - Ganti password database di `connect.php`
   - Gunakan HTTPS
   - Implementasi prepared statements (SQL injection prevention)

## 👨‍💻 Pengembang

Sistem ini dikembangkan untuk tugas kuliah **Web Programming**.

## 📄 Lisensi

Project ini dibuat untuk keperluan akademik.

---

**Selamat mencoba!** 🚀

Jika ada pertanyaan atau kendala, silakan hubungi dosen pengampu mata kuliah.
