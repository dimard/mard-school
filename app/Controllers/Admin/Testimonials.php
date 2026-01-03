<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TestimonialModel;

class Testimonials extends BaseController
{
    protected $testimonialModel;

    public function __construct()
    {
        $this->testimonialModel = new TestimonialModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manage Testimonials',
            'testimonials' => $this->testimonialModel->orderBy('created_at', 'DESC')->findAll()
        ];
        return view('admin/testimonials/index', $data);
    }

    public function create()
    {
        $data = ['title' => 'Add Testimonial'];
        return view('admin/testimonials/form', $data);
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
            'role' => 'required|min_length[3]|max_length[255]',
            'content' => 'required',
            'photo' => 'uploaded[photo]|max_size[photo,1024]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $photo = $this->request->getFile('photo');
        $photoName = $photo->getRandomName();
        $photo->move(ROOTPATH . 'public/uploads/testimonials', $photoName);

        $this->testimonialModel->save([
            'name' => $this->request->getPost('name'),
            'role' => $this->request->getPost('role'),
            'content' => $this->request->getPost('content'),
            'photo' => $photoName
        ]);

        return redirect()->to('/admin/testimonials')->with('success', 'Testimonial added successfully');
    }

    public function edit($id)
    {
        $testimonial = $this->testimonialModel->find($id);
        if (!$testimonial) {
            return redirect()->to('/admin/testimonials')->with('error', 'Testimonial not found');
        }

        $data = [
            'title' => 'Edit Testimonial',
            'testimonial' => $testimonial
        ];
        return view('admin/testimonials/form', $data);
    }

    public function update($id)
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
            'role' => 'required|min_length[3]|max_length[255]',
            'content' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id' => $id,
            'name' => $this->request->getPost('name'),
            'role' => $this->request->getPost('role'),
            'content' => $this->request->getPost('content')
        ];

        $photo = $this->request->getFile('photo');
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $newName = $photo->getRandomName();
            $photo->move(ROOTPATH . 'public/uploads/testimonials', $newName);
            $data['photo'] = $newName;
        }

        $this->testimonialModel->save($data);

        return redirect()->to('/admin/testimonials')->with('success', 'Testimonial updated successfully');
    }

    public function delete($id)
    {
        $this->testimonialModel->delete($id);
        return redirect()->to('/admin/testimonials')->with('success', 'Testimonial deleted successfully');
    }
}
