<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\CbtQuestionModel;
use App\Models\CbtExamModel;
use App\Models\ClassModel;

class CbtQuestions extends BaseController
{
    protected $cbtQuestionModel;
    protected $cbtExamModel;
    protected $classModel;

    public function __construct()
    {
        $this->cbtQuestionModel = new CbtQuestionModel();
        $this->cbtExamModel = new CbtExamModel();
        $this->classModel = new ClassModel();
    }

    protected function checkOwnership($examId)
    {
        $teacherId = session()->get('user_id');
        $exam = $this->cbtExamModel->find($examId);

        if (!$exam)
            return false;

        $class = $this->classModel->find($exam['class_id']);
        if (!$class || $class['teacher_id'] != $teacherId)
            return false;

        return $exam;
    }

    public function index($examId)
    {
        $exam = $this->checkOwnership($examId);
        if (!$exam) {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        $data = [
            'exam' => $exam,
            'questions' => $this->cbtQuestionModel->getQuestionsByExam($examId)
        ];

        return view('guru/cbt/questions/index', $data);
    }

    public function create($examId)
    {
        $exam = $this->checkOwnership($examId);
        if (!$exam) {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        $data = [
            'exam' => $exam,
            'nextOrder' => $this->cbtQuestionModel->getNextOrder($examId)
        ];

        return view('guru/cbt/questions/create', $data);
    }

    public function store($examId)
    {
        $exam = $this->checkOwnership($examId);
        if (!$exam) {
            return redirect()->back()->with('error', 'Unauthorized access');
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

        return redirect()->to(base_url('guru/cbt/' . $examId . '/questions'))->with('message', 'Question added successfully');
    }

    public function edit($questionId)
    {
        $question = $this->cbtQuestionModel->find($questionId);
        if (!$question) {
            return redirect()->back()->with('error', 'Question not found');
        }

        $exam = $this->checkOwnership($question['exam_id']);
        if (!$exam) {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        $data = [
            'question' => $question,
            'exam' => $exam
        ];

        return view('guru/cbt/questions/edit', $data);
    }

    public function update($questionId)
    {
        $question = $this->cbtQuestionModel->find($questionId);
        if (!$question) {
            return redirect()->back()->with('error', 'Question not found');
        }

        $exam = $this->checkOwnership($question['exam_id']);
        if (!$exam) {
            return redirect()->back()->with('error', 'Unauthorized access');
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

        return redirect()->to(base_url('guru/cbt/' . $question['exam_id'] . '/questions'))->with('message', 'Question updated successfully');
    }

    public function delete($questionId)
    {
        $question = $this->cbtQuestionModel->find($questionId);
        if (!$question) {
            return redirect()->back()->with('error', 'Question not found');
        }

        $exam = $this->checkOwnership($question['exam_id']);
        if (!$exam) {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        $examId = $question['exam_id'];
        $this->cbtQuestionModel->delete($questionId);

        // Update total questions in exam
        $this->cbtExamModel->updateTotalQuestions($examId);

        return redirect()->to(base_url('guru/cbt/' . $examId . '/questions'))->with('message', 'Question deleted successfully');
    }
}
