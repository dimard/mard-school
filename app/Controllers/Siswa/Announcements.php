<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\AnnouncementModel;
use App\Models\AnnouncementCommentModel;
use App\Models\ClassModel;
use App\Models\ClassMemberModel;

class Announcements extends BaseController
{
    protected $announcementModel;
    protected $commentModel;
    protected $classModel;
    protected $memberModel;

    public function __construct()
    {
        $this->announcementModel = new AnnouncementModel();
        $this->commentModel = new AnnouncementCommentModel();
        $this->classModel = new ClassModel();
        $this->memberModel = new ClassMemberModel();
    }

    /**
     * List all announcements for a class (student view)
     */
    public function index($classId)
    {
        // Verify student is a member of this class
        $isMember = $this->memberModel
            ->where('class_id', $classId)
            ->where('student_id', session()->get('user_id'))
            ->first();

        if (!$isMember) {
            return redirect()->to('siswa/classes')->with('error', 'You are not a member of this class');
        }

        $class = $this->classModel->find($classId);

        $data = [
            'class' => $class,
            'announcements' => $this->announcementModel->getByClassWithCommentCount($classId)
        ];

        return view('siswa/announcements/index', $data);
    }

    /**
     * View single announcement with comments
     */
    public function view($announcementId)
    {
        $announcement = $this->announcementModel->getWithAuthor($announcementId);

        if (!$announcement) {
            return redirect()->to('siswa/classes')->with('error', 'Announcement not found');
        }

        // Verify student is a member of this class
        $isMember = $this->memberModel
            ->where('class_id', $announcement['class_id'])
            ->where('student_id', session()->get('user_id'))
            ->first();

        if (!$isMember) {
            return redirect()->to('siswa/classes')->with('error', 'Access denied');
        }

        $class = $this->classModel->find($announcement['class_id']);
        $comments = $this->commentModel->getByAnnouncement($announcementId);

        $data = [
            'announcement' => $announcement,
            'class' => $class,
            'comments' => $comments
        ];

        return view('siswa/announcements/view', $data);
    }

    /**
     * Add comment to announcement
     */
    public function addComment($announcementId)
    {
        $announcement = $this->announcementModel->find($announcementId);

        if (!$announcement) {
            return redirect()->to('siswa/classes')->with('error', 'Announcement not found');
        }

        // Verify student is a member of this class
        $isMember = $this->memberModel
            ->where('class_id', $announcement['class_id'])
            ->where('student_id', session()->get('user_id'))
            ->first();

        if (!$isMember) {
            return redirect()->to('siswa/classes')->with('error', 'Access denied');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'comment' => 'required|min_length[1]|max_length[1000]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->with('error', 'Comment cannot be empty');
        }

        $data = [
            'announcement_id' => $announcementId,
            'user_id' => session()->get('user_id'),
            'comment' => $this->request->getPost('comment')
        ];

        $this->commentModel->insert($data);

        return redirect()->to('siswa/announcements/view/' . $announcementId)
            ->with('message', 'Comment posted successfully');
    }
}
