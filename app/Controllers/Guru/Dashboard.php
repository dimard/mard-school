<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            'user' => [
                'full_name' => session()->get('full_name'),
                'email' => session()->get('email'),
                'role' => session()->get('role')
            ]
        ];

        return view('guru/dashboard/index', $data);
    }
}
