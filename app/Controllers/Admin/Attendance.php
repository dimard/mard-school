<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AttendanceModel;
use App\Models\UserModel;

class Attendance extends BaseController
{
    protected $attendanceModel;
    protected $userModel;

    public function __construct()
    {
        $this->attendanceModel = new AttendanceModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $date = $this->request->getGet('date') ?? date('Y-m-d');

        $data = [
            'date' => $date,
            'attendance' => $this->attendanceModel
                ->select('attendance.*, users.full_name, users.username')
                ->join('users', 'users.id = attendance.user_id')
                ->where('attendance_date', $date)
                ->findAll()
        ];

        return view('admin/attendance/index', $data);
    }

    public function scan()
    {
        return view('admin/attendance/scan');
    }

    public function ajax_scan()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        $qrContent = $this->request->getPost('qr_content');

        // Assume QR content is the username
        $user = $this->userModel->where('username', $qrContent)->first();

        if (!$user) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User not found'
            ]);
        }

        if ($this->attendanceModel->hasCheckedInToday($user['id'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User ' . $user['full_name'] . ' already checked in today.'
            ]);
        }

        $inserted = $this->attendanceModel->checkIn($user['id'], 'School Generic Check-in', $this->request->getIPAddress());

        if ($inserted) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Attendance recorded for ' . $user['full_name'],
                'user' => $user
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to record attendance'
            ]);
        }
    }

    public function recap()
    {
        $month = $this->request->getGet('month') ?? date('m');
        $year = $this->request->getGet('year') ?? date('Y');

        // Get all students and teachers
        $users = $this->userModel->whereIn('role', ['siswa', 'guru'])->findAll();

        $recapData = [];
        foreach ($users as $user) {
            $stats = $this->attendanceModel->getAttendanceStats($user['id'], $month, $year);
            $recapData[] = [
                'user' => $user,
                'stats' => $stats
            ];
        }

        $data = [
            'month' => $month,
            'year' => $year,
            'recap' => $recapData
        ];

        return view('admin/attendance/recap', $data);
    }

    public function filter()
    {
        $date = $this->request->getPost('date');
        return redirect()->to(base_url('admin/attendance?date=' . $date));
    }
}
