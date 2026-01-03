<?php

namespace App\Models;

use CodeIgniter\Model;

class PublicCbtAccessModel extends Model
{
    protected $table = 'public_cbt_access';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'exam_id',
        'access_code',
        'max_participants',
        'current_participants'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'exam_id' => 'required|integer',
        'access_code' => 'required|min_length[4]|max_length[50]|is_unique[public_cbt_access.access_code,id,{id}]'
    ];

    /**
     * Get access info by access code
     */
    public function getByAccessCode($code)
    {
        return $this->where('access_code', $code)->first();
    }

    /**
     * Get access info by exam ID
     */
    public function getByExamId($examId)
    {
        return $this->where('exam_id', $examId)->first();
    }

    /**
     * Generate unique access code
     */
    public function generateAccessCode($length = 8)
    {
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $maxAttempts = 10;

        for ($attempt = 0; $attempt < $maxAttempts; $attempt++) {
            $code = '';
            for ($i = 0; $i < $length; $i++) {
                $code .= $characters[rand(0, strlen($characters) - 1)];
            }

            // Check if code already exists
            if (!$this->where('access_code', $code)->first()) {
                return $code;
            }
        }

        // If still can't generate unique code, add timestamp
        return $code . time();
    }

    /**
     * Validate access code for exam
     */
    public function validateAccessCode($examId, $code)
    {
        $access = $this->where('exam_id', $examId)
            ->where('access_code', $code)
            ->first();

        if (!$access) {
            return false;
        }

        // Check capacity if max_participants is set
        if (
            $access['max_participants'] !== null &&
            $access['current_participants'] >= $access['max_participants']
        ) {
            return false;
        }

        return true;
    }

    /**
     * Increment participants count
     */
    public function incrementParticipants($examId)
    {
        $access = $this->where('exam_id', $examId)->first();
        if ($access) {
            return $this->update($access['id'], [
                'current_participants' => $access['current_participants'] + 1
            ]);
        }
        return false;
    }

    /**
     * Check if exam has reached capacity
     */
    public function checkCapacity($examId)
    {
        $access = $this->where('exam_id', $examId)->first();

        if (!$access) {
            return false;
        }

        // If no max limit, always has capacity
        if ($access['max_participants'] === null) {
            return true;
        }

        return $access['current_participants'] < $access['max_participants'];
    }

    /**
     * Get exam with access code info
     */
    public function getExamWithAccessCode($examId)
    {
        return $this->select('public_cbt_access.*, cbt_exams.*')
            ->join('cbt_exams', 'cbt_exams.id = public_cbt_access.exam_id')
            ->where('public_cbt_access.exam_id', $examId)
            ->first();
    }
}
