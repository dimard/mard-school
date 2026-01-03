<?php

namespace App\Models;

use CodeIgniter\Model;

use CodeIgniter\I18n\Time;

class CbtExamModel extends Model
{
    // ... existing properties ...
    protected $table = 'cbt_exams';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'class_id',
        'exam_name',
        'description',
        'duration_minutes',
        'passing_score',
        'total_questions',
        'is_active',
        'is_public',
        'start_time',
        'end_time',
        'created_by'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'exam_name' => 'required|min_length[3]',
        'duration_minutes' => 'required|integer|greater_than[0]',
        'passing_score' => 'required|decimal',
        'created_by' => 'required|integer',
        'class_id' => 'permit_empty'
    ];

    /**
     * Get active exams for students
     */
    public function getActiveExams($classIds = [])
    {
        $this->groupStart()
            ->where('class_id', null);

        if (!empty($classIds)) {
            $this->orWhereIn('class_id', $classIds);
        }
        $this->groupEnd();

        $now = Time::now()->toDateTimeString();
        return $this->where('is_active', 1)
            ->where('start_time <=', $now)
            ->where('end_time >=', $now)
            ->findAll();
    }

    /**
     * Get exam with creator info
     */
    public function getExamWithCreator($id)
    {
        return $this->select('cbt_exams.*, users.full_name as creator_name')
            ->join('users', 'users.id = cbt_exams.created_by')
            ->where('cbt_exams.id', $id)
            ->first();
    }

    /**
     * Update total questions count
     */
    public function updateTotalQuestions($examId)
    {
        $questionModel = new \App\Models\CbtQuestionModel();
        $count = $questionModel->where('exam_id', $examId)->countAllResults();
        return $this->update($examId, ['total_questions' => $count]);
    }

    /**
     * Get active public exams
     */
    public function getActivePublicExams()
    {
        $now = Time::now()->toDateTimeString();
        return $this->where('is_public', 1)
            ->where('is_active', 1)
            ->where('start_time <=', $now)
            ->where('end_time >=', $now)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Get public exam with access code info
     */
    public function getPublicExamWithAccess($examId)
    {
        return $this->select('cbt_exams.*, public_cbt_access.access_code, 
                             public_cbt_access.max_participants, 
                             public_cbt_access.current_participants')
            ->join('public_cbt_access', 'public_cbt_access.exam_id = cbt_exams.id', 'left')
            ->where('cbt_exams.id', $examId)
            ->first();
    }

    /**
     * Check if exam is public and active
     */
    public function isPublicExamAvailable($examId)
    {
        $exam = $this->find($examId);

        if (!$exam) {
            return false;
        }

        // Check if public and active
        if (!$exam['is_public'] || !$exam['is_active']) {
            return false;
        }

        // Check time window
        $now = Time::now()->toDateTimeString();
        if ($exam['start_time'] > $now || $exam['end_time'] < $now) {
            return false;
        }

        return true;
    }
}
