<?php

namespace App\Controllers\Guru;

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

    public function index($classId)
    {
        $class = $this->classModel->find($classId);
        if (!$class || $class['teacher_id'] != session()->get('user_id')) {
            return redirect()->to('guru/classes')->with('error', 'Access denied');
        }

        $date = $this->request->getGet('date') ?? date('Y-m-d');

        $data = [
            'class' => $class,
            'schedules' => $this->scheduleModel->getSchedules($classId),
            'attendance_today' => $this->attendanceModel->getHistory($classId, $date),
            'selected_date' => $date,
            'students_count' => $this->memberModel->where('class_id', $classId)->countAllResults()
        ];

        return view('guru/attendance/index', $data);
    }

    public function storeSchedule($classId)
    {
        $class = $this->classModel->find($classId);
        if (!$class || $class['teacher_id'] != session()->get('user_id')) {
            return redirect()->to('guru/classes')->with('error', 'Access denied');
        }

        $rules = [
            'day_of_week' => 'required|integer|greater_than[0]|less_than[8]',
            'start_time' => 'required',
            'end_time' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Invalid input data');
        }

        $this->scheduleModel->insert([
            'class_id' => $classId,
            'day_of_week' => $this->request->getPost('day_of_week'),
            'start_time' => $this->request->getPost('start_time'),
            'end_time' => $this->request->getPost('end_time')
        ]);

        return redirect()->back()->with('message', 'Schedule added successfully');
    }

    public function deleteSchedule($id)
    {
        $schedule = $this->scheduleModel->find($id);
        if (!$schedule) {
            return redirect()->back()->with('error', 'Schedule not found');
        }

        // Verify class ownership
        $class = $this->classModel->find($schedule['class_id']);
        if (!$class || $class['teacher_id'] != session()->get('user_id')) {
            return redirect()->back()->with('error', 'Access denied');
        }

        $this->scheduleModel->delete($id);
        return redirect()->back()->with('message', 'Schedule deleted');
    }
}
