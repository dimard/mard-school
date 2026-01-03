# Struktur Folder CodeIgniter 4 - Sistem Informasi Sekolah

## 📁 Struktur Folder Controller

```
app/Controllers/
│
├── Home.php                    # Halaman publik (landing page)
├── Auth/
│   ├── Login.php              # Handle login Admin & Siswa
│   ├── Register.php           # Handle registrasi (optional)
│   └── Logout.php             # Handle logout
│
├── Admin/
│   ├── Dashboard.php          # Dashboard Admin
│   ├── News.php               # CRUD Berita/Artikel
│   ├── Slider.php             # CRUD Slider Images
│   ├── Settings.php           # Edit Settings (Header/Footer)
│   ├── Users.php              # Manajemen User (Admin & Siswa)
│   ├── Materials.php          # Upload & Manage Materi
│   ├── Cbt.php                # Manajemen CBT (Exams)
│   ├── CbtQuestions.php       # CRUD Soal Ujian
│   ├── CbtResults.php         # Lihat Hasil Ujian Siswa
│   └── Attendance.php         # Rekap Presensi
│
└── Siswa/
    ├── Dashboard.php          # Dashboard Siswa
    ├── Attendance.php         # Presensi Online (Check-in)
    ├── Cbt.php                # Halaman Ujian & Mengerjakan Soal
    ├── Materials.php          # Download Materi
    └── Profile.php            # Edit Profil Siswa
```

---

## 📁 Struktur Folder Model

```
app/Models/
│
├── UserModel.php              # Model untuk tabel 'users'
├── NewsModel.php              # Model untuk tabel 'news'
├── SettingModel.php           # Model untuk tabel 'settings'
├── SliderModel.php            # Model untuk tabel 'sliders'
├── CbtExamModel.php           # Model untuk tabel 'cbt_exams'
├── CbtQuestionModel.php       # Model untuk tabel 'cbt_questions'
├── CbtResultModel.php         # Model untuk tabel 'cbt_results'
├── CbtAnswerModel.php         # Model untuk tabel 'cbt_answers'
├── AttendanceModel.php        # Model untuk tabel 'attendance'
└── MaterialModel.php          # Model untuk tabel 'materials'
```

---

## 📁 Struktur Folder View (Frontend)

```
app/Views/
│
├── layout/
│   ├── header.php             # Header HTML (navbar, logo)
│   ├── footer.php             # Footer HTML
│   └── sidebar.php            # Sidebar untuk Dashboard
│
├── home/
│   └── index.php              # Landing page publik (seperti upstegal.ac.id)
│
├── auth/
│   ├── login.php              # Halaman Login
│   └── register.php           # Halaman Register (optional)
│
├── admin/
│   ├── dashboard.php          # Dashboard Admin
│   ├── news/
│   │   ├── index.php          # List Berita
│   │   ├── create.php         # Form Tambah Berita
│   │   └── edit.php           # Form Edit Berita
│   ├── slider/
│   │   ├── index.php          # List Slider
│   │   └── create.php         # Upload Slider
│   ├── settings/
│   │   └── index.php          # Edit Settings
│   ├── users/
│   │   ├── index.php          # List User
│   │   ├── create.php         # Tambah User
│   │   └── edit.php           # Edit User
│   ├── materials/
│   │   ├── index.php          # List Materi
│   │   └── upload.php         # Upload Materi
│   ├── cbt/
│   │   ├── index.php          # List Ujian
│   │   ├── create.php         # Buat Ujian Baru
│   │   ├── questions.php      # Tambah Soal
│   │   └── results.php        # Lihat Hasil
│   └── attendance/
│       └── index.php          # Rekap Presensi
│
└── siswa/
    ├── dashboard.php          # Dashboard Siswa
    ├── attendance.php         # Halaman Presensi
    ├── cbt/
    │   ├── index.php          # List Ujian Tersedia
    │   └── exam.php           # Halaman Mengerjakan Soal
    ├── materials/
    │   └── index.php          # Download Materi
    └── profile.php            # Edit Profil
```

---

## 📁 Struktur Folder Assets (Public)

```
public/
│
├── css/
│   ├── bootstrap.min.css      # Bootstrap 5
│   ├── style.css              # Custom CSS
│   └── gravity.css            # CSS untuk efek gravity (optional)
│
├── js/
│   ├── bootstrap.bundle.min.js
│   ├── jquery.min.js          # jQuery
│   ├── matter.min.js          # Matter.js untuk Google Gravity
│   ├── gravity.js             # Script Google Gravity
│   └── main.js                # JavaScript Utama
│
├── uploads/
│   ├── news/                  # Upload gambar berita
│   ├── sliders/               # Upload slider images
│   ├── materials/             # Upload file materi (PDF, DOCX)
│   └── avatars/               # Upload avatar user
│
└── img/
    ├── logo.png
    └── default-avatar.png
```

