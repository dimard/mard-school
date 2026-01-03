<?php

namespace App\Controllers\Guru;

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
        $userId = session()->get('user_id');
        // Get materials uploaded by this teacher OR all materials? 
        // Plan said "managed by this teacher". But usually teachers want to see everything or share. 
        // For "Manage", let's show only theirs.

        // Actually, let's allow them to see their own uploads for management.
        $data = [
            'materials' => $this->materialModel->where('uploaded_by', $userId)->orderBy('created_at', 'DESC')->findAll(),
            'user' => session()->get()
        ];

        return view('guru/materials/index', $data);
    }

    public function upload()
    {
        return view('guru/materials/upload');
    }

    public function store()
    {
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'category' => 'required',
            'material_file' => [
                'rules' => 'uploaded[material_file]|max_size[material_file,10240]|ext_in[material_file,pdf,doc,docx,ppt,pptx,xls,xlsx,zip,rar,jpg,jpeg,png,mp4]',
                'label' => 'File'
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('material_file');
        $fileName = $file->getName();
        $randomName = $file->getRandomName();
        $fileType = $file->getClientExtension();
        $fileSize = $file->getSize();

        // Move file
        if ($file->move(FCPATH . 'uploads/materials', $randomName)) {
            $this->materialModel->insert([
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'file_name' => $fileName,
                'file_path' => $randomName,
                'file_type' => $fileType,
                'file_size' => $fileSize,
                'category' => $this->request->getPost('category'),
                'uploaded_by' => session()->get('user_id'), // Current teacher
                'download_count' => 0,
                'is_active' => 1
            ]);

            return redirect()->to('guru/materials')->with('message', 'Material uploaded successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to upload file');
    }

    public function delete($id)
    {
        $material = $this->materialModel->find($id);

        if (!$material) {
            return redirect()->to('guru/materials')->with('error', 'Material not found');
        }

        // Verify ownership
        if ($material['uploaded_by'] != session()->get('user_id')) {
            return redirect()->to('guru/materials')->with('error', 'You do not have permission to delete this material');
        }

        // Delete file
        $filePath = FCPATH . 'uploads/materials/' . $material['file_path'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $this->materialModel->delete($id);

        return redirect()->to('guru/materials')->with('message', 'Material deleted successfully');
    }
}
