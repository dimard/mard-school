<?php

namespace App\Controllers\Siswa;

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
        $data = [
            'materials' => $this->materialModel->getActiveMaterials()
        ];
        return view('siswa/materials/index', $data);
    }

    public function download($id)
    {
        $material = $this->materialModel->find($id);
        if (!$material) {
            return redirect()->back()->with('error', 'Material not found');
        }

        $filePath = FCPATH . 'uploads/materials/' . $material['file_path'];
        if (file_exists($filePath)) {
            return $this->response->download($filePath, null);
        } else {
            return redirect()->back()->with('error', 'File not found on server');
        }
    }
}
