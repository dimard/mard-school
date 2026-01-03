<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\ClassModel;
use App\Models\ClassMemberModel;
use App\Models\UserModel;

class Classes extends BaseController
{
    protected $classModel;
    protected $classMemberModel;
    protected $userModel;
    protected $subClassModel;
    protected $subClassMemberModel;

    public function __construct()
    {
        $this->classModel = new ClassModel();
        $this->classMemberModel = new ClassMemberModel();
        $this->userModel = new UserModel();
        $this->subClassModel = new \App\Models\SubClassModel();
        $this->subClassMemberModel = new \App\Models\SubClassMemberModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        // Get classes (Admin sees all, Teacher sees own)
        if (session()->get('role') == 'admin') {
            $classes = $this->classModel->findAll();
            $view = 'admin/classes/index';
        } else {
            $classes = $this->classModel->where('teacher_id', $userId)->findAll();
            $view = 'guru/classes/index';
        }

        $data = [
            'classes' => $classes,
            'user' => session()->get()
        ];

        return view($view, $data);
    }

    public function create()
    {
        $data = [];
        if (session()->get('role') == 'admin') {
            $data['teachers'] = $this->userModel->where('role', 'guru')->findAll();
            $view = 'admin/classes/create';
        } else {
            $view = 'guru/classes/create';
        }
        return view($view, $data);
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
            'description' => 'permit_empty|max_length[1000]'
        ];

        if (session()->get('role') == 'admin') {
            $rules['teacher_id'] = 'required|integer|is_not_unique[users.id]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $code = $this->classModel->generateCode();
        $userId = session()->get('user_id');

        // Determine teacher_id
        if (session()->get('role') == 'admin') {
            $teacherId = $this->request->getPost('teacher_id');
        } else {
            $teacherId = $userId;
        }

        $this->classModel->insert([
            'code' => $code,
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'teacher_id' => $teacherId,
            'created_by' => $userId
        ]);

        $redirectBase = session()->get('role') == 'admin' ? 'admin' : 'guru';
        return redirect()->to($redirectBase . '/classes')->with('message', 'Class created successfully. Code: ' . $code);
    }

    public function view($id)
    {
        $class = $this->classModel->find($id);

        if (!$class) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Verify ownership (allow admin to bypass)
        if (session()->get('role') != 'admin' && $class['teacher_id'] != session()->get('user_id')) {
            $redirectBase = session()->get('role') == 'admin' ? 'admin' : 'guru';
            return redirect()->to($redirectBase . '/classes')->with('error', 'Access denied');
        }

        $members = $this->classMemberModel->getMembers($id);

        // Get announcements for stream
        $announcementModel = new \App\Models\AnnouncementModel();
        $announcements = $announcementModel->getByClassWithCommentCount($id);

        // Get assignments
        $assignmentModel = new \App\Models\AssignmentModel();
        $assignments = $assignmentModel->getWithSubmissionCount($id);

        $data = [
            'class' => $class,
            'members' => $members,
            'announcements' => $announcements,
            'assignments' => $assignments,
            'tab' => $this->request->getGet('tab') ?? 'stream',
            'user' => session()->get()
        ];

        $view = session()->get('role') == 'admin' ? 'admin/classes/view' : 'guru/classes/view';
        return view($view, $data);
    }

    // ==================== SUB CLASS MANAGEMENT ====================

    public function createSubClass($classId)
    {
        $class = $this->classModel->find($classId);
        if (!$class || ($class['teacher_id'] != session()->get('user_id') && session()->get('role') != 'admin')) {
            return redirect()->back()->with('error', 'Access denied');
        }

        $teachers = $this->userModel->where('role', 'guru')->findAll();

        $data = [
            'class' => $class,
            'teachers' => $teachers,
            'user' => session()->get()
        ];

        $view = session()->get('role') == 'admin' ? 'admin/classes/create_sub_class' : 'guru/classes/create_sub_class';
        return view($view, $data);
    }

