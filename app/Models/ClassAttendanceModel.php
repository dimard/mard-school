<?php

namespace App\Models;

use CodeIgniter\Model;

class ClassAttendanceModel extends Model
{
    protected $table = 'class_attendance';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['class_id', 'user_id', 'schedule_id', 'date', 'check_in_time', 'status'];
    protected $useTimestamps = false;

    /**
     * Check if user has checked in today for a specific class
     */
    public function hasCheckedIn($classId, $userId, $date)
    {
        return $this->where('class_id', $classId)
            ->where('user_id', $userId)
            ->where('date', $date)
            ->first();
    }

    /**
     * Get attendance history for a class on a specific date
     */
    public function getHistory($classId, $date)
    {
        return $this->select('class_attendance.*, users.full_name, users.nis')
            ->join('users', 'users.id = class_attendance.user_id')
            ->where('class_attendance.class_id', $classId)
            ->where('class_attendance.date', $date)
            ->orderBy('check_in_time', 'ASC')
            ->findAll();
    }

    /**
     * Get specific student attendance history
     */
    public function getStudentHistory($classId, $userId)
    {
        return $this->where('class_id', $classId)
            ->where('user_id', $userId)
            ->orderBy('date', 'DESC')
            ->findAll();
    }
}
