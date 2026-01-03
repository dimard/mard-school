<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\ClassModel;
use App\Models\ClassMemberModel;
use App\Models\StudentConductModel;

class Conduct extends BaseController
{
    protected $classModel;
    protected $classMemberModel;
    protected $conductModel;

    public function __construct()
    {
        $this->classModel = new ClassModel();
        $this->classMemberModel = new ClassMemberModel();
        $this->conductModel = new StudentConductModel();
    }

    public function index()
    {
        $teacherId = session()->get('user_id');

        // Get classes taught by this teacher
        $classes = $this->classModel->where('teacher_id', $teacherId)->findAll();

        // If a class is selected via query param
        $selectedClassId = $this->request->getGet('class_id');
        $students = [];

        if ($selectedClassId) {
            // Verify ownership
            $class = $this->classModel->find($selectedClassId);
            if (!$class || $class['teacher_id'] != $teacherId) {
                return redirect()->to('guru/conduct')->with('error', 'Unauthorized access');
            }

            // Get students
            $students = $this->classMemberModel->getStudentsByClass($selectedClassId);

            // Attach existing conduct
            foreach ($students as &$student) {
                $student['conduct'] = $this->conductModel->getStudentConduct($student['id'], $selectedClassId);
            }
        }

        $data = [
            'classes' => $classes,
            'selectedClassId' => $selectedClassId,
            'students' => $students
        ];

        return view('guru/conduct/index', $data);
    }

    public function save()
    {
        $teacherId = session()->get('user_id');
        $classId = $this->request->getPost('class_id');
        $studentId = $this->request->getPost('student_id');

        // Verification
        $class = $this->classModel->find($classId);
        if (!$class || $class['teacher_id'] != $teacherId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $data = [
            'student_id' => $studentId,
            'class_id' => $classId,
            'teacher_id' => $teacherId,
            'grade' => $this->request->getPost('grade'),
            'description' => $this->request->getPost('description'),
            'academic_year' => date('Y'), // Simplify for now
            'semester' => '1' // Defaulting for now
        ];

        // Check if exists to update or insert
        $existing = $this->conductModel->where('student_id', $studentId)
            ->where('class_id', $classId)
            ->first();

        if ($existing) {
            $this->conductModel->update($existing['id'], $data);
        } else {
            $this->conductModel->insert($data);
        }

        return $this->response->setJSON(['success' => true, 'message' => 'Saved successfully']);
    }
}
