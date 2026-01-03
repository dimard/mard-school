<?php

namespace App\Models;

use CodeIgniter\Model;

class PublicCbtParticipantModel extends Model
{
    protected $table = 'public_cbt_participants';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'exam_id',
        'full_name',
        'class_name',
        'email',
        'phone',
        'school_name',
        'additional_data',
        'ip_address'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'exam_id' => 'required|integer',
        'full_name' => 'required|min_length[3]|max_length[200]',
        'class_name' => 'required|max_length[100]'
    ];

    /**
     * Create new participant
     */
    public function createParticipant($data)
    {
        // Add IP address automatically
        $request = \Config\Services::request();
        $data['ip_address'] = $request->getIPAddress();

        return $this->insert($data);
    }

    /**
     * Check if participant with same name already took this exam
     */
    public function checkDuplicate($examId, $fullName)
    {
        // Check if participant exists
        $participant = $this->where('exam_id', $examId)
            ->where('full_name', $fullName)
            ->first();

        if (!$participant) {
            return false;
        }

        // Check if they have a completed result
        $resultModel = new PublicCbtResultModel();
        $result = $resultModel->where('participant_id', $participant['id'])
            ->where('status', 'completed')
            ->first();

        return $result !== null;
    }

    /**
     * Get participant by exam and name
     */
    public function getByExamAndName($examId, $fullName)
    {
        return $this->where('exam_id', $examId)
            ->where('full_name', $fullName)
            ->first();
    }

    /**
     * Get all participants for an exam
     */
    public function getParticipantsByExam($examId)
    {
        return $this->where('exam_id', $examId)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Get participants with results for an exam
     */
    public function getParticipantsWithResults($examId)
    {
        return $this->select('public_cbt_participants.*, 
                             public_cbt_results.score, 
                             public_cbt_results.total_correct,
                             public_cbt_results.total_wrong,
                             public_cbt_results.status,
                             public_cbt_results.start_time,
                             public_cbt_results.end_time')
            ->join(
                'public_cbt_results',
                'public_cbt_results.participant_id = public_cbt_participants.id',
                'left'
            )
            ->where('public_cbt_participants.exam_id', $examId)
            ->orderBy('public_cbt_results.score', 'DESC')
            ->findAll();
    }

    /**
     * Count participants for exam
     */
    public function countParticipants($examId)
    {
        return $this->where('exam_id', $examId)->countAllResults();
    }

    /**
     * Get participant statistics for exam
     */
    public function getExamStatistics($examId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('public_cbt_participants');

        $stats = $builder->select('
            COUNT(public_cbt_participants.id) as total_participants,
            AVG(public_cbt_results.score) as average_score,
            MAX(public_cbt_results.score) as highest_score,
            MIN(public_cbt_results.score) as lowest_score,
            SUM(CASE WHEN public_cbt_results.status = "completed" THEN 1 ELSE 0 END) as completed_count
        ')
            ->join(
                'public_cbt_results',
                'public_cbt_results.participant_id = public_cbt_participants.id',
                'left'
            )
            ->where('public_cbt_participants.exam_id', $examId)
            ->get()
            ->getRowArray();

        return $stats;
    }
}
