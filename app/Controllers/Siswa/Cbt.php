<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\CbtExamModel;
use App\Models\CbtQuestionModel;
use App\Models\CbtResultModel;
use App\Models\CbtAnswerModel;

class Cbt extends BaseController
{
    protected $examModel;
    protected $questionModel;
    protected $resultModel;
    protected $answerModel;

    public function __construct()
    {
        $this->examModel = new CbtExamModel();
        $this->questionModel = new CbtQuestionModel();
        $this->resultModel = new CbtResultModel();
        $this->answerModel = new CbtAnswerModel();
    }

    /**
     * List available exams
     */
    public function index()
    {
        $userId = session()->get('user_id');

        // Get student's classes
        $classMemberModel = new \App\Models\ClassMemberModel();
        $memberships = $classMemberModel->where('student_id', $userId)->findAll();
        $classIds = array_column($memberships, 'class_id');

        $data = [
            'activeExams' => $this->examModel->getActiveExams($classIds),
            'completedExams' => $this->resultModel->getStudentHistory($userId)
        ];

        return view('siswa/cbt/index', $data);
    }

    /**
     * Start an exam
     */
    public function start($examId)
    {
        $userId = session()->get('user_id');

        // Check if exam is active
        $exam = $this->examModel->find($examId);
        if (!$exam || !$exam['is_active']) {
            return redirect()->to('/siswa/cbt')->with('error', 'Ujian tidak tersedia');
        }

        // Verify membership in exam's class (Skip if global/class_id is null)
        if (!empty($exam['class_id'])) {
            $classMemberModel = new \App\Models\ClassMemberModel();
            $isMember = $classMemberModel->where('class_id', $exam['class_id'])
                ->where('student_id', $userId)
                ->first();

            if (!$isMember) {
                return redirect()->to('/siswa/cbt')->with('error', 'Anda bukan anggota kelas ujian ini');
            }
        }

        // Check if already completed (cannot retake)
        $completedResult = $this->resultModel->getResultByExamAndUser($examId, $userId);
        if ($completedResult) {
            return redirect()->to('/siswa/cbt')->with('error', 'Anda sudah mengerjakan ujian ini');
        }

        // Check if already in progress (resume existing)
        $inProgressResult = $this->resultModel->getInProgressResult($examId, $userId);
        if ($inProgressResult) {
            $resultId = $inProgressResult['id'];
        } else {
            // Create new result record
            $resultData = [
                'exam_id' => $examId,
                'user_id' => $userId,
                'start_time' => date('Y-m-d H:i:s'),
                'status' => 'in_progress'
            ];

            $resultId = $this->resultModel->insert($resultData);

            if (!$resultId) {
                $errors = $this->resultModel->errors();
                $errorMsg = 'Gagal memulai ujian.';
                if ($errors) {
                    $errorMsg .= ' Error: ' . implode(', ', $errors);
                }
                log_message('error', 'Failed to create exam result for user ' . $userId . ' and exam ' . $examId . ': ' . print_r($errors, true));
                return redirect()->to('/siswa/cbt')->with('error', $errorMsg);
            }
        }

        // Get questions
        $questions = $this->questionModel->getQuestionsByExam($examId, false);

        if (!$questions || count($questions) == 0) {
            log_message('error', 'No questions found for exam ' . $examId);
            return redirect()->to('/siswa/cbt')->with('error', 'Tidak ada soal untuk ujian ini');
        }

        $data = [
            'exam' => $exam,
            'questions' => $questions,
            'resultId' => $resultId,
            'endTime' => date('Y-m-d H:i:s', strtotime('+' . $exam['duration_minutes'] . ' minutes'))
        ];

        return view('siswa/cbt/exam', $data);
    }

    /**
     * Save answer (AJAX)
     */
    public function saveAnswer()
    {
        $resultId = $this->request->getPost('result_id');
        $questionId = $this->request->getPost('question_id');
        $answer = $this->request->getPost('answer');

        $saved = $this->answerModel->saveAnswer($resultId, $questionId, $answer);

        return $this->response->setJSON([
            'success' => $saved,
            'message' => $saved ? 'Jawaban tersimpan' : 'Gagal menyimpan jawaban'
        ]);
    }

    /**
     * Submit exam
     */
    public function submit($resultId)
    {
        // Calculate score
        $this->resultModel->calculateScore($resultId);

        return redirect()->to('/siswa/cbt/result/' . $resultId)->with('success', 'Ujian selesai');
    }

    /**
     * View result
     */
    public function result($resultId)
    {
        $userId = session()->get('user_id');

        $result = $this->resultModel->find($resultId);

        // Verify ownership
        if (!$result || $result['user_id'] != $userId) {
            return redirect()->to('/siswa/cbt')->with('error', 'Hasil ujian tidak ditemukan');
        }

        $exam = $this->examModel->find($result['exam_id']);
        $answers = $this->answerModel->getAnswersByResult($resultId);

        $data = [
            'result' => $result,
            'exam' => $exam,
            'answers' => $answers
        ];

        return view('siswa/cbt/result', $data);
    }
}
