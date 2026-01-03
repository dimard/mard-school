<?php

namespace App\Models;

use CodeIgniter\Model;

class PPDBRegistrationModel extends Model
{
    protected $table = 'ppdb_registrations';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'registration_number',
        'full_name',
        'nik',
        'birth_place',
        'birth_date',
        'gender',
        'email',
        'phone',
        'address',
        'parent_name',
        'parent_phone',
        'parent_occupation',
        'previous_school',
        'photo',
        'document_ijazah',
        'document_kk',
        'document_akta',
        'status',
        'admin_notes',
        'verified_by',
        'verified_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get all registrations with optional status filter
     */
    public function getRegistrations($status = null, $limit = null, $offset = 0)
    {
        $builder = $this->orderBy('created_at', 'DESC');

        if ($status && $status !== 'all') {
            $builder->where('status', $status);
        }

        if ($limit) {
            $builder->limit($limit, $offset);
        }

        return $builder->findAll();
    }

    /**
     * Get registration by number
     */
    public function getByNumber($regNumber)
    {
        return $this->where('registration_number', $regNumber)->first();
    }

    /**
     * Generate unique registration number
     */
    public function generateRegNumber()
    {
        $year = date('Y');
        $month = date('m');

        // Format: PPDB-YYYYMM-XXXX
        $prefix = "PPDB-{$year}{$month}-";

        // Get last registration number for this month
        $lastReg = $this->like('registration_number', $prefix, 'after')
            ->orderBy('id', 'DESC')
            ->first();

        if ($lastReg) {
            // Extract number and increment
            $lastNumber = (int) substr($lastReg['registration_number'], -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Update registration status
     */
    public function updateStatus($id, $status, $notes = null, $userId = null)
    {
        $data = [
            'status' => $status,
            'admin_notes' => $notes,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($userId && in_array($status, ['verified', 'approved'])) {
            $data['verified_by'] = $userId;
            $data['verified_at'] = date('Y-m-d H:i:s');
        }

        return $this->update($id, $data);
    }

    /**
     * Get statistics
     */
    public function getStatistics()
    {
        return [
            'total' => $this->countAll(),
            'pending' => $this->where('status', 'pending')->countAllResults(),
            'verified' => $this->where('status', 'verified')->countAllResults(),
            'approved' => $this->where('status', 'approved')->countAllResults(),
            'rejected' => $this->where('status', 'rejected')->countAllResults(),
        ];
    }

    /**
     * Check if registration is full
     */
    public function isQuotaFull()
    {
        $settingModel = new PPDBSettingModel();
        $quota = (int) $settingModel->getSetting('ppdb_quota', 0);

        if ($quota <= 0) {
            return false; // No limit
        }

        $approved = $this->where('status', 'approved')->countAllResults();
        return $approved >= $quota;
    }

    /**
     * Search registrations
     */
    public function search($keyword)
    {
        return $this->groupStart()
            ->like('full_name', $keyword)
            ->orLike('registration_number', $keyword)
            ->orLike('email', $keyword)
            ->orLike('phone', $keyword)
            ->groupEnd()
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }
}
