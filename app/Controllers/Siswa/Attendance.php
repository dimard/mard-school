<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\ClassModel;
use App\Models\ClassScheduleModel;
use App\Models\ClassAttendanceModel;
use App\Models\ClassMemberModel;

class Attendance extends BaseController
{
    protected $classModel;
    protected $scheduleModel;
    protected $attendanceModel;
    protected $memberModel;

    public function __construct()
    {
        $this->classModel = new ClassModel();
        $this->scheduleModel = new ClassScheduleModel();
        $this->attendanceModel = new ClassAttendanceModel();
        $this->memberModel = new ClassMemberModel();
    }

    public function index($classId = null)
    {
        if (!$classId) {
            return redirect()->to('siswa/classes');
        }

        // Verify membership
        $isMember = $this->memberModel
            ->where('class_id', $classId)
            ->where('student_id', session()->get('user_id'))
            ->first();

        if (!$isMember) {
            return redirect()->to('siswa/classes')->with('error', 'You are not a member of this class');
        }

        $class = $this->classModel->find($classId);

        // Check active schedule
        $activeSchedule = $this->scheduleModel->getActiveSchedule($classId);

        // Check if already checked in today
        $today = date('Y-m-d');
        $hasCheckedIn = $this->attendanceModel->hasCheckedIn($classId, session()->get('user_id'), $today);

        $data = [
            'class' => $class,
            'active_schedule' => $activeSchedule,
            'has_checked_in' => $hasCheckedIn,
            'history' => $this->attendanceModel->getStudentHistory($classId, session()->get('user_id'))
        ];

        return view('siswa/attendance/index', $data);
    }

    public function checkIn($classId = null)
    {
        if (!$classId) {
            return redirect()->to('siswa/classes')->with('error', 'Invalid class specified');
        }

        // Verify membership
        $isMember = $this->memberModel
            ->where('class_id', $classId)
            ->where('student_id', session()->get('user_id'))
            ->first();

        if (!$isMember) {
            return redirect()->to('siswa/classes')->with('error', 'Access denied');
        }

        // Validate active schedule again
        $activeSchedule = $this->scheduleModel->getActiveSchedule($classId);
        if (!$activeSchedule) {
            return redirect()->back()->with('error', 'No active class session right now');
        }

        // Check duplicate
        $today = date('Y-m-d');
        if ($this->attendanceModel->hasCheckedIn($classId, session()->get('user_id'), $today)) {
            return redirect()->back()->with('error', 'You have already checked in today');
        }

        $this->attendanceModel->insert([
            'class_id' => $classId,
            'user_id' => session()->get('user_id'),
            'schedule_id' => $activeSchedule['id'],
            'date' => $today,
            'check_in_time' => date('Y-m-d H:i:s'),
            'status' => 'present'
        ]);

        return redirect()->back()->with('message', 'Check-in successful! You are marked present.');
    }
}
