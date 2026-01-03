<?php

namespace App\Models;

use CodeIgniter\Model;

class CbtResultModel extends Model
{
    protected $table = 'cbt_results';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'exam_id',
        'user_id',
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
        'user_id' => 'required|integer',
        'status' => 'in_list[in_progress,completed,timeout]'
    ];

    /**
     * Get completed result by exam and user
     * Only returns results with 'completed' status to check if exam was already taken
     */
    public function getResultByExamAndUser($examId, $userId)
    {
        return $this->where('exam_id', $examId)
            ->where('user_id', $userId)
            ->where('status', 'completed')
            ->first();
    }

    /**
     * Get in-progress result by exam and user
     * Returns result if student has already started but not completed the exam
     */
    public function getInProgressResult($examId, $userId)
    {
        return $this->where('exam_id', $examId)
            ->where('user_id', $userId)
            ->where('status', 'in_progress')
            ->first();
    }

    /**
     * Get results for an exam with user info
     */
    public function getResultsByExam($examId)
    {
        return $this->select('cbt_results.*, users.full_name, users.nis, users.kelas')
            ->join('users', 'users.id = cbt_results.user_id')
            ->where('cbt_results.exam_id', $examId)
            ->orderBy('cbt_results.score', 'DESC')
            ->findAll();
    }

    /**
     * Get student's exam history
     */
    public function getStudentHistory($userId)
    {
        return $this->select('cbt_results.*, cbt_exams.exam_name, cbt_exams.passing_score')
            ->join('cbt_exams', 'cbt_exams.id = cbt_results.exam_id')
            ->where('cbt_results.user_id', $userId)
            ->orderBy('cbt_results.created_at', 'DESC')
            ->findAll();
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

        $answerModel = new \App\Models\CbtAnswerModel();
        $answers = $answerModel->where('result_id', $resultId)->findAll();

        $totalCorrect = 0;
        $totalWrong = 0;
        $totalPoints = 0;

        $questionModel = new \App\Models\CbtQuestionModel();

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
}
