<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\StaffModel;

class Staff extends BaseController
{
    protected $staffModel;

    public function __construct()
    {
        $this->staffModel = new StaffModel();
    }

    /**
     * List all staff members
     */
    public function index()
    {
        $data = [
            'staff' => $this->staffModel->orderBy('sort_order', 'ASC')->findAll()
        ];

        return view('admin/staff/index', $data);
    }

    /**
     * Show create form
     */
    public function create()
    {
        $data = [
            'staff' => null,
            'action' => 'create'
        ];

        return view('admin/staff/form', $data);
    }

    /**
     * Store new staff member
     */
    public function store()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'name' => 'required|max_length[255]',
            'position' => 'required|max_length[255]',
            'bio' => 'permit_empty|max_length[500]',
            'photo' => 'uploaded[photo]|max_size[photo,2048]|is_image[photo]',
            'facebook_url' => 'permit_empty|valid_url|max_length[255]',
            'twitter_url' => 'permit_empty|valid_url|max_length[255]',
            'linkedin_url' => 'permit_empty|valid_url|max_length[255]',
            'sort_order' => 'permit_empty|integer',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Handle photo upload
        $photo = $this->request->getFile('photo');
        $photoName = null;

        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $photoName = $photo->getRandomName();
            $photo->move(FCPATH . 'uploads/staff', $photoName);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'position' => $this->request->getPost('position'),
            'bio' => $this->request->getPost('bio'),
            'photo' => $photoName,
            'facebook_url' => $this->request->getPost('facebook_url'),
            'twitter_url' => $this->request->getPost('twitter_url'),
            'linkedin_url' => $this->request->getPost('linkedin_url'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ];

        if ($this->staffModel->insert($data)) {
            return redirect()->to('admin/staff')->with('message', 'Staff member added successfully');
        }

        return redirect()->back()->with('error', 'Failed to add staff member');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $staff = $this->staffModel->find($id);

        if (!$staff) {
            return redirect()->to('admin/staff')->with('error', 'Staff member not found');
        }

        $data = [
            'staff' => $staff,
            'action' => 'edit'
        ];

        return view('admin/staff/form', $data);
    }

    /**
     * Update staff member
     */
    public function update($id)
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'name' => 'required|max_length[255]',
            'position' => 'required|max_length[255]',
            'bio' => 'permit_empty|max_length[500]',
            'photo' => 'permit_empty|max_size[photo,2048]|is_image[photo]',
            'facebook_url' => 'permit_empty|valid_url|max_length[255]',
            'twitter_url' => 'permit_empty|valid_url|max_length[255]',
            'linkedin_url' => 'permit_empty|valid_url|max_length[255]',
            'sort_order' => 'permit_empty|integer',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $staff = $this->staffModel->find($id);
        if (!$staff) {
            return redirect()->to('admin/staff')->with('error', 'Staff member not found');
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'position' => $this->request->getPost('position'),
            'bio' => $this->request->getPost('bio'),
            'facebook_url' => $this->request->getPost('facebook_url'),
            'twitter_url' => $this->request->getPost('twitter_url'),
            'linkedin_url' => $this->request->getPost('linkedin_url'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ];

        // Handle photo upload if new photo provided
        $photo = $this->request->getFile('photo');
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            // Delete old photo
            if (isset($staff['photo']) && $staff['photo'] && file_exists(FCPATH . 'uploads/staff/' . $staff['photo'])) {
                unlink(FCPATH . 'uploads/staff/' . $staff['photo']);
            }

            // Upload new photo
            $photoName = $photo->getRandomName();
            $photo->move(FCPATH . 'uploads/staff', $photoName);
            $data['photo'] = $photoName;
        }

        if ($this->staffModel->update($id, $data)) {
            return redirect()->to('admin/staff')->with('message', 'Staff member updated successfully');
        }

        return redirect()->back()->with('error', 'Failed to update staff member');
    }

    /**
     * Delete staff member
     */
    public function delete($id)
    {
        $staff = $this->staffModel->find($id);

        if (!$staff) {
            return redirect()->to('admin/staff')->with('error', 'Staff member not found');
        }

        // Delete photo file
        if (isset($staff['photo']) && $staff['photo'] && file_exists(FCPATH . 'uploads/staff/' . $staff['photo'])) {
            unlink(FCPATH . 'uploads/staff/' . $staff['photo']);
        }

        if ($this->staffModel->delete($id)) {
            return redirect()->to('admin/staff')->with('message', 'Staff member deleted successfully');
        }

        return redirect()->back()->with('error', 'Failed to delete staff member');
    }

    /**
     * Toggle staff active status
     */
    public function toggleActive($id)
    {
        if ($this->staffModel->toggleActive($id)) {
            return redirect()->to('admin/staff')->with('message', 'Staff status updated successfully');
        }

        return redirect()->back()->with('error', 'Failed to update staff status');
    }
}
