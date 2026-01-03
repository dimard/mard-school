<?php

namespace App\Models;

use CodeIgniter\Model;

class PublicCbtResultModel extends Model
{
    protected $table = 'public_cbt_results';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'exam_id',
        'participant_id',
        'start_time',
        'end_time',
        'score',
        'total_correct',
        'total_wrong',
        'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'exam_id' => 'required|integer',
        'participant_id' => 'required|integer',
        'status' => 'in_list[in_progress,completed,timeout]'
    ];

    /**
     * Get result by exam and participant
     */
    public function getResultByExamAndParticipant($examId, $participantId)
    {
        return $this->where('exam_id', $examId)
            ->where('participant_id', $participantId)
            ->first();
    }

    /**
     * Get in-progress result
     */
    public function getInProgressResult($examId, $participantId)
    {
        return $this->where('exam_id', $examId)
            ->where('participant_id', $participantId)
            ->where('status', 'in_progress')
            ->first();
    }

    /**
     * Get results for an exam with participant info
     */
    public function getResultsByExam($examId)
    {
        return $this->select('public_cbt_results.*, 
                             public_cbt_participants.full_name,
                             public_cbt_participants.class_name,
                             public_cbt_participants.school_name')
            ->join(
                'public_cbt_participants',
                'public_cbt_participants.id = public_cbt_results.participant_id'
            )
            ->where('public_cbt_results.exam_id', $examId)
            ->orderBy('public_cbt_results.score', 'DESC')
            ->findAll();
    }

    /**
     * Get result by ID with full details
     */
    public function getResultById($resultId)
    {
        return $this->select('public_cbt_results.*, 
                             public_cbt_participants.full_name,
                             public_cbt_participants.class_name,
                             public_cbt_participants.email,
                             public_cbt_participants.phone,
                             public_cbt_participants.school_name,
                             cbt_exams.exam_name,
                             cbt_exams.passing_score,
                             cbt_exams.duration_minutes')
            ->join(
                'public_cbt_participants',
                'public_cbt_participants.id = public_cbt_results.participant_id'
            )
            ->join(
                'cbt_exams',
                'cbt_exams.id = public_cbt_results.exam_id'
            )
            ->where('public_cbt_results.id', $resultId)
            ->first();
    }

    /**
     * Calculate and save score
     */
    public function calculateScore($resultId)
    {
        $result = $this->find($resultId);
        if (!$result) {
            return false;
        }

        $answerModel = new PublicCbtAnswerModel();
        $answers = $answerModel->where('result_id', $resultId)->findAll();

        $totalCorrect = 0;
        $totalWrong = 0;
        $totalPoints = 0;

        $questionModel = new CbtQuestionModel();

        foreach ($answers as $answer) {
            if ($answer['is_correct']) {
                $totalCorrect++;
                $question = $questionModel->find($answer['question_id']);
                $totalPoints += $question['points'] ?? 1;
            } else {
                $totalWrong++;
            }
        }

        $totalQuestions = count($answers);
        $score = $totalQuestions > 0 ? ($totalCorrect / $totalQuestions) * 100 : 0;

        return $this->update($resultId, [
            'score' => $score,
            'total_correct' => $totalCorrect,
            'total_wrong' => $totalWrong,
            'status' => 'completed',
            'end_time' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Get participant history
     */
    public function getParticipantHistory($participantId)
    {
        return $this->select('public_cbt_results.*, cbt_exams.exam_name, cbt_exams.passing_score')
            ->join('cbt_exams', 'cbt_exams.id = public_cbt_results.exam_id')
            ->where('public_cbt_results.participant_id', $participantId)
            ->orderBy('public_cbt_results.created_at', 'DESC')
            ->findAll();
    }

    /**
     * Check if participant has completed exam
     */
    public function hasCompleted($examId, $participantId)
    {
        $result = $this->where('exam_id', $examId)
            ->where('participant_id', $participantId)
            ->where('status', 'completed')
            ->first();

        return $result !== null;
    }

    /**
     * Get passing rate for exam
     */
    public function getPassingRate($examId)
    {
        $exam = (new CbtExamModel())->find($examId);
        if (!$exam) {
            return 0;
        }

        $passingScore = $exam['passing_score'];

        $total = $this->where('exam_id', $examId)
            ->where('status', 'completed')
            ->countAllResults();

        if ($total == 0) {
            return 0;
        }

        $passed = $this->where('exam_id', $examId)
            ->where('status', 'completed')
            ->where('score >=', $passingScore)
            ->countAllResults();

        return ($passed / $total) * 100;
    }
}
