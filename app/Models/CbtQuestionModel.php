<?php

namespace App\Models;

use CodeIgniter\Model;

class CbtQuestionModel extends Model
{
    protected $table = 'cbt_questions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'exam_id',
        'question_text',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'option_e',
        'correct_answer',
        'points',
        'question_order'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'exam_id' => 'required|integer',
        'question_text' => 'required',
        'option_a' => 'required',
        'option_b' => 'required',
        'option_c' => 'required',
        'option_d' => 'required',
        'correct_answer' => 'required|in_list[A,B,C,D,E]',
        'points' => 'decimal'
    ];

    /**
     * Get questions by exam ID
     */
    public function getQuestionsByExam($examId, $randomize = false)
    {
        $builder = $this->where('exam_id', $examId);

        if ($randomize) {
            $builder->orderBy('RAND()');
        } else {
            $builder->orderBy('question_order', 'ASC');
        }

        return $builder->findAll();
    }

    /**
     * Get next question order for an exam
     */
    public function getNextOrder($examId)
    {
        $last = $this->where('exam_id', $examId)
            ->orderBy('question_order', 'DESC')
            ->first();
        return $last ? ($last['question_order'] + 1) : 1;
    }

    /**
     * Check if answer is correct
     */
    public function checkAnswer($questionId, $answer)
    {
        $question = $this->find($questionId);
        if (!$question) {
            return false;
        }
        return $question['correct_answer'] === strtoupper($answer);
    }
}
