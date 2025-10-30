# ⚠️ SECURITY NOTE - PENTING!

## 🔐 Sebelum Push ke GitHub

File `configuration/email_config.php` berisi **kredensial Gmail yang AKTIF**:
- Email: `lutfifirdaus238@gmail.com`
- App Password: `vcrg bvws zevs mozm`

### ✅ Pilihan 1: Hapus Kredensial (RECOMMENDED)

**Sebelum push ke GitHub, edit file ini:**

```php
// configuration/email_config.php
<?php
return [
    'smtp_host' => 'smtp.gmail.com',
    'smtp_port' => 587,
    'smtp_username' => 'YOUR_EMAIL@gmail.com',  // Ganti dengan placeholder
    'smtp_password' => 'YOUR_APP_PASSWORD_HERE', // Ganti dengan placeholder
    'from_email' => 'YOUR_EMAIL@gmail.com',
    'from_name' => 'Warehouse Management System'
];
?>
```

**Tambahkan instruksi di README:**
```markdown
Dosen harus konfigurasi email sendiri sebelum demo.
```

### ✅ Pilihan 2: Ignore File Email Config

**Uncomment baris ini di `.gitignore`:**

```
# configuration/email_config.php
```

Tapi ini berarti dosen harus setup sendiri saat demo.

### ✅ Pilihan 3: Biarkan (Jika OK untuk Public)

Jika Anda **OK** kredensial ini publik (untuk keperluan demo), silakan lanjut push.

**RESIKO:**
- ✓ Email bisa dipakai orang lain untuk spam
- ✓ Gmail bisa suspend akun
- ✓ App Password bisa disalahgunakan

**MITIGASI:**
- Revoke App Password setelah tugas selesai
- Buat email khusus untuk demo (bukan email pribadi)

---

## 📋 Checklist Push ke GitHub

- [ ] Review `configuration/email_config.php` (hapus/placeholder/biarkan?)
- [ ] Pastikan `database.sql` tidak berisi data sensitif
- [ ] Cek `connect.php` (password database kosong = OK untuk demo lokal)
- [ ] Update `.gitignore` sesuai kebutuhan
- [ ] Test clone repo di folder baru untuk memastikan lengkap
- [ ] Pastikan dosen bisa setup dengan mudah

---

## 🚀 Command Git Push

```bash
# Di folder tugas_2_UTS
cd C:\xampp\htdocs\webpro_intro\tugas_2_UTS

# Init git (jika belum)
git init

# Add remote (sudah ada)
git remote add origin git@github.com:lutfi238/Manajemen-Pengguna-User-Management-.git

# Add semua file
git add .

# Commit
git commit -m "Complete Warehouse Management System with email activation"

# Push
git push -u origin main

# Atau jika branch master:
git push -u origin master
```

---

## 📧 Email untuk Dosen

Jika Anda remove kredensial email dari GitHub, berikan instruksi ini ke dosen:

```
Pak/Bu,

Untuk demo sistem, mohon setup email SMTP terlebih dahulu:

1. Buka file: configuration/email_config.php
2. Ganti dengan kredensial Gmail Bapak/Ibu
3. Gunakan App Password, bukan password biasa

Atau, sistem bisa berjalan tanpa email. 
Link aktivasi/reset akan muncul di halaman sebagai fallback.

Terima kasih.
```

---

**Pilihan terserah Anda!** Pertimbangkan keamanan vs kemudahan demo. 🔒✨

