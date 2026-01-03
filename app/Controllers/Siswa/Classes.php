<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\ClassModel;
use App\Models\ClassMemberModel;

class Classes extends BaseController
{
    protected $classModel;
    protected $classMemberModel;

    public function __construct()
    {
        $this->classModel = new ClassModel();
        $this->classMemberModel = new ClassMemberModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');

        // Get classes joined by student
        $builder = $this->classModel->builder();
        $builder->select('classes.*, users.full_name as teacher_name');
        $builder->join('class_members', 'class_members.class_id = classes.id');
        $builder->join('users', 'users.id = classes.teacher_id');
        $builder->where('class_members.student_id', $userId);

        $classes = $builder->get()->getResultArray();

        $data = [
            'classes' => $classes,
            'user' => session()->get()
        ];

        return view('siswa/classes/index', $data);
    }

    public function join()
    {
        $code = trim($this->request->getPost('code'));

        if (empty($code)) {
            return redirect()->back()->with('error', 'Please enter a class code');
        }

        $class = $this->classModel->where('code', $code)->first();

        if (!$class) {
            return redirect()->back()->with('error', 'Invalid class code. Please check and try again.');
        }

        $userId = session()->get('user_id');

        // Check if already member
        if ($this->classMemberModel->isMember($class['id'], $userId)) {
            return redirect()->back()->with('info', 'You are already a member of this class.');
        }

        // Join class
        $this->classMemberModel->insert([
            'class_id' => $class['id'],
            'student_id' => $userId
        ]);

        // Auto-join all sub classes
        $subClassMemberModel = new \App\Models\SubClassMemberModel();
        $subClassModel = new \App\Models\SubClassModel();
        $subClasses = $subClassModel->where('class_id', $class['id'])->findAll();

        foreach ($subClasses as $subClass) {
            $subClassMemberModel->addMember($subClass['id'], $userId);
        }

        return redirect()->to('siswa/classes')->with('message', 'Successfully joined class: ' . $class['name'] . ' and ' . count($subClasses) . ' sub classes');
    }

    public function view($id)
    {
        $userId = session()->get('user_id');

        // Verify membership
        if (!$this->classMemberModel->isMember($id, $userId)) {
            return redirect()->to('siswa/classes')->with('error', 'You are not a member of this class');
        }

        $class = $this->classModel->select('classes.*, users.full_name as teacher_name')
            ->join('users', 'users.id = classes.teacher_id')
            ->where('classes.id', $id)
            ->first();

        // Get scoped materials
        $materialModel = new \App\Models\MaterialModel();
        $materials = $materialModel->where('class_id', $id)->findAll();

        // Get scoped exams
        $cbtExamModel = new \App\Models\CbtExamModel();
        $exams = $cbtExamModel->where('class_id', $id)->findAll();

        // Get announcements for stream
        $announcementModel = new \App\Models\AnnouncementModel();
        $announcements = $announcementModel->getByClassWithCommentCount($id);

        // Get assignments
        $assignmentModel = new \App\Models\AssignmentModel();
        $assignments = $assignmentModel->getByClass($id);

        // Get sub classes for this student
        $subClassMemberModel = new \App\Models\SubClassMemberModel();
        $subClasses = $subClassMemberModel->getSubClassesByClassAndStudent($id, $userId);

        $data = [
            'class' => $class,
            'materials' => $materials,
            'exams' => $exams,
            'announcements' => $announcements,
            'assignments' => $assignments,
            'subClasses' => $subClasses,
            'tab' => $this->request->getGet('tab') ?? 'stream',
            'user' => session()->get()
        ];

        return view('siswa/classes/view', $data);
    }

    public function viewSubClass($subClassId)
    {
        $userId = session()->get('user_id');

        // Get sub class with verification
        $subClassMemberModel = new \App\Models\SubClassMemberModel();

        if (!$subClassMemberModel->isMember($subClassId, $userId)) {
            return redirect()->to('siswa/classes')->with('error', 'You are not a member of this sub class');
        }

        $subClassModel = new \App\Models\SubClassModel();
        $subClass = $subClassModel->getWithTeacher($subClassId);

        if (!$subClass) {
            return redirect()->to('siswa/classes')->with('error', 'Sub class not found');
        }

        // Get announcements
        $announcementModel = new \App\Models\AnnouncementModel();
        $announcements = $announcementModel->getBySubClassWithCommentCount($subClassId);

        // Get assignments
        $assignmentModel = new \App\Models\AssignmentModel();
        $assignments = $assignmentModel->getBySubClass($subClassId);

        // Get materials
        $materialModel = new \App\Models\MaterialModel();
        $materials = $materialModel->getBySubClass($subClassId);

        $data = [
            'subClass' => $subClass,
            'announcements' => $announcements,
            'assignments' => $assignments,
            'materials' => $materials,
            'tab' => $this->request->getGet('tab') ?? 'stream',
            'user' => session()->get()
        ];

        return view('siswa/classes/sub_class_view', $data);
    }
}
