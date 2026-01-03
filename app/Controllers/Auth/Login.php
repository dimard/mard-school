<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\NavigationLinkModel;
use App\Models\SettingModel;

class Login extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form']);
    }

    /**
     * Display login page
     */
    public function index()
    {
        // If already logged in, redirect to dashboard
        if (session()->get('is_logged_in')) {
            $role = session()->get('role');
            if ($role === 'admin') {
                return redirect()->to('/admin/dashboard');
            } elseif ($role === 'guru') {
                return redirect()->to('/guru/dashboard');
            } else {
                return redirect()->to('/siswa/dashboard');
            }
        }

        // Load navbar and settings data like homepage
        $navLinkModel = new NavigationLinkModel();
        $settingModel = new SettingModel();

        $data = [
            'nav_links' => $navLinkModel->getActiveLinks(),
            'settings' => $settingModel->getAllSettings()
        ];

        return view('auth/login', $data);
    }

    /**
     * Handle login authentication
     */
    public function authenticate()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Verify credentials
        $user = $this->userModel->verifyCredentials($username, $password);

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Username atau password salah');
        }

        if (!$user['is_active']) {
            return redirect()->back()->withInput()->with('error', 'Akun Anda tidak aktif. Silakan hubungi administrator.');
        }

        // Set session data
        $sessionData = [
            'user_id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'full_name' => $user['full_name'],
            'role' => $user['role'],
            'avatar' => $user['avatar'],
            'is_logged_in' => true
        ];

        session()->set($sessionData);

        // Redirect based on role
        if ($user['role'] === 'admin') {
            return redirect()->to('/admin/dashboard')->with('success', 'Selamat datang, ' . $user['full_name']);
        } elseif ($user['role'] === 'guru') {
            return redirect()->to('/guru/dashboard')->with('success', 'Selamat datang, ' . $user['full_name']);
        } else {
            return redirect()->to('/siswa/dashboard')->with('success', 'Selamat datang, ' . $user['full_name']);
        }
    }
}
