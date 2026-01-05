<?php

namespace App\Models;

use CodeIgniter\Model;

class AttendanceModel extends Model
{
    protected $table = 'attendance';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'user_id',
        'attendance_date',
        'check_in_time',
        'status',
        'notes',
        'location',
        'ip_address'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'user_id' => 'required|integer',
        'attendance_date' => 'required|valid_date',
        'status' => 'in_list[hadir,izin,sakit,alpha]'
    ];

    /**
     * Check if user already checked in today
     */
    public function hasCheckedInToday($userId)
    {
        $today = date('Y-m-d');
        $record = $this->where('user_id', $userId)
            ->where('attendance_date', $today)
            ->first();
        return $record !== null;
    }

    /**
     * Check in attendance
     */
    public function checkIn($userId, $location = null, $ipAddress = null)
    {
        if ($this->hasCheckedInToday($userId)) {
            return false; // Already checked in
        }

        return $this->insert([
            'user_id' => $userId,
            'attendance_date' => date('Y-m-d'),
            'check_in_time' => date('Y-m-d H:i:s'),
            'status' => 'hadir',
            'location' => $location,
            'ip_address' => $ipAddress
        ]);
    }

    /**
     * Get attendance by date range
     */
    public function getAttendanceByDateRange($startDate, $endDate, $userId = null)
    {
        $builder = $this->select('attendance.*, users.full_name, users.nis, users.kelas')
            ->join('users', 'users.id = attendance.user_id')
            ->where('attendance_date >=', $startDate)
            ->where('attendance_date <=', $endDate);

        if ($userId) {
            $builder->where('attendance.user_id', $userId);
        }

        return $builder->orderBy('attendance_date', 'DESC')->findAll();
    }

    /**
     * Get attendance statistics
     */
    public function getAttendanceStats($userId, $month = null, $year = null)
    {
        $month = $month ?? date('m');
        $year = $year ?? date('Y');

        $builder = $this->where('user_id', $userId)
            ->where("EXTRACT(MONTH FROM attendance_date)", $month)
            ->where("EXTRACT(YEAR FROM attendance_date)", $year);

        $total = $builder->countAllResults(false);
        $hadir = $builder->where('status', 'hadir')->countAllResults(false);
        $izin = $builder->where('status', 'izin')->countAllResults(false);
        $sakit = $builder->where('status', 'sakit')->countAllResults(false);
        $alpha = $builder->where('status', 'alpha')->countAllResults();

        return [
            'total' => $total,
            'hadir' => $hadir,
            'izin' => $izin,
            'sakit' => $sakit,
            'alpha' => $alpha
        ];
    }
}
