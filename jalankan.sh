#!/bin/bash

# ============================================
# Script untuk menjalankan CodeIgniter 4
# Sistem Informasi Sekolah
# ============================================

echo "🚀 Memulai Sistem Informasi Sekolah..."
echo "========================================"
echo ""

# Cek apakah file .env sudah ada
if [ ! -f ".env" ]; then
    echo "⚠️  File .env tidak ditemukan!"
    echo "📋 Membuat file .env dari template..."
    cp env .env
    echo "✅ File .env berhasil dibuat"
    echo ""
    echo "⚠️  PENTING: Silakan edit file .env terlebih dahulu!"
    echo "   - Set database credentials"
    echo "   - Generate encryption key dengan: php spark key:generate --show"
    echo ""
    exit 1
fi

# Cek permission folder writable
echo "🔍 Memeriksa permission folder writable..."
chmod -R 777 writable
echo "✅ Permission folder writable sudah diupdate"
echo ""

# Cek database connection
echo "🔍 Memeriksa koneksi database..."
php spark db:table users > /dev/null 2>&1
if [ $? -eq 0 ]; then
    echo "✅ Database terhubung dengan baik"
else
    echo "❌ Koneksi database gagal!"
    echo "   Pastikan:"
    echo "   - MySQL XAMPP sudah running"
    echo "   - Database 'school_system' sudah dibuat"
    echo "   - Kredensial di .env sudah benar"
    echo ""
    exit 1
fi

echo ""
echo "========================================"
echo "🎉 Semua pengecekan berhasil!"
echo "========================================"
echo ""
echo "🌐 Menjalankan development server..."
echo "📍 URL: http://localhost:8080"
echo ""
echo "👨‍💼 Login Admin:"
echo "   Email: admin@sekolah.com"
echo "   Password: password"
echo ""
echo "👨‍🎓 Login Siswa:"
echo "   Email: siswa001@sekolah.com"
echo "   Password: password"
echo ""
echo "⏹️  Tekan CTRL+C untuk stop server"
echo "========================================"
echo ""

# Jalankan development server
php spark serve
