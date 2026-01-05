<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SliderModel;

class Sliders extends BaseController
{
    protected $sliderModel;

    public function __construct()
    {
        $this->sliderModel = new SliderModel();
    }

    /**
     * List all sliders
     */
    public function index()
    {
        $data = [
            'sliders' => $this->sliderModel->orderBy('sort_order', 'ASC')->findAll()
        ];

        return view('admin/sliders/index', $data);
    }

    /**
     * Show create form
     */
    public function create()
    {
        $data = [
            'slider' => null,
            'action' => 'create'
        ];

        return view('admin/sliders/form', $data);
    }

    /**
     * Store new slider
     */
    public function store()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'title' => 'required|max_length[255]',
            'description' => 'permit_empty|max_length[1000]',
            'button_text' => 'permit_empty|max_length[100]',
            'button_url' => 'permit_empty|max_length[255]',
            'sort_order' => 'permit_empty|integer',
            'slider_image' => 'uploaded[slider_image]|max_size[slider_image,5120]|is_image[slider_image]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Handle image upload
        $image = $this->request->getFile('slider_image');
        $newName = null;

        if ($image && $image->isValid() && !$image->hasMoved()) {
            // Vercel handling: Convert to Base64
            $type = $image->getClientMimeType();
            $data = file_get_contents($image->getTempName());
            $newName = 'data:' . $type . ';base64,' . base64_encode($data);
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'image_url' => $newName,
            'button_text' => $this->request->getPost('button_text') ?? 'Get Started',
            'button_url' => $this->request->getPost('button_url') ?? 'auth/login',
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'is_active' => $this->request->getPost('is_active') ? 1 : 0
        ];

        if ($this->sliderModel->insert($data)) {
            return redirect()->to('admin/sliders')->with('message', 'Slider created successfully');
        }

        return redirect()->back()->with('error', 'Failed to create slider');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $slider = $this->sliderModel->find($id);

        if (!$slider) {
            return redirect()->to('admin/sliders')->with('error', 'Slider not found');
        }

        $data = [
            'slider' => $slider,
            'action' => 'edit'
        ];

        return view('admin/sliders/form', $data);
    }

    /**
     * Update slider
     */
    public function update($id)
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'title' => 'required|max_length[255]',
            'description' => 'permit_empty|max_length[1000]',
            'button_text' => 'permit_empty|max_length[100]',
            'button_url' => 'permit_empty|max_length[255]',
            'sort_order' => 'permit_empty|integer',
            'slider_image' => 'permit_empty|max_size[slider_image,5120]|is_image[slider_image]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $slider = $this->sliderModel->find($id);
        if (!$slider) {
            return redirect()->to('admin/sliders')->with('error', 'Slider not found');
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'button_text' => $this->request->getPost('button_text') ?? 'Get Started',
            'button_url' => $this->request->getPost('button_url') ?? 'auth/login',
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'is_active' => $this->request->getPost('is_active') ? 1 : 0
        ];

        // Handle image upload if new image provided
        $image = $this->request->getFile('slider_image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            // Vercel handling: Convert to Base64
            $type = $image->getClientMimeType();
            $fileData = file_get_contents($image->getTempName());
            $data['image_url'] = 'data:' . $type . ';base64,' . base64_encode($fileData);
        }

        if ($this->sliderModel->update($id, $data)) {
            return redirect()->to('admin/sliders')->with('message', 'Slider updated successfully');
        }

        return redirect()->back()->with('error', 'Failed to update slider');
    }

    /**
     * Delete slider
     */
    public function delete($id)
    {
        $slider = $this->sliderModel->find($id);

        if (!$slider) {
            return redirect()->to('admin/sliders')->with('error', 'Slider not found');
        }

        // Delete image file
        // Delete image file (Skipped: Using Base64 in DB)
        // if ($slider['image_url'] && file_exists(FCPATH . 'uploads/sliders/' . $slider['image_url'])) {
        //     unlink(FCPATH . 'uploads/sliders/' . $slider['image_url']);
        // }

        if ($this->sliderModel->delete($id)) {
            return redirect()->to('admin/sliders')->with('message', 'Slider deleted successfully');
        }

        return redirect()->back()->with('error', 'Failed to delete slider');
    }

    /**
     * Set slider as active (deactivate others)
     */
    public function setActive($id)
    {
        $slider = $this->sliderModel->find($id);

        if (!$slider) {
            return redirect()->to('admin/sliders')->with('error', 'Slider not found');
        }

        // Deactivate all sliders
        $this->sliderModel->where('is_active', 1)->set(['is_active' => 0])->update();

        // Activate selected slider
        if ($this->sliderModel->update($id, ['is_active' => 1])) {
            return redirect()->to('admin/sliders')->with('message', 'Slider set as active');
        }

        return redirect()->back()->with('error', 'Failed to activate slider');
    }
}
