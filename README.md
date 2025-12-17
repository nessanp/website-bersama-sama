# 📚 Portfolio Website Profesional - Setup & Documentation

Website portfolio profesional dengan PHP & MySQL yang responsif dan dinamis.

---

## 🚀 Fitur Utama

✅ **Home Page** - Ringkasan profil dan project terbaru secara dinamis
✅ **About Page** - Profil lengkap, skill, dan pengalaman kerja
✅ **Project Page** - Daftar project dinamis dari database dengan fitur pencarian
✅ **Admin Dashboard** - CRUD project dengan autentikasi
✅ **Login Page** - Autentikasi admin dengan username & password
✅ **Responsive Design** - Bekerja sempurna di desktop, tablet, dan mobile
✅ **Modern UI** - Design professional dengan gradient dan animasi

---

## 📋 Struktur File

```
portfolio-website/
├── index.php           # Halaman Home
├── about.php           # Halaman About
├── project.php         # Halaman Project dengan pencarian
├── admin.php           # Dashboard admin untuk CRUD project
├── login.php           # Halaman login admin
├── logout.php          # Script logout
├── db.php              # Koneksi database & helper functions
├── style.css           # Stylesheet responsif
├── database.sql        # File SQL untuk setup database
└── README.md           # File ini
```

---

## 🛠️ Persyaratan Teknis

- **Server**: Apache (Laragon, XAMPP, atau sejenisnya)
- **PHP**: Versi 7.4 atau lebih tinggi
- **Database**: MySQL 5.7 atau lebih tinggi
- **Browser**: Chrome, Firefox, Safari, atau Edge (versi terbaru)

---

## 📥 Cara Install & Setup

### Step 1: Download dan Extract File

1. Extract semua file ke folder project Anda
   - Untuk XAMPP: `C:\xampp\htdocs\portfolio-website\`
   - Untuk Laragon: `C:\laragon\www\portfolio-website\`

### Step 2: Buat Database

#### **Menggunakan phpMyAdmin (Cara Mudah):**

1. Buka **phpMyAdmin** di browser
   - XAMPP: `http://localhost/phpmyadmin`
   - Laragon: `http://localhost/phpmyadmin`

2. Klik tab **"SQL"** di bagian atas

3. Copy-paste seluruh isi file `database.sql` ke text area

4. Klik tombol **"Go"** atau **"Execute"** untuk menjalankan query

5. Tunggu sampai proses selesai

#### **Menggunakan Command Line (Terminal/CMD):**

```bash
# Windows - Buka Command Prompt di folder project
mysql -u root -p portfolio_website < database.sql

# Linux/Mac
mysql -u root -p portfolio_website < database.sql

# Jika MySQL ada di PATH XAMPP
"C:\xampp\mysql\bin\mysql.exe" -u root < database.sql
```

### Step 3: Konfigurasi Database Connection (Jika Diperlukan)

Edit file `db.php` jika konfigurasi database Anda berbeda:

```php
$servername = "localhost";    // Sesuaikan jika berbeda
$username = "root";           // Username MySQL Anda
$password = "";               // Password MySQL Anda (kosong untuk default)
$database = "portfolio_website";
```

### Step 4: Jalankan Website

1. **Start Server** (Laragon atau XAMPP)

2. Buka browser dan akses:
   ```
   http://localhost/portfolio-website/
   ```

   Atau jika menggunakan folder berbeda:
   ```
   http://localhost/nama-folder-anda/
   ```

---

## 🔐 Akun Login Admin

Setelah database setup, gunakan akun berikut untuk login:

**Akun 1:**
- Username: `admin`
- Password: `admin123`

**Akun 2:**
- Username: `user`
- Password: `user123`

> ⚠️ **Catatan Keamanan**: Password sudah di-hash menggunakan bcrypt. Jangan lupa ubah password setelah login pertama kali di production environment!

---

## 📖 Penjelasan Halaman & Fitur

### 🏠 Home (index.php)
- Menampilkan greeting dan ringkasan profil
- Menampilkan 3 project terbaru dari database
- Menampilkan skill preview
- Link ke halaman lain

### 👤 About (about.php)
- Profil lengkap dengan foto
- Skill bars dengan persentase
- Timeline pengalaman kerja
- Informasi pendidikan
- Form kontak untuk pesan

### 🚀 Project (project.php)
- Menampilkan semua project dari database
- Fitur pencarian project berdasarkan judul atau deskripsi
- Tombol menuju halaman detail project internal
- Statistik jumlah project

### 🔒 Login (login.php)
- Form login dengan validasi
- Redirect ke admin dashboard jika berhasil
- Error message jika login gagal
- Info demo akun untuk testing

### ⚙️ Admin Dashboard (admin.php)
Hanya bisa diakses setelah login. Fitur:

**📋 View All Projects**
- Tabel daftar semua project
- Informasi: judul, link, tanggal dibuat
- Button Edit dan Delete untuk setiap project

