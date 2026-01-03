<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\ReportModel;
use App\Models\ClassModel;

class Reports extends BaseController
{
    protected $reportModel;
    protected $classModel;

    public function __construct()
    {
        $this->reportModel = new ReportModel();
        $this->classModel = new ClassModel();
    }

    /**
     * Display general reports index (optional - for future enhancements)
     */
    public function index()
    {
        $teacherId = session()->get('user_id');

        // Get recent activity (last 20 items)
        $recentActivity = $this->reportModel->getTeacherRecentActivity($teacherId, 20);

        $data = [
            'results' => $recentActivity
        ];

        return view('guru/reports/index', $data);
    }

    /**
     * Display class report with student grades and rankings
     */
    public function classReport($classId)
    {
        // Verify teacher owns this class
        $class = $this->classModel->find($classId);
        if (!$class || $class['teacher_id'] != session()->get('user_id')) {
            return redirect()->to('guru/classes')->with('error', 'Access denied');
        }

        // Get class report
        $report = $this->reportModel->getClassReport($classId);
        $statistics = $this->reportModel->getClassStatistics($report);

        $data = [
            'class' => $class,
            'report' => $report,
            'statistics' => $statistics
        ];

        return view('guru/reports/class_report', $data);
    }
}
