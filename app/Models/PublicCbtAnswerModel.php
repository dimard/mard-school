<?php

namespace App\Models;

use CodeIgniter\Model;

class PublicCbtAnswerModel extends Model
{
    protected $table = 'public_cbt_answers';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'result_id',
        'question_id',
        'user_answer',
        'is_correct',
        'answered_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'result_id' => 'required|integer',
        'question_id' => 'required|integer',
        'user_answer' => 'permit_empty|in_list[A,B,C,D,E]'
    ];

    /**
     * Save or update answer
     */
    public function saveAnswer($resultId, $questionId, $answer)
    {
        // Get the question to check correct answer
        $questionModel = new CbtQuestionModel();
        $question = $questionModel->find($questionId);

        if (!$question) {
            return false;
        }

        $isCorrect = ($answer == $question['correct_answer']) ? 1 : 0;

        // Check if answer already exists
        $existing = $this->where('result_id', $resultId)
            ->where('question_id', $questionId)
            ->first();

        $data = [
            'result_id' => $resultId,
            'question_id' => $questionId,
            'user_answer' => $answer,
            'is_correct' => $isCorrect,
            'answered_at' => date('Y-m-d H:i:s')
        ];

        if ($existing) {
            // Update existing answer
            return $this->update($existing['id'], $data);
        } else {
            // Insert new answer
            return $this->insert($data);
        }
    }

    /**
     * Get all answers for a result
     */
    public function getAnswersByResult($resultId)
    {
        return $this->select('public_cbt_answers.*, 
                             cbt_questions.question_text,
                             cbt_questions.option_a,
                             cbt_questions.option_b,
                             cbt_questions.option_c,
                             cbt_questions.option_d,
                             cbt_questions.option_e,
                             cbt_questions.correct_answer,
                             cbt_questions.points')
            ->join(
                'cbt_questions',
                'cbt_questions.id = public_cbt_answers.question_id'
            )
            ->where('public_cbt_answers.result_id', $resultId)
            ->orderBy('cbt_questions.question_order', 'ASC')
            ->findAll();
    }

    /**
     * Get answer for specific question in result
     */
    public function getAnswer($resultId, $questionId)
    {
        return $this->where('result_id', $resultId)
            ->where('question_id', $questionId)
            ->first();
    }

    /**
     * Count answered questions
     */
    public function countAnswered($resultId)
    {
        return $this->where('result_id', $resultId)
            ->where('user_answer IS NOT NULL')
            ->countAllResults();
    }

    /**
     * Get unanswered questions for result
     */
    public function getUnanswered($resultId)
    {
        $result = (new PublicCbtResultModel())->find($resultId);
        if (!$result) {
            return [];
        }

        $questionModel = new CbtQuestionModel();
        $allQuestions = $questionModel->where('exam_id', $result['exam_id'])
            ->findAll();

        $answered = $this->where('result_id', $resultId)
            ->where('user_answer IS NOT NULL')
            ->findAll();

        $answeredIds = array_column($answered, 'question_id');

        $unanswered = [];
        foreach ($allQuestions as $question) {
            if (!in_array($question['id'], $answeredIds)) {
                $unanswered[] = $question;
            }
        }

        return $unanswered;
    }

    /**
     * Delete all answers for a result
     */
    public function deleteByResult($resultId)
    {
        return $this->where('result_id', $resultId)->delete();
    }
}
