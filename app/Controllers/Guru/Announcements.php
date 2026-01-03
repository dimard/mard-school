<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\AnnouncementModel;
use App\Models\AnnouncementCommentModel;
use App\Models\ClassModel;

class Announcements extends BaseController
{
    protected $announcementModel;
    protected $commentModel;
    protected $classModel;

    public function __construct()
    {
        $this->announcementModel = new AnnouncementModel();
        $this->commentModel = new AnnouncementCommentModel();
        $this->classModel = new ClassModel();
    }

    /**
     * List all announcements for a class
     */
    public function index($classId)
    {
        // Verify teacher owns this class
        $class = $this->classModel->find($classId);
        if (!$class || $class['teacher_id'] != session()->get('user_id')) {
            return redirect()->to('guru/classes')->with('error', 'Access denied');
        }

        $data = [
            'class' => $class,
            'announcements' => $this->announcementModel->getByClassWithCommentCount($classId)
        ];

        return view('guru/announcements/index', $data);
    }

    /**
     * Show create announcement form
     */
    public function create($classId)
    {
        // Verify teacher owns this class
        $class = $this->classModel->find($classId);
        if (!$class || $class['teacher_id'] != session()->get('user_id')) {
            return redirect()->to('guru/classes')->with('error', 'Access denied');
        }

        $data = ['class' => $class];
        return view('guru/announcements/create', $data);
    }

    /**
     * Store new announcement
     */
    public function store($classId)
    {
        // Verify teacher owns this class
        $class = $this->classModel->find($classId);
        if (!$class || $class['teacher_id'] != session()->get('user_id')) {
            return redirect()->to('guru/classes')->with('error', 'Access denied');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'title' => 'required|min_length[3]|max_length[255]',
            'content' => 'required|min_length[10]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'class_id' => $classId,
            'user_id' => session()->get('user_id'),
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content')
        ];

        $this->announcementModel->insert($data);

        return redirect()->to('guru/classes/announcements/' . $classId)
            ->with('message', 'Announcement posted successfully');
    }

    /**
     * Show edit announcement form
     */
    public function edit($id)
    {
        $announcement = $this->announcementModel->find($id);

        if (!$announcement || $announcement['user_id'] != session()->get('user_id')) {
            return redirect()->to('guru/classes')->with('error', 'Access denied');
        }

        $class = $this->classModel->find($announcement['class_id']);

        $data = [
            'announcement' => $announcement,
            'class' => $class
        ];

        return view('guru/announcements/edit', $data);
    }

    /**
     * Update announcement
     */
    public function update($id)
    {
        $announcement = $this->announcementModel->find($id);

        if (!$announcement || $announcement['user_id'] != session()->get('user_id')) {
            return redirect()->to('guru/classes')->with('error', 'Access denied');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'title' => 'required|min_length[3]|max_length[255]',
            'content' => 'required|min_length[10]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content')
        ];

        $this->announcementModel->update($id, $data);

        return redirect()->to('guru/classes/announcements/' . $announcement['class_id'])
            ->with('message', 'Announcement updated successfully');
    }

    /**
     * View announcement details with comments
     */
    public function view($id)
    {
        $announcement = $this->announcementModel->getWithAuthor($id);

        if (!$announcement) {
            return redirect()->to('guru/classes')->with('error', 'Announcement not found');
        }

        // Verify teacher owns this class
        $class = $this->classModel->find($announcement['class_id']);
        if (!$class || $class['teacher_id'] != session()->get('user_id')) {
            return redirect()->to('guru/classes')->with('error', 'Access denied');
        }

        // Get comments
        $comments = $this->commentModel->getByAnnouncement($id);

        $data = [
            'announcement' => $announcement,
            'class' => $class,
            'comments' => $comments
        ];

        return view('guru/announcements/view', $data);
    }

    /**
     * Delete announcement
     */
    public function delete($id)
    {
        $announcement = $this->announcementModel->find($id);

        if (!$announcement || $announcement['user_id'] != session()->get('user_id')) {
            return redirect()->to('guru/classes')->with('error', 'Access denied');
        }

        $classId = $announcement['class_id'];

        // Delete comments first
        $this->commentModel->where('announcement_id', $id)->delete();

        // Delete announcement
        $this->announcementModel->delete($id);

        return redirect()->to('guru/classes/announcements/' . $classId)
            ->with('message', 'Announcement deleted successfully');
    }
}
