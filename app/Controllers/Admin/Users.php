<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Default to showing all users
        $data = [
            'users' => $this->userModel->findAll(),
            'title' => 'All Users'
        ];
        return view('admin/users/index', $data);
    }

    public function students()
    {
        $data = [
            'users' => $this->userModel->where('role', 'siswa')->findAll(),
            'title' => 'Manage Students'
        ];
        // For now using the same view, logic can be separated later
        return view('admin/users/index', $data);
    }

    public function teachers()
    {
        $data = [
            'users' => $this->userModel->where('role', 'guru')->findAll(),
            'title' => 'Manage Teachers'
        ];
        return view('admin/users/index', $data);
    }

    public function create()
    {
        return view('admin/users/create');
    }

    public function store()
    {
        // Basic validation and storage logic
        $rules = [
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role' => 'required',
            'full_name' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),  // Raw password - Model will hash it via beforeInsert callback
            'full_name' => $this->request->getPost('full_name'),
            'role' => $this->request->getPost('role'),
            'is_active' => 1
        ];

        // Add student-specific fields if role is siswa
        if ($this->request->getPost('role') === 'siswa') {
            $data['nis'] = $this->request->getPost('nis');
            $data['kelas'] = $this->request->getPost('kelas');
            $data['phone'] = $this->request->getPost('phone');
            $data['address'] = $this->request->getPost('address');
        }

        $this->userModel->insert($data);
        return redirect()->to(base_url('admin/users'))->with('message', 'User created successfully');
    }

    public function edit($id)
    {
        $data['user'] = $this->userModel->find($id);
        if (!$data['user']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User not found');
        }
        return view('admin/users/edit', $data);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        $rules = [
            'username' => "required|min_length[3]|is_unique[users.username,id,{$id}]",
            'email' => "required|valid_email|is_unique[users.email,id,{$id}]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'full_name' => $this->request->getPost('full_name'),
            'role' => $this->request->getPost('role'),
        ];

        // Only update password if provided
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);
        return redirect()->to(base_url('admin/users'))->with('message', 'User updated successfully');
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        return redirect()->back()->with('message', 'User deleted successfully');
    }
}
