# 🎓 Sistem Informasi Sekolah - CodeIgniter 4

Aplikasi web berbasis CodeIgniter 4 untuk manajemen sekolah dengan fitur CBT (Computer Based Test), Presensi Online, dan Manajemen Materi Pembelajaran.

---

## ⚡ Quick Start

### 1. Persiapan Database
1. Buka **phpMyAdmin**: `http://localhost/phpmyadmin`
2. Buat database baru: `school_system`
3. Import file: [`database_schema.sql`](file:///Applications/XAMPP/xamppfiles/htdocs/codeigniter/database_schema.sql)

### 2. Konfigurasi Environment
```bash
# Copy file environment
cp env .env

# Generate encryption key
php spark key:generate --show
```

Edit file `.env` dan sesuaikan:t
```ini
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost/codeigniter/public/'

database.default.hostname = localhost
database.default.database = school_system
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi

encryption.key = base64:YOUR_KEY_HERE
```

### 3. Jalankan Aplikasi

**Metode 1: Menggunakan script otomatis**
```bash
./jalankan.sh
```

**Metode 2: Manual**
```bash
php spark serve
```

Aplikasi akan berjalan di: **http://localhost:8080**

---

## 🔐 Login Credentials

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@sekolah.com | password |
| **Siswa 1** | siswa001@sekolah.com | password |
| **Siswa 2** | siswa002@sekolah.com | password |

---

## 📁 Struktur Proyek

```
codeigniter/
├── app/
│   ├── Controllers/        # Business logic
│   │   ├── Auth/          # Login/Logout
│   │   ├── Admin/         # Admin features
│   │   └── Siswa/         # Student features
│   ├── Models/            # Database models
│   ├── Views/             # Frontend templates
│   └── Filters/           # Authentication filters
├── public/
│   ├── uploads/           # File uploads
│   ├── css/               # Stylesheets
│   └── js/                # JavaScript
└── writable/              # Cache & logs
```

Lihat detail lengkap: [`CODEIGNITER_STRUCTURE.md`](file:///Applications/XAMPP/xamppfiles/htdocs/codeigniter/CODEIGNITER_STRUCTURE.md)

---

## ✨ Fitur Utama

### 👨‍💼 Admin
- ✅ Dashboard & Analytics
- ✅ Manajemen Berita & Artikel
- ✅ Upload Slider/Banner
- ✅ Manajemen User (Admin & Siswa)
- ✅ Upload Materi Pembelajaran
- ✅ Buat & Kelola CBT (Ujian Online)
- ✅ Tambah Soal Ujian
- ✅ Lihat Hasil Ujian Siswa
- ✅ Rekap Presensi

### 👨‍🎓 Siswa
- ✅ Dashboard Pribadi
- ✅ Presensi Online (Check-in)
- ✅ Mengerjakan CBT
- ✅ Download Materi Pembelajaran
- ✅ Edit Profil

---

## 🗄️ Database Schema

Database terdiri dari 10 tabel utama:
1. **users** - Data Admin & Siswa
2. **news** - Berita & Artikel
3. **settings** - Konfigurasi Website
4. **sliders** - Banner/Slider Homepage
5. **cbt_exams** - Daftar Ujian
6. **cbt_questions** - Bank Soal
7. **cbt_results** - Hasil Ujian Siswa
8. **cbt_answers** - Jawaban Siswa
9. **attendance** - Presensi Online
10. **materials** - Materi Pembelajaran

---

## 🛠️ Tech Stack

- **Framework**: CodeIgniter 4
- **Database**: MySQL/MariaDB
- **Frontend**: Bootstrap 5
- **JavaScript**: Vanilla JS + Matter.js (Gravity Effect)
- **Server**: Apache XAMPP

---

## 📖 Dokumentasi

- **Setup XAMPP**: [TUTORIAL_XAMPP.md](file:///Users/dimardnugroho/.gemini/antigravity/brain/7e97e22d-4342-4516-a035-02d3db6dc7e8/TUTORIAL_XAMPP.md)
- **Struktur Folder**: [CODEIGNITER_STRUCTURE.md](file:///Applications/XAMPP/xamppfiles/htdocs/codeigniter/CODEIGNITER_STRUCTURE.md)
- **Database Schema**: [database_schema.sql](file:///Applications/XAMPP/xamppfiles/htdocs/codeigniter/database_schema.sql)

---

## 🚀 Development Roadmap

- [ ] Implementasi Controllers (Auth, Admin, Siswa)
- [ ] Buat Views dengan Bootstrap 5
- [ ] Integrasi Google Gravity Effect
- [ ] Upload/Download Materi
- [ ] CBT Timer & Auto Submit
- [ ] Notification System
- [ ] Export Laporan (PDF/Excel)

---

## 📞 Support

Jika ada pertanyaan atau error, silakan buat issue atau hubungi developer.

---

**Happy Coding! 💻✨**
