# Troubleshooting: Menu PPDB Tidak Muncul

## Verifikasi

✅ Kode sudah benar - Menu PPDB sudah ditambahkan di sidebar.php line 109-114

## Solusi

### 1. Clear Browser Cache
- Tekan **Ctrl+Shift+R** (Windows) atau **Cmd+Shift+R** (Mac)
- Atau hard refresh di browser

### 2. Clear CodeIgniter Cache
```bash
cd /Applications/XAMPP/xamppfiles/htdocs/school_2
php spark cache:clear
```

### 3. Logout & Login Ulang
- Logout dari admin panel
- Login kembali sebagai admin

### 4. Cek Role Session
Pastikan Anda login sebagai **admin**, bukan guru atau siswa.

### 5. Restart Apache
Di XAMPP Control Panel:
- Stop Apache
- Start Apache

### 6. Manual Verification
Buka langsung URL:
```
http://localhost/school_2/public/admin/ppdb
```

Jika halaman terbuka, berarti route sudah benar, tinggal masalah cache sidebar.

## Lokasi Menu
**Section**: Content & Settings  
**Posisi**: Antara "News Management" dan "System Settings"  
**Icon**: 📋 (clipboard-text)