    public function storeSubClass($classId)
    {
        $class = $this->classModel->find($classId);
        if (!$class || ($class['teacher_id'] != session()->get('user_id') && session()->get('role') != 'admin')) {
            return redirect()->back()->with('error', 'Access denied');
        }

        $rules = [
            'subject_name' => 'required|min_length[3]|max_length[255]',
            'teacher_id' => 'required|integer|is_not_unique[users.id]',
            'description' => 'permit_empty|max_length[1000]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $code = $this->subClassModel->generateCode();

        $subClassId = $this->subClassModel->insert([
            'class_id' => $classId,
            'subject_name' => $this->request->getPost('subject_name'),
            'teacher_id' => $this->request->getPost('teacher_id'),
            'code' => $code,
            'description' => $this->request->getPost('description')
        ]);

        // Auto-add all class members to sub class
        $this->subClassMemberModel->addMembersFromClass($subClassId, $classId);

        $redirectBase = session()->get('role') == 'admin' ? 'admin' : 'guru';
        return redirect()->to($redirectBase . '/classes/view/' . $classId . '?tab=subclasses')
            ->with('message', 'Sub class created successfully. Code: ' . $code);
    }

    public function editSubClass($subClassId)
    {
        $subClass = $this->subClassModel->find($subClassId);
        if (!$subClass) {
            return redirect()->back()->with('error', 'Sub class not found');
        }

        $class = $this->classModel->find($subClass['class_id']);
        if (!$class || ($class['teacher_id'] != session()->get('user_id') && session()->get('role') != 'admin')) {
            return redirect()->back()->with('error', 'Access Denied');
        }

        $teachers = $this->userModel->where('role', 'guru')->findAll();

        $data = [
            'class' => $class,
            'subClass' => $subClass,
            'teachers' => $teachers,
            'user' => session()->get()
        ];

        $view = session()->get('role') == 'admin' ? 'admin/classes/edit_sub_class' : 'guru/classes/edit_sub_class';
        return view($view, $data);
    }

    public function updateSubClass($subClassId)
    {
        $subClass = $this->subClassModel->find($subClassId);
        if (!$subClass) {
            return redirect()->back()->with('error', 'Sub class not found');
        }

        $class = $this->classModel->find($subClass['class_id']);
        if (!$class || ($class['teacher_id'] != session()->get('user_id') && session()->get('role') != 'admin')) {
            return redirect()->back()->with('error', 'Access denied');
        }

        $rules = [
            'subject_name' => 'required|min_length[3]|max_length[255]',
            'teacher_id' => 'required|integer|is_not_unique[users.id]',
            'description' => 'permit_empty|max_length[1000]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->subClassModel->update($subClassId, [
            'subject_name' => $this->request->getPost('subject_name'),
            'teacher_id' => $this->request->getPost('teacher_id'),
            'description' => $this->request->getPost('description')
        ]);

        $redirectBase = session()->get('role') == 'admin' ? 'admin' : 'guru';
        return redirect()->to($redirectBase . '/classes/view/' . $class['id'] . '?tab=subclasses')
            ->with('message', 'Sub class updated successfully');
    }

    public function deleteSubClass($subClassId)
    {
        $subClass = $this->subClassModel->find($subClassId);
        if (!$subClass) {
            return redirect()->back()->with('error', 'Sub class not found');
        }

        $class = $this->classModel->find($subClass['class_id']);
        if (!$class || ($class['teacher_id'] != session()->get('user_id') && session()->get('role') != 'admin')) {
            return redirect()->back()->with('error', 'Access denied');
        }

        // Delete sub class and its members
        $this->subClassMemberModel->removeAllMembers($subClassId);
        $this->subClassModel->delete($subClassId);

        $redirectBase = session()->get('role') == 'admin' ? 'admin' : 'guru';
        return redirect()->to($redirectBase . '/classes/view/' . $class['id'] . '?tab=subclasses')
            ->with('message', 'Sub class deleted successfully');
    }

