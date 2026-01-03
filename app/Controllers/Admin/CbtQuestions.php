<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CbtQuestionModel;
use App\Models\CbtExamModel;

class CbtQuestions extends BaseController
{
    protected $cbtQuestionModel;
    protected $cbtExamModel;

    public function __construct()
    {
        $this->cbtQuestionModel = new CbtQuestionModel();
        $this->cbtExamModel = new CbtExamModel();
    }

    public function index($examId)
    {
        $exam = $this->cbtExamModel->find($examId);
        if (!$exam) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Exam not found');
        }

        $data = [
            'exam' => $exam,
            'questions' => $this->cbtQuestionModel->getQuestionsByExam($examId)
        ];

        return view('admin/cbt/questions/index', $data);
    }

    public function create($examId)
    {
        $exam = $this->cbtExamModel->find($examId);
        if (!$exam) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Exam not found');
        }

        $data = [
            'exam' => $exam,
            'nextOrder' => $this->cbtQuestionModel->getNextOrder($examId)
        ];

        return view('admin/cbt/questions/create', $data);
    }

    public function store($examId)
    {
        $exam = $this->cbtExamModel->find($examId);
        if (!$exam) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Exam not found');
        }

        $data = [
            'exam_id' => $examId,
            'question_text' => $this->request->getPost('question_text'),
            'option_a' => $this->request->getPost('option_a'),
            'option_b' => $this->request->getPost('option_b'),
            'option_c' => $this->request->getPost('option_c'),
            'option_d' => $this->request->getPost('option_d'),
            'option_e' => $this->request->getPost('option_e'),
            'correct_answer' => $this->request->getPost('correct_answer'),
            'points' => $this->request->getPost('points'),
            'question_order' => $this->request->getPost('question_order')
        ];

        if ($this->cbtQuestionModel->insert($data) === false) {
            return redirect()->back()->withInput()->with('errors', $this->cbtQuestionModel->errors());
        }

        // Update total questions in exam
        $this->cbtExamModel->updateTotalQuestions($examId);

        return redirect()->to(base_url('admin/cbt/' . $examId . '/questions'))->with('message', 'Question added successfully');
    }

    public function edit($questionId)
    {
        $question = $this->cbtQuestionModel->find($questionId);
        if (!$question) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Question not found');
        }

        $exam = $this->cbtExamModel->find($question['exam_id']);

        $data = [
            'question' => $question,
            'exam' => $exam
        ];

        return view('admin/cbt/questions/edit', $data);
    }

    public function update($questionId)
    {
        $question = $this->cbtQuestionModel->find($questionId);
        if (!$question) {
            return redirect()->back()->with('error', 'Question not found');
        }

        $data = [
            'question_text' => $this->request->getPost('question_text'),
            'option_a' => $this->request->getPost('option_a'),
            'option_b' => $this->request->getPost('option_b'),
            'option_c' => $this->request->getPost('option_c'),
            'option_d' => $this->request->getPost('option_d'),
            'option_e' => $this->request->getPost('option_e'),
            'correct_answer' => $this->request->getPost('correct_answer'),
            'points' => $this->request->getPost('points'),
            'question_order' => $this->request->getPost('question_order')
        ];

        if ($this->cbtQuestionModel->update($questionId, $data) === false) {
            return redirect()->back()->withInput()->with('errors', $this->cbtQuestionModel->errors());
        }

        return redirect()->to(base_url('admin/cbt/' . $question['exam_id'] . '/questions'))->with('message', 'Question updated successfully');
    }

    public function delete($questionId)
    {
        $question = $this->cbtQuestionModel->find($questionId);
        if ($question) {
            $examId = $question['exam_id'];
            $this->cbtQuestionModel->delete($questionId);

            // Update total questions in exam
            $this->cbtExamModel->updateTotalQuestions($examId);

            return redirect()->to(base_url('admin/cbt/' . $examId . '/questions'))->with('message', 'Question deleted successfully');
        }

        return redirect()->back()->with('error', 'Question not found');
    }
}
