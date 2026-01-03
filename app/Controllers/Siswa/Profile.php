<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $data = [
            'user' => $this->userModel->find($userId)
        ];
        return view('siswa/profile/index', $data);
    }

    public function update()
    {
        $userId = session()->get('user_id');

        $rules = [
            'full_name' => 'required|min_length[3]',
            'kelas' => 'permit_empty'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'kelas' => $this->request->getPost('kelas')
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->userModel->update($userId, $data);
        return redirect()->to(base_url('siswa/profile'))->with('message', 'Profile updated successfully');
    }
}
