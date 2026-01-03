<?php

namespace App\Models;

use CodeIgniter\Model;

class CbtAnswerModel extends Model
{
    protected $table = 'cbt_answers';
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
        'user_answer' => 'in_list[A,B,C,D,E]'
    ];

    /**
     * Save or update answer
     */
    public function saveAnswer($resultId, $questionId, $userAnswer)
    {
        // Check if answer is correct
        $questionModel = new \App\Models\CbtQuestionModel();
        $question = $questionModel->find($questionId);

        if (!$question) {
            return false;
        }

        $isCorrect = ($question['correct_answer'] === strtoupper($userAnswer));

        // Check if answer already exists
        $existing = $this->where('result_id', $resultId)
            ->where('question_id', $questionId)
            ->first();

        $data = [
            'user_answer' => strtoupper($userAnswer),
            'is_correct' => $isCorrect,
            'answered_at' => date('Y-m-d H:i:s')
        ];

        if ($existing) {
            return $this->update($existing['id'], $data);
        } else {
            $data['result_id'] = $resultId;
            $data['question_id'] = $questionId;
            return $this->insert($data);
        }
    }

    /**
     * Get answers by result ID
     */
    public function getAnswersByResult($resultId)
    {
        return $this->select('cbt_answers.*, cbt_questions.question_text, cbt_questions.correct_answer')
            ->join('cbt_questions', 'cbt_questions.id = cbt_answers.question_id')
            ->where('cbt_answers.result_id', $resultId)
            ->findAll();
    }
}
