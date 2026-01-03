<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ClassModel;
use App\Models\ClassMemberModel;
use App\Models\StudentConductModel;
use App\Models\ReportSettingModel;
use App\Models\UserModel;

class Reports extends BaseController
{
    protected $classModel;
    protected $classMemberModel;
    protected $conductModel;
    protected $settingModel;
    protected $userModel;

    public function __construct()
    {
        $this->classModel = new ClassModel();
        $this->classMemberModel = new ClassMemberModel();
        $this->conductModel = new StudentConductModel();
        $this->settingModel = new ReportSettingModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data['classes'] = $this->classModel->findAll();
        $data['settings'] = $this->settingModel->getSettings();

        $classId = $this->request->getGet('class_id');
        $students = [];

        if ($classId) {
            $students = $this->classMemberModel->getStudentsByClass($classId);
        }

        $data['selectedClassId'] = $classId;
        $data['students'] = $students;

        return view('admin/reports/index', $data);
    }

    public function settings()
    {
        $data['settings'] = $this->settingModel->getSettings();
        return view('admin/reports/settings', $data);
    }

    public function updateSettings()
    {
        $data = [
            'header_content' => $this->request->getPost('header_content'),
            'footer_content' => $this->request->getPost('footer_content'),
            'watermark_enabled' => $this->request->getPost('watermark_enabled') ? 1 : 0
        ];

        $settings = $this->settingModel->first();
        if ($settings) {
            $this->settingModel->update($settings['id'], $data);
        } else {
            $this->settingModel->insert($data);
        }

        return redirect()->to('admin/reports')->with('message', 'Settings updated successfully');
    }

    public function print($studentId, $classId)
    {
        // 1. Fetch Student & Class
        $student = $this->userModel->find($studentId);
        $class = $this->classModel->find($classId);

        if (!$student || !$class) {
            return redirect()->back()->with('error', 'Data not found');
        }

        // 2. Fetch Aggregated Grades
        // Assignments (Group by Subject/Defaults for now since we don't have subjects table properly linked yet)
        $db = \Config\Database::connect();

        $assignmentGrades = $db->table('class_assignments as ca')
            ->select('ca.id, ca.title, sub.score')
            ->join('assignment_submissions as sub', 'sub.assignment_id = ca.id AND sub.user_id = ' . $studentId, 'left')
            ->where('ca.class_id', $classId)
            ->get()->getResultArray();

        $totalScore = 0;
        $count = 0;
        foreach ($assignmentGrades as $grade) {
            if ($grade['score'] !== null) {
                $totalScore += $grade['score'];
                $count++;
            }
        }
        $avgAssignment = $count > 0 ? round($totalScore / $count) : 0;

        // Fetch CBT Grades (Class & Global)
        $cbtGrades = $db->table('cbt_results as r')
            ->select('e.exam_name, r.score, e.class_id')
            ->join('cbt_exams as e', 'e.id = r.exam_id')
            ->where('r.user_id', $studentId)
            ->groupStart()
            ->where('e.class_id', $classId)
            ->orWhere('e.class_id', null)
            ->groupEnd()
            ->get()->getResultArray();

        $totalCbt = 0;
        $countCbt = 0;
        foreach ($cbtGrades as $g) {
            $totalCbt += $g['score'];
            $countCbt++;
        }
        $avgCbt = $countCbt > 0 ? round($totalCbt / $countCbt) : 0;

        // 3. Fetch Conduct
        $conduct = $this->conductModel->getStudentConduct($studentId, $classId);

        // 4. Fetch Settings
        $settings = $this->settingModel->getSettings();

        // 5. Overall Average
        $overallAvg = round(($avgAssignment + $avgCbt) / 2);

        // Prepare Data
        $data = [
            'student' => $student,
            'class' => $class,
            'assignment_avg' => $avgAssignment,
            'cbt_avg' => $avgCbt,
            'overall_avg' => $overallAvg,
            'cbt_details' => $cbtGrades,
            'conduct' => $conduct,
            'settings' => $settings,
            'academic_year' => date('Y') . '/' . (date('Y') + 1), // Mock
            'semester' => 'Odd' // Mock
        ];

        return view('admin/reports/print_view', $data);
    }
}
