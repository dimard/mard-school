<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\CbtExamModel;
use App\Models\ClassModel;

class Cbt extends BaseController
{
    protected $cbtExamModel;
    protected $classModel;

    public function __construct()
    {
        $this->cbtExamModel = new CbtExamModel();
        $this->classModel = new ClassModel();
    }

    public function index()
    {
        $teacherId = session()->get('user_id');

        // Find exams created by this teacher
        // OR exams linked to classes taught by this teacher
        // For simplicity, let's stick to exams created by this teacher for now
        // But better is exams linked to classes where teacher_id = $teacherId

        // Approach: fetch classes taught by teacher
        $classes = $this->classModel->where('teacher_id', $teacherId)->findAll();
        $classIds = array_column($classes, 'id');

        if (empty($classIds)) {
            $exams = [];
        } else {
            $exams = $this->cbtExamModel
                ->whereIn('class_id', $classIds)
                ->findAll();
        }

        $data = [
            'exams' => $exams
        ];
        return view('guru/cbt/index', $data);
    }

    public function create()
    {
        $teacherId = session()->get('user_id');
        $data['classes'] = $this->classModel->where('teacher_id', $teacherId)->findAll();

        return view('guru/cbt/create', $data);
    }

    public function store()
    {
        $teacherId = session()->get('user_id');

        // Validation: Verify class_id belongs to teacher
        $classId = $this->request->getPost('class_id');
        $class = $this->classModel->where('id', $classId)->where('teacher_id', $teacherId)->first();

        if (!$class && session()->get('role') != 'admin') {
            return redirect()->back()->withInput()->with('error', 'Unauthorized class selection');
        }

        $data = [
            'class_id' => $classId,
            'exam_name' => $this->request->getPost('exam_name'),
            'description' => $this->request->getPost('description'),
            'start_time' => $this->request->getPost('start_time'),
            'end_time' => $this->request->getPost('end_time'),
            'duration_minutes' => $this->request->getPost('duration_minutes'),
            'passing_score' => $this->request->getPost('passing_score'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'created_by' => $teacherId
        ];

        if ($this->cbtExamModel->insert($data) === false) {
            return redirect()->back()->withInput()->with('errors', $this->cbtExamModel->errors());
        }
        return redirect()->to(base_url('guru/cbt'))->with('message', 'Exam created successfully');
    }

    public function edit($id)
    {
        $teacherId = session()->get('user_id');

        $exam = $this->cbtExamModel->find($id);
        if (!$exam) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Exam not found');
        }

        // Verify ownership/permission via class
        $class = $this->classModel->find($exam['class_id']);
        if ($class['teacher_id'] != $teacherId) {
            return redirect()->to(base_url('guru/cbt'))->with('error', 'Unauthorized access');
        }

        $data = [
            'exam' => $exam,
            'classes' => $this->classModel->where('teacher_id', $teacherId)->findAll()
        ];

        return view('guru/cbt/edit', $data);
    }

    public function update($id)
    {
        $teacherId = session()->get('user_id');

        $exam = $this->cbtExamModel->find($id);
        if (!$exam) {
            return redirect()->back()->with('error', 'Exam not found');
        }

        // Verify ownership
        $class = $this->classModel->find($exam['class_id']);
        if ($class['teacher_id'] != $teacherId) {
            return redirect()->to(base_url('guru/cbt'))->with('error', 'Unauthorized access');
        }

        $data = [
            'exam_name' => $this->request->getPost('exam_name'),
            'description' => $this->request->getPost('description'),
            'start_time' => $this->request->getPost('start_time'),
            'end_time' => $this->request->getPost('end_time'),
            'duration_minutes' => $this->request->getPost('duration_minutes'),
            'passing_score' => $this->request->getPost('passing_score'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0
        ];

        if ($this->cbtExamModel->update($id, $data) === false) {
            return redirect()->back()->withInput()->with('errors', $this->cbtExamModel->errors());
        }
        return redirect()->to(base_url('guru/cbt'))->with('message', 'Exam updated successfully');
    }

    public function delete($id)
    {
        // Similar verification logic...
        $teacherId = session()->get('user_id');
        $exam = $this->cbtExamModel->find($id);

        if ($exam) {
            $class = $this->classModel->find($exam['class_id']);
            if ($class['teacher_id'] == $teacherId) {
                $this->cbtExamModel->delete($id);
                return redirect()->to(base_url('guru/cbt'))->with('message', 'Exam deleted successfully');
            }
        }

        return redirect()->to(base_url('guru/cbt'))->with('error', 'Unauthorized or Not Found');
    }

    public function toggleActive($id)
    {
        $teacherId = session()->get('user_id');
        $exam = $this->cbtExamModel->find($id);
        if ($exam) {
            $class = $this->classModel->find($exam['class_id']);
            if ($class['teacher_id'] == $teacherId) {
                $newState = $exam['is_active'] ? 0 : 1;
                $this->cbtExamModel->update($id, ['is_active' => $newState]);
            }
        }
        return redirect()->back();
    }
}