    // ==================== CONDUCT MANAGEMENT ====================

    public function conduct($classId)
    {
        $class = $this->classModel->find($classId);
        if (!$class || ($class['teacher_id'] != session()->get('user_id') && session()->get('role') != 'admin')) {
            return redirect()->back()->with('error', 'Access denied');
        }

        $members = $this->classMemberModel->getMembers($classId);
        $conductModel = new \App\Models\StudentConductModel();

        // Get existing conducts
        $conducts = [];
        foreach ($members as $member) {
            $conduct = $conductModel
                ->where('student_id', $member['student_id'])
                ->where('class_id', $classId)
                ->first();
            $conducts[$member['student_id']] = $conduct;
        }

        $data = [
            'class' => $class,
            'members' => $members,
            'conducts' => $conducts,
            'user' => session()->get()
        ];

        $view = session()->get('role') == 'admin' ? 'admin/classes/conduct' : 'guru/classes/conduct';
        return view($view, $data);
    }

    public function storeConductBatch($classId)
    {
        $class = $this->classModel->find($classId);
        if (!$class || ($class['teacher_id'] != session()->get('user_id') && session()->get('role') != 'admin')) {
            return redirect()->back()->with('error', 'Access denied');
        }

        $conductModel = new \App\Models\StudentConductModel();
        $conducts = $this->request->getPost('conducts');

        if (!$conducts) {
            return redirect()->back()->with('error', 'No conduct data provided');
        }

        foreach ($conducts as $studentId => $conductData) {
            if (empty($conductData['grade'])) {
                continue;
            }

            $existing = $conductModel
                ->where('student_id', $studentId)
                ->where('class_id', $classId)
                ->first();

            $data = [
                'student_id' => $studentId,
                'class_id' => $classId,
                'grade' => $conductData['grade'],
                'description' => $conductData['description'] ?? null,
                'teacher_id' => session()->get('user_id'),
                'academic_year' => $conductData['academic_year'] ?? date('Y'),
                'semester' => $conductData['semester'] ?? '1'
            ];

            if ($existing) {
                $conductModel->update($existing['id'], $data);
            } else {
                $conductModel->insert($data);
            }
        }

        $redirectBase = session()->get('role') == 'admin' ? 'admin' : 'guru';
        return redirect()->to($redirectBase . '/classes/view/' . $classId . '?tab=conduct')
            ->with('message', 'Conduct data saved successfully');
    }

    // ==================== REPORT OVERVIEW ====================

    public function reportOverview($classId)
    {
        $class = $this->classModel->find($classId);
        if (!$class || ($class['teacher_id'] != session()->get('user_id') && session()->get('role') != 'admin')) {
            return redirect()->back()->with('error', 'Access denied');
        }

        $subClasses = $this->subClassModel->getByClassWithMemberCount($classId);

        // Get assignment statistics for each sub class
        $assignmentModel = new \App\Models\AssignmentModel();
        $subClassStats = [];

        foreach ($subClasses as $subClass) {
            $assignments = $assignmentModel->getBySubClass($subClass['id']);
            $totalAssignments = count($assignments);

            // This is a simplified version - you might want to calculate actual average scores
            $subClassStats[$subClass['id']] = [
                'total_assignments' => $totalAssignments,
                'average_score' => 0, // Placeholder - calculate from actual submissions
                'completion_rate' => 0 // Placeholder - calculate from actual submissions
            ];
        }

        $data = [
            'class' => $class,
            'subClasses' => $subClasses,
            'subClassStats' => $subClassStats,
            'user' => session()->get()
        ];

        $view = session()->get('role') == 'admin' ? 'admin/classes/reports' : 'guru/classes/reports';
        return view($view, $data);
    }
}
