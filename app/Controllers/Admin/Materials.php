<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MaterialModel;

class Materials extends BaseController
{
    protected $materialModel;

    public function __construct()
    {
        $this->materialModel = new MaterialModel();
    }

    public function index()
    {
        $materials = $this->materialModel
            ->select('materials.*, users.full_name as uploader_name')
            ->join('users', 'users.id = materials.uploaded_by')
            ->orderBy('materials.created_at', 'DESC')
            ->findAll();

        $data = [
            'materials' => $materials
        ];

        return view('admin/materials/index', $data);
    }

    public function upload()
    {
        return view('admin/materials/upload');
    }

    public function store()
    {
        $rules = [
            'title' => 'required|min_length[3]',
            'file' => 'uploaded[file]|max_size[file,10240]' // 10MB max
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/materials', $newName);

            $data = [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'file_name' => $file->getClientName(),
                'file_path' => $newName,
                'file_type' => $file->getClientExtension(),
                'file_size' => $file->getSize(),
                'category' => $this->request->getPost('category') ?: 'Umum',
                'uploaded_by' => session()->get('user_id'),
                'is_active' => 1
            ];

            $this->materialModel->insert($data);
            return redirect()->to(base_url('admin/materials'))
                ->with('message', 'Material uploaded successfully');
        }

        return redirect()->back()->with('error', 'Failed to upload file');
    }

    public function delete($id)
    {
        $material = $this->materialModel->find($id);
        if ($material) {
            // Delete file from filesystem
            $filePath = FCPATH . 'uploads/materials/' . $material['file_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Delete database record
            $this->materialModel->delete($id);
            return redirect()->back()->with('message', 'Material deleted successfully');
        }

        return redirect()->back()->with('error', 'Material not found');
    }
}
