<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\NewsModel;

class News extends BaseController
{
    protected $newsModel;

    public function __construct()
    {
        $this->newsModel = new NewsModel();
    }

    public function index()
    {
        $data = [
            'news' => $this->newsModel->orderBy('created_at', 'DESC')->findAll()
        ];
        return view('admin/news/index', $data);
    }

    public function create()
    {
        return view('admin/news/create');
    }

    public function store()
    {
        $rules = [
            'title' => 'required|min_length[3]',
            'content' => 'required',
            'status' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Generate slug from title (auto-generate to avoid validation errors)
        $slug = url_title($this->request->getPost('title'), '-', true);

        // Convert status (published/draft) to is_published (1/0)
        $status = $this->request->getPost('status');
        $isPublished = ($status === 'published') ? 1 : 0;

        $data = [
            'title' => $this->request->getPost('title'),
            'slug' => $slug,
            'content' => $this->request->getPost('content'),
            'is_published' => $isPublished,
            'published_at' => $isPublished ? date('Y-m-d H:i:s') : null,
            'author_id' => session()->get('user_id')  // FIX: use 'user_id' not 'id'
        ];

        // Handle image upload
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move(FCPATH . 'uploads/news', $newName);
            $data['thumbnail'] = $newName;  // FIX: use 'thumbnail' not 'image'
        }

        $this->newsModel->insert($data);
        return redirect()->to(base_url('admin/news'))->with('message', 'News created successfully');
    }

    public function edit($id)
    {
        $data['news'] = $this->newsModel->find($id);
        if (!$data['news']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('News not found');
        }
        return view('admin/news/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'title' => 'required|min_length[3]',
            'content' => 'required',
            'status' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Regenerate slug from title
        $slug = url_title($this->request->getPost('title'), '-', true);

        // Convert status to is_published
        $status = $this->request->getPost('status');
        $isPublished = ($status === 'published') ? 1 : 0;

        $data = [
            'title' => $this->request->getPost('title'),
            'slug' => $slug,
            'content' => $this->request->getPost('content'),
            'is_published' => $isPublished,
            'published_at' => $isPublished ? date('Y-m-d H:i:s') : null,
        ];

        // Handle image upload
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move(FCPATH . 'uploads/news', $newName);
            $data['thumbnail'] = $newName;
        }

        $this->newsModel->update($id, $data);
        return redirect()->to(base_url('admin/news'))->with('message', 'News updated successfully');
    }

    public function delete($id)
    {
        $this->newsModel->delete($id);
        return redirect()->to(base_url('admin/news'))->with('message', 'News deleted successfully');
    }
}
