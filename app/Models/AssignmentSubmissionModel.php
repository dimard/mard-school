<?php

namespace App\Models;

use CodeIgniter\Model;

class AssignmentSubmissionModel extends Model
{
    protected $table = 'assignment_submissions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['assignment_id', 'user_id', 'file_path', 'submission_text', 'score', 'feedback', 'submitted_at', 'graded_at'];
    protected $useTimestamps = false;

    /**
     * Get all submissions for an assignment with student info
     */
    public function getByAssignment($assignmentId)
    {
        return $this->select('assignment_submissions.*, users.full_name, users.nis')
            ->join('users', 'users.id = assignment_submissions.user_id')
            ->where('assignment_id', $assignmentId)
            ->orderBy('submitted_at', 'DESC')
            ->findAll();
    }

    /**
     * Get student's submission for an assignment
     */
    public function getByStudent($assignmentId, $userId)
    {
        return $this->where('assignment_id', $assignmentId)
            ->where('user_id', $userId)
            ->first();
    }

    /**
     * Submit or update assignment
     */
    public function submitAssignment($data)
    {
        // Check if already submitted
        $existing = $this->where('assignment_id', $data['assignment_id'])
            ->where('user_id', $data['user_id'])
            ->first();

        if ($existing) {
            // Update existing submission
            return $this->update($existing['id'], $data);
        } else {
            // New submission
            $data['submitted_at'] = date('Y-m-d H:i:s');
            return $this->insert($data);
        }
    }

    /**
     * Grade a submission
     */
    public function gradeSubmission($id, $score, $feedback = null)
    {
        return $this->update($id, [
            'score' => $score,
            'feedback' => $feedback,
            'graded_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Count submissions for an assignment
     */
    public function countByAssignment($assignmentId)
    {
        return $this->where('assignment_id', $assignmentId)->countAllResults();
    }
}
