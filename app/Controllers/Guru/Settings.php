<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Settings extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Display settings page
     */
    public function index()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('guru/dashboard')->with('error', 'User not found');
        }

        $data = ['user' => $user];
        return view('guru/settings/index', $data);
    }

    /**
     * Update user settings
     */
    public function update()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('guru/dashboard')->with('error', 'User not found');
        }

        $validation = \Config\Services::validation();

        $rules = [
            'full_name' => 'required|min_length[3]|max_length[200]',
            'email' => 'required|valid_email|max_length[150]',
            'phone' => 'permit_empty|max_length[20]',
            'address' => 'permit_empty'
        ];

        // Only validate password if it's being changed
        if ($this->request->getPost('password')) {
            $rules['password'] = 'required|min_length[6]';
            $rules['password_confirm'] = 'required|matches[password]';
        }

        $validation->setRules($rules);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address')
        ];

        // Update password if provided
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        // Handle avatar upload
        $avatar = $this->request->getFile('avatar');
        if ($avatar && $avatar->isValid() && !$avatar->hasMoved()) {
            $validation->setRules([
                'avatar' => 'uploaded[avatar]|max_size[avatar,2048]|is_image[avatar]'
            ]);

            if ($validation->withRequest($this->request)->run()) {
                $newName = $avatar->getRandomName();
                $avatar->move(WRITEPATH . '../public/uploads/avatars', $newName);

                // Delete old avatar if exists
                if ($user['avatar'] && file_exists(FCPATH . 'uploads/avatars/' . $user['avatar'])) {
                    @unlink(FCPATH . 'uploads/avatars/' . $user['avatar']);
                }

                $data['avatar'] = $newName;
            }
        }

        $this->userModel->update($userId, $data);

        // Update session data
        session()->set('full_name', $data['full_name']);
        if (isset($data['avatar'])) {
            session()->set('avatar', $data['avatar']);
        }

        return redirect()->to('guru/settings')->with('message', 'Settings updated successfully');
    }
}
