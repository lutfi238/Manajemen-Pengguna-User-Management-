# 🚀 Git Commands untuk Push ke GitHub

## 📍 Repository Info
- **GitHub URL:** https://github.com/lutfi238/Manajemen-Pengguna-User-Management-
- **Git Remote:** git@github.com:lutfi238/Manajemen-Pengguna-User-Management-.git

---

## ⚙️ Setup Git (Jika Belum)

```bash
# Buka terminal di folder project
cd C:\xampp\htdocs\webpro_intro\tugas_2_UTS

# Konfigurasi git (sekali saja)
git config --global user.name "Lutfi Firdaus"
git config --global user.email "lutfifirdaus238@gmail.com"

# Init repository
git init

# Tambahkan remote
git remote add origin git@github.com:lutfi238/Manajemen-Pengguna-User-Management-.git
```

---

## 📤 Push Pertama Kali

```bash
# Add semua file
git add .

# Commit dengan pesan
git commit -m "Complete Warehouse Management System

- User registration with email activation
- Product CRUD management
- Dashboard with statistics
- Token-based password reset
- PHPMailer integration
- Timezone WIB support
- Complete documentation"

# Push ke GitHub
git push -u origin main

# JIKA ERROR "main doesn't exist", coba:
git branch -M main
git push -u origin main

# ATAU jika pakai branch "master":
git push -u origin master
```

---

## 🔄 Update Selanjutnya

Jika ada perubahan dan ingin push lagi:

```bash
# Cek status perubahan
git status

# Add file yang berubah
git add .

# Atau add file spesifik
git add README.md
git add connect.php

# Commit dengan pesan
git commit -m "Update database timezone and email settings"

# Push
git push
```

---

## 🔍 Check Status

```bash
# Lihat status file
git status

# Lihat history commit
git log

# Lihat remote repository
git remote -v

# Lihat branch
git branch
```

---

## ⚠️ Troubleshooting

### Error: Permission Denied (SSH)

```bash
# Pastikan SSH key sudah di-setup
ssh -T git@github.com

# Jika belum, buat SSH key
ssh-keygen -t ed25519 -C "lutfifirdaus238@gmail.com"

# Copy public key dan tambahkan ke GitHub
cat ~/.ssh/id_ed25519.pub
```

Kemudian paste di: GitHub → Settings → SSH and GPG keys → New SSH key

### Error: Repository not found

```bash
# Cek remote URL
git remote -v

# Update remote URL jika salah
git remote set-url origin git@github.com:lutfi238/Manajemen-Pengguna-User-Management-.git
```

### Error: Merge Conflict

```bash
# Pull dulu sebelum push
git pull origin main

# Resolve conflict manually, lalu:
git add .
git commit -m "Resolve merge conflict"
git push
```

---

## 📋 Checklist Sebelum Push

- [ ] ✅ Semua fitur sudah berfungsi
- [ ] ✅ Database sudah di-import dan test
- [ ] ✅ Email config sudah di-review (lihat SECURITY_NOTE.md)
- [ ] ✅ README.md sudah lengkap
- [ ] ✅ File `database.sql` ada di root folder
- [ ] ✅ `.gitignore` sudah dibuat
- [ ] ✅ Test clone di folder baru untuk validasi

---

## 🎯 Setelah Push

1. **Buka GitHub:** https://github.com/lutfi238/Manajemen-Pengguna-User-Management-
2. **Pastikan semua file ada:**
   - README.md terlihat di homepage
   - database.sql ada
   - Semua folder (authentication, product-management, dll)
3. **Test clone:**
   ```bash
   cd C:\temp
   git clone git@github.com:lutfi238/Manajemen-Pengguna-User-Management-.git test-clone
   cd test-clone
   # Pastikan semua file ada
   ```

---

## 📧 Untuk Dosen

Setelah push, berikan link ini ke dosen:

```
https://github.com/lutfi238/Manajemen-Pengguna-User-Management-
```

**README.md** sudah berisi semua instruksi instalasi dan testing.

---

## 🏆 DONE!

Sistem siap untuk:
- ✅ Push ke GitHub
- ✅ Demo ke dosen
- ✅ Submission tugas

**Good luck!** 🚀

