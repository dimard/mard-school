<?php

namespace App\Models;

use CodeIgniter\Model;

class ClassScheduleModel extends Model
{
    protected $table = 'class_schedules';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['class_id', 'day_of_week', 'start_time', 'end_time'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get schedules for a class
     */
    public function getSchedules($classId)
    {
        return $this->where('class_id', $classId)
            ->orderBy('day_of_week', 'ASC')
            ->orderBy('start_time', 'ASC')
            ->findAll();
    }

    /**
     * Check if class is currently active based on schedule
     * Returns matching schedule or null
     */
    public function getActiveSchedule($classId)
    {
        $currentDay = date('N'); // 1 (Mon) to 7 (Sun)
        $currentTime = date('H:i:s');

        return $this->where('class_id', $classId)
            ->where('day_of_week', $currentDay)
            ->where('start_time <=', $currentTime)
            ->where('end_time >=', $currentTime)
            ->first();
    }
}
