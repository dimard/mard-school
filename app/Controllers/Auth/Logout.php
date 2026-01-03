<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;

class Logout extends BaseController
{
    /**
     * Handle logout
     */
    public function index()
    {
        // Destroy session
        session()->destroy();

        return redirect()->to('/auth/login')->with('success', 'Anda telah berhasil logout');
    }
}