**➕ Add New Project**
- Form untuk tambah project baru
- Field: judul, deskripsi, upload gambar, link (opsional)
- Validasi form di client dan server
- Langsung tersimpan di database

**✏️ Edit Project**
- Buka form edit dengan data project terpilih
- Update field yang diinginkan
- Simpan perubahan ke database

**🗑️ Delete Project**
- Hapus project dengan konfirmasi
- Data akan dihapus dari database

**🖼️ Upload Gambar Project**
- Upload file gambar (jpg/png/webp) langsung dari form admin
- File tersimpan di folder `uploads/` (folder otomatis dibuat)
- Saat edit, upload baru akan mengganti file lama

---

## 🔧 Database Schema

### Tabel `admin`
```sql
id          INT (Primary Key)
username    VARCHAR (Unique)
password    VARCHAR (Hashed)
created_at  TIMESTAMP
```

### Tabel `projects`
```sql
id          INT (Primary Key)
judul       VARCHAR (200)
deskripsi   LONGTEXT
gambar      VARCHAR (255)
link        VARCHAR (255)
created_at  TIMESTAMP
updated_at  TIMESTAMP (Auto-updated)
```

---

## 🛡️ Fitur Keamanan

✅ **Password Hashing** - Menggunakan bcrypt untuk keamanan maksimal
✅ **Session Management** - Login persistent dengan session
✅ **Input Validation** - Validasi di client dan server
✅ **SQL Injection Prevention** - Menggunakan prepared statement & escape
✅ **XSS Prevention** - Menggunakan htmlspecialchars() untuk output
✅ **Authentication Check** - Admin page hanya bisa diakses saat login

---

## 🎨 Customization

### Mengubah Warna
Edit file `style.css` dan ubah color variable:
```css
/* Ganti warna utama dari #667eea ke warna pilihan Anda */
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
```

### Mengubah Data Profil
Edit bagian di halaman berikut:
- **About (about.php)**: Nama, kontak, deskripsi, skill
- **Home (index.php)**: Hero text, deskripsi profil

### Menambah Admin Baru
Insert ke tabel `admin` melalui phpMyAdmin:
```sql
INSERT INTO admin (username, password) VALUES 
('new_username', '$2y$10$...[hash]...');
```

---

## 🐛 Troubleshooting

### Error: "Koneksi database gagal"
- **Solusi**: Check konfigurasi di `db.php`
- Pastikan MySQL service berjalan
- Verifikasi username, password, dan nama database

### Error: "File tidak ditemukan"
- **Solusi**: Pastikan semua file ada di folder yang benar
- Check URL path: `http://localhost/portfolio-website/`

### Login gagal
- **Solusi**: Verifikasi username dan password
- Pastikan database sudah di-setup dengan `database.sql`
- Clear browser cache dan cookies

### Project tidak tampil di home
- **Solusi**: Pastikan ada data di tabel `projects`
- Login ke admin dan tambah project baru
- Check database connection

### CSS tidak ter-load
- **Solusi**: Refresh page dengan Ctrl+F5 atau Cmd+Shift+R
- Pastikan file `style.css` ada di folder yang benar
- Check file path di tag `<link>`

---

## 📝 Tips & Trik

💡 **Backup Database**: Selalu backup database sebelum update
💡 **Upload Gambar**: Buat folder `/images/` untuk menyimpan gambar project
💡 **SEO Friendly**: Tambahkan meta tags di setiap halaman
💡 **Performance**: Gunakan caching untuk database queries yang sering digunakan
💡 **Mobile Friendly**: Test di berbagai ukuran layar menggunakan DevTools

---

## 🚀 Deployment (Production)

Sebelum deploy ke server live:

1. **Update `db.php`** dengan credentials server yang sebenarnya
2. **Change Password Admin** di phpMyAdmin
3. **Remove Demo Data** jika diperlukan
4. **Enable HTTPS** untuk keamanan
5. **Set File Permissions** yang tepat (644 untuk file, 755 untuk folder)
6. **Disable Directory Listing** dengan `.htaccess`
7. **Regular Backups** database dan file

---

## 📞 Support & Contact

Untuk pertanyaan atau issue:
- Email: hello@portfolio.com
- Konsultasi: https://portfolio.com/contact

---

## 📄 License

Portfolio Website © 2025. Semua hak dilindungi.

---

## ✅ Checklist Setup Awal

- [ ] Extract file ke folder project
- [ ] Buka phpMyAdmin
- [ ] Jalankan `database.sql`
- [ ] Verifikasi tabel `admin` dan `projects` sudah ada
- [ ] Edit `db.php` jika konfigurasi database berbeda
- [ ] Buka `http://localhost/portfolio-website/`
- [ ] Login dengan akun `admin` / `admin123`
- [ ] Test CRUD project di admin dashboard
- [ ] Check semua halaman berfungsi dengan baik

---

**Selamat! Website portfolio Anda sudah siap digunakan! 🎉**

Jika ada pertanyaan atau butuh bantuan, jangan ragu untuk menghubungi support.
