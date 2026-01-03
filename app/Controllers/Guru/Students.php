<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Students extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Get all students
        $students = $this->userModel->where('role', 'siswa')->orderBy('full_name', 'ASC')->findAll();

        $data = [
            'students' => $students,
            'user' => session()->get()
        ];

        return view('guru/students/index', $data);
    }
}
