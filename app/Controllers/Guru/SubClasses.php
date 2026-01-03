<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\SubClassModel;
use App\Models\SubClassMemberModel;
use App\Models\AnnouncementModel;
use App\Models\AssignmentModel;
use App\Models\MaterialModel;

class SubClasses extends BaseController
{
    protected $subClassModel;
    protected $subClassMemberModel;
    protected $announcementModel;
    protected $assignmentModel;
    protected $materialModel;

    public function __construct()
    {
        $this->subClassModel = new SubClassModel();
        $this->subClassMemberModel = new SubClassMemberModel();
        $this->announcementModel = new AnnouncementModel();
        $this->assignmentModel = new AssignmentModel();
        $this->materialModel = new MaterialModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $subClasses = $this->subClassModel->getByTeacher($userId);

        $data = [
            'subClasses' => $subClasses,
            'user' => session()->get()
        ];

        return view('guru/sub_classes/index', $data);
    }

    public function view($subClassId)
    {
        $subClass = $this->subClassModel->getWithMemberCount($subClassId);

        if (!$subClass) {
            return redirect()->to('guru/sub-classes')->with('error', 'Sub class not found');
        }

        // Verify teacher authorization
        if ($subClass['teacher_id'] != session()->get('user_id') && session()->get('role') != 'admin') {
            return redirect()->to('guru/sub-classes')->with('error', 'Access denied');
        }

        //Get members
        $members = $this->subClassMemberModel->getMembers($subClassId);

        // Get announcements for stream
        $announcements = $this->announcementModel->getBySubClassWithCommentCount($subClassId);

        // Get assignments
        $assignments = $this->assignmentModel->getBySubClassWithSubmissionCount($subClassId);

        // Get materials
        $materials = $this->materialModel->getBySubClass($subClassId);

        $data = [
            'subClass' => $subClass,
            'members' => $members,
            'announcements' => $announcements,
            'assignments' => $assignments,
            'materials' => $materials,
            'tab' => $this->request->getGet('tab') ?? 'stream',
            'user' => session()->get()
        ];

        return view('guru/sub_classes/view', $data);
    }

    // ==================== ANNOUNCEMENTS ====================

    public function createAnnouncement($subClassId)
    {
        $subClass = $this->subClassModel->find($subClassId);

        if (!$subClass || ($subClass['teacher_id'] != session()->get('user_id') && session()->get('role') != 'admin')) {
            return redirect()->back()->with('error', 'Access denied');
        }

        $data = [
            'subClass' => $subClass,
            'user' => session()->get()
        ];

        return view('guru/sub_classes/create_announcement', $data);
    }

    public function storeAnnouncement($subClassId)
    {
        $subClass = $this->subClassModel->find($subClassId);

        if (!$subClass || ($subClass['teacher_id'] != session()->get('user_id') && session()->get('role') != 'admin')) {
            return redirect()->back()->with('error', 'Access denied');
        }

        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'content' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->announcementModel->insert([
            'class_id' => $subClass['class_id'], // Reference to main class
            'sub_class_id' => $subClassId,
            'is_general' => 0,
            'user_id' => session()->get('user_id'),
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content')
        ]);

        return redirect()->to('guru/sub-classes/view/' . $subClassId . '?tab=stream')
            ->with('message', 'Announcement created successfully');
    }

    // ==================== ASSIGNMENTS ====================

    public function createAssignment($subClassId)
    {
        $subClass = $this->subClassModel->find($subClassId);

        if (!$subClass || ($subClass['teacher_id'] != session()->get('user_id') && session()->get('role') != 'admin')) {
            return redirect()->back()->with('error', 'Access denied');
        }

        $data = [
            'subClass' => $subClass,
            'user' => session()->get()
        ];

        return view('guru/sub_classes/create_assignment', $data);
    }

    public function storeAssignment($subClassId)
    {
        $subClass = $this->subClassModel->find($subClassId);

        if (!$subClass || ($subClass['teacher_id'] != session()->get('user_id') && session()->get('role') != 'admin')) {
            return redirect()->back()->with('error', 'Access denied');
        }

        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'description' => 'required',
            'deadline' => 'required|valid_date',
            'max_score' => 'required|integer|greater_than[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->assignmentModel->insert([
            'class_id' => $subClass['class_id'],
            'sub_class_id' => $subClassId,
            'user_id' => session()->get('user_id'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'deadline' => $this->request->getPost('deadline'),
            'max_score' => $this->request->getPost('max_score')
        ]);

        return redirect()->to('guru/sub-classes/view/' . $subClassId . '?tab=assignments')
            ->with('message', 'Assignment created successfully');
    }

    public function gradeAssignment($assignmentId)
    {
        // Get assignment and verify authorization
        $assignment = $this->assignmentModel->getWithAuthor($assignmentId);

        if (!$assignment || ($assignment['user_id'] != session()->get('user_id') && session()->get('role') != 'admin')) {
            return redirect()->back()->with('error', 'Access denied');
        }

        // Get submissions
        $submissionModel = new \App\Models\AssignmentSubmissionModel();
        $submissions = $submissionModel
            ->select('assignment_submissions.*, users.full_name, users.nis')
            ->join('users', 'users.id = assignment_submissions.user_id')
            ->where('assignment_id', $assignmentId)
            ->findAll();

        $data = [
            'assignment' => $assignment,
            'submissions' => $submissions,
            'user' => session()->get()
        ];

        return view('guru/sub_classes/grade_assignment', $data);
    }

    // ==================== MATERIALS ====================

    public function createMaterial($subClassId)
    {
        $subClass = $this->subClassModel->find($subClassId);

        if (!$subClass || ($subClass['teacher_id'] != session()->get('user_id') && session()->get('role') != 'admin')) {
            return redirect()->back()->with('error', 'Access denied');
        }

        $data = [
            'subClass' => $subClass,
            'user' => session()->get()
        ];

        return view('guru/sub_classes/create_material', $data);
    }

    public function storeMaterial($subClassId)
    {
        $subClass = $this->subClassModel->find($subClassId);

        if (!$subClass || ($subClass['teacher_id'] != session()->get('user_id') && session()->get('role') != 'admin')) {
            return redirect()->back()->with('error', 'Access denied');
        }

        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'description' => 'permit_empty',
            'file' => 'uploaded[file]|max_size[file,10240]' // 10MB max
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('file');

        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/materials', $newName);

            $this->materialModel->insert([
                'class_id' => $subClass['class_id'],
                'sub_class_id' => $subClassId,
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'file_name' => $file->getName(),
                'file_path' => 'writable/uploads/materials/' . $newName,
                'file_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'category' => $this->request->getPost('category') ?? 'General',
                'uploaded_by' => session()->get('user_id'),
                'is_active' => 1
            ]);

            return redirect()->to('guru/sub-classes/view/' . $subClassId . '?tab=materials')
                ->with('message', 'Material uploaded successfully');
        }

        return redirect()->back()->with('error', 'Failed to upload file');
    }
}
