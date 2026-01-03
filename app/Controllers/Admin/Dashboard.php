<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\NewsModel;
use App\Models\CbtExamModel;
use App\Models\AttendanceModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $newsModel = new NewsModel();
        $cbtExamModel = new CbtExamModel();
        $attendanceModel = new AttendanceModel();

        // Get statistics
        $data = [
            'totalSiswa' => $userModel->where('role', 'siswa')->countAllResults(),
            'totalBerita' => $newsModel->countAllResults(),
            'activeExams' => count($cbtExamModel->getActiveExams()),
            'todayAttendance' => $attendanceModel->where('attendance_date', date('Y-m-d'))->countAllResults(),
            'recentNews' => $newsModel->getPublishedNews(5)
        ];

        return view('admin/dashboard', $data);
    }
}