---

## 🔧 File Konfigurasi Penting

### 1. **app/Config/Routes.php**
```php
<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public Routes
$routes->get('/', 'Home::index');

// Auth Routes
$routes->group('auth', function($routes) {
    $routes->get('login', 'Auth\Login::index');
    $routes->post('login', 'Auth\Login::authenticate');
    $routes->get('logout', 'Auth\Logout::index');
});

// Admin Routes (Protected)
$routes->group('admin', ['filter' => 'auth:admin'], function($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');
    $routes->resource('news', ['controller' => 'Admin\News']);
    $routes->resource('slider', ['controller' => 'Admin\Slider']);
    $routes->get('settings', 'Admin\Settings::index');
    $routes->post('settings/update', 'Admin\Settings::update');
    $routes->resource('users', ['controller' => 'Admin\Users']);
    $routes->resource('materials', ['controller' => 'Admin\Materials']);
    $routes->resource('cbt', ['controller' => 'Admin\Cbt']);
    $routes->get('cbt/(:num)/questions', 'Admin\CbtQuestions::index/$1');
    $routes->post('cbt/(:num)/questions', 'Admin\CbtQuestions::create/$1');
    $routes->get('cbt/(:num)/results', 'Admin\CbtResults::index/$1');
    $routes->get('attendance', 'Admin\Attendance::index');
});

// Siswa Routes (Protected)
$routes->group('siswa', ['filter' => 'auth:siswa'], function($routes) {
    $routes->get('dashboard', 'Siswa\Dashboard::index');
    $routes->get('attendance', 'Siswa\Attendance::index');
    $routes->post('attendance/checkin', 'Siswa\Attendance::checkin');
    $routes->get('cbt', 'Siswa\Cbt::index');
    $routes->get('cbt/(:num)/start', 'Siswa\Cbt::start/$1');
    $routes->post('cbt/(:num)/submit', 'Siswa\Cbt::submit/$1');
    $routes->get('materials', 'Siswa\Materials::index');
    $routes->get('materials/download/(:num)', 'Siswa\Materials::download/$1');
    $routes->get('profile', 'Siswa\Profile::index');
});
```

### 2. **app/Config/Filters.php**
Tambahkan custom filter untuk autentikasi role-based:

```php
<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
    public array $aliases = [
        'csrf'     => \CodeIgniter\Filters\CSRF::class,
        'toolbar'  => \CodeIgniter\Filters\DebugToolbar::class,
        'honeypot' => \CodeIgniter\Filters\Honeypot::class,
        'auth'     => \App\Filters\AuthFilter::class, // Custom Auth Filter
    ];

    public array $globals = [
        'before' => [
            // 'honeypot',
            // 'csrf',
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
        ],
    ];

    public array $methods = [];

    public array $filters = [];
}
```

### 3. **app/Filters/AuthFilter.php** (Custom Filter)
Buat filter untuk cek role:

```php
<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        if (!$session->get('logged_in')) {
            return redirect()->to('/auth/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        // Check role jika ada argument
        if ($arguments) {
            $required_role = $arguments[0];
            $user_role = $session->get('role');
            
            if ($user_role !== $required_role) {
                return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
```

---

## 📌 Catatan Implementasi

### **Model Best Practices (CodeIgniter 4):**
```php
<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'username', 'email', 'password', 'full_name', 
        'role', 'avatar', 'phone', 'address', 'nis', 
        'kelas', 'is_active'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
        'email'    => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[6]',
        'full_name'=> 'required',
        'role'     => 'required|in_list[admin,siswa]'
    ];
    
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_BCRYPT);
        }
        return $data;
    }
}
```

---

## 🎯 Langkah Selanjutnya

1. **Import Database Schema** (`database_schema.sql`) ke MySQL
2. **Konfigurasi `.env`** untuk koneksi database
3. **Buat Controllers** sesuai struktur di atas
4. **Buat Models** dengan validation rules
5. **Buat Views** dengan Bootstrap 5
6. **Implementasi Google Gravity** menggunakan Matter.js
7. **Testing** setiap fitur

---

**Selamat Mengembangkan Sistem Informasi Sekolah! 🚀**
