<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\CbtExamModel;
use App\Models\AttendanceModel;
use App\Models\MaterialModel;
use App\Models\CbtResultModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');

        $cbtExamModel = new CbtExamModel();
        $attendanceModel = new AttendanceModel();
        $materialModel = new MaterialModel();
        $cbtResultModel = new CbtResultModel();

        // Get student data
        $data = [
            'activeExams' => $cbtExamModel->getActiveExams(),
            'hasCheckedInToday' => $attendanceModel->hasCheckedInToday($userId),
            'recentMaterials' => $materialModel->getActiveMaterials(),
            'examHistory' => $cbtResultModel->getStudentHistory($userId),
            'attendanceStats' => $attendanceModel->getAttendanceStats($userId)
        ];

        return view('siswa/dashboard', $data);
    }
}
