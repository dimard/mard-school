<?php

namespace App\Controllers;

use App\Models\CbtExamModel;
use App\Models\CbtQuestionModel;
use App\Models\PublicCbtAccessModel;
use App\Models\PublicCbtParticipantModel;
use App\Models\PublicCbtResultModel;
use App\Models\PublicCbtAnswerModel;

class PublicExam extends BaseController
{
    protected $examModel;
    protected $questionModel;
    protected $accessModel;
    protected $participantModel;
    protected $resultModel;
    protected $answerModel;

    public function __construct()
    {
        $this->examModel = new CbtExamModel();
        $this->questionModel = new CbtQuestionModel();
        $this->accessModel = new PublicCbtAccessModel();
        $this->participantModel = new PublicCbtParticipantModel();
        $this->resultModel = new PublicCbtResultModel();
        $this->answerModel = new PublicCbtAnswerModel();
    }

    /**
     * List all active public exams
     */
    public function index()
    {
        $exams = $this->examModel->getActivePublicExams();

        // Get participant count for each exam
        foreach ($exams as &$exam) {
            $exam['participant_count'] = $this->participantModel->countParticipants($exam['id']);
        }

        $data = [
            'exams' => $exams,
            'settings' => $this->getSettings(),
            'nav_links' => $this->getNavLinks()
        ];

        return view('public_exam/index', $data);
    }

    /**
     * Show exam detail and access code input
     */
    public function detail($examId)
    {
        // Check if exam is available
        if (!$this->examModel->isPublicExamAvailable($examId)) {
            return redirect()->to(base_url('/ujian'))->with('error', 'Ujian tidak tersedia');
        }

        $exam = $this->examModel->getPublicExamWithAccess($examId);

        if (!$exam) {
            return redirect()->to(base_url('/ujian'))->with('error', 'Ujian tidak ditemukan');
        }

        $data = [
            'exam' => $exam,
            'settings' => $this->getSettings(),
            'nav_links' => $this->getNavLinks()
        ];

        return view('public_exam/access_code', $data);
    }

    /**
     * Validate access code
     */
    public function validateAccess()
    {
        $examId = $this->request->getPost('exam_id');
        $accessCode = $this->request->getPost('access_code');

        // Validate access code
        $isValid = $this->accessModel->validateAccessCode($examId, $accessCode);

        if (!$isValid) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Kode akses tidak valid atau kapasitas peserta sudah penuh');
        }

        // Check capacity
        if (!$this->accessModel->checkCapacity($examId)) {
            return redirect()->back()
                ->with('error', 'Maaf, ujian ini sudah mencapai kapasitas maksimal peserta');
        }

        // Store exam_id in session for registration
        session()->set('temp_exam_id', $examId);
        session()->set('temp_access_code', $accessCode);

        return redirect()->to(base_url('/ujian/daftar/' . $examId));
    }

    /**
     * Show student registration form
     */
    public function register($examId)
    {
        // Verify session has valid access code
        if (session()->get('temp_exam_id') != $examId) {
            return redirect()->to(base_url('/ujian/detail/' . $examId))
                ->with('error', 'Silakan masukkan kode akses terlebih dahulu');
        }

        $exam = $this->examModel->find($examId);

        if (!$exam) {
            return redirect()->to(base_url('/ujian'))->with('error', 'Ujian tidak ditemukan');
        }

        $data = [
            'exam' => $exam,
            'settings' => $this->getSettings(),
            'nav_links' => $this->getNavLinks()
        ];

        return view('public_exam/register', $data);
    }

    /**
     * Store participant data and start exam
     */
    public function storeParticipant()
    {
        $examId = $this->request->getPost('exam_id');

        // Verify session
        if (session()->get('temp_exam_id') != $examId) {
            return redirect()->to(base_url('/ujian/detail/' . $examId))
                ->with('error', 'Sesi tidak valid. Silakan masukkan kode akses kembali');
        }

        // Validate input
        $rules = [
            'full_name' => 'required|min_length[3]|max_length[200]',
            'class_name' => 'required|max_length[100]',
            'student_number' => 'required|max_length[50]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fullName = $this->request->getPost('full_name');

        // Check if already participated
        if ($this->participantModel->checkDuplicate($examId, $fullName)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Anda sudah pernah mengikuti ujian ini');
        }

        // Prepare additional data
        $additionalData = [
            'student_number' => $this->request->getPost('student_number')
        ];

        // Create participant
        $participantData = [
            'exam_id' => $examId,
            'full_name' => $fullName,
            'class_name' => $this->request->getPost('class_name'),
            'email' => null,
            'phone' => null,
            'school_name' => null,
            'additional_data' => json_encode($additionalData)
        ];

        $participantId = $this->participantModel->createParticipant($participantData);

        if (!$participantId) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mendaftar. Silakan coba lagi');
        }

        // Increment participant count
        $this->accessModel->incrementParticipants($examId);

        // Create result record
        $resultData = [
            'exam_id' => $examId,
            'participant_id' => $participantId,
            'start_time' => date('Y-m-d H:i:s'),
            'status' => 'in_progress'
        ];

        $resultId = $this->resultModel->insert($resultData);

        if (!$resultId) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memulai ujian. Silakan coba lagi');
        }

        // Clear temp session
        session()->remove('temp_exam_id');
        session()->remove('temp_access_code');

        // Redirect to exam
        return redirect()->to(base_url('/ujian/mulai/' . $resultId));
    }

    /**
     * Show exam questions (active exam session)
     */
    public function exam($resultId)
    {
        $result = $this->resultModel->find($resultId);

        if (!$result || $result['status'] != 'in_progress') {
            return redirect()->to(base_url('/ujian'))->with('error', 'Sesi ujian tidak valid');
        }

        $exam = $this->examModel->find($result['exam_id']);
        $questions = $this->questionModel->getQuestionsByExam($exam['id'], false);

        // Calculate end time
        $startTime = strtotime($result['start_time']);
        $durationSeconds = $exam['duration_minutes'] * 60;
        $endTime = date('Y-m-d H:i:s', $startTime + $durationSeconds);

        // Check if time expired
        if (strtotime($endTime) < time()) {
            // Auto-submit if expired
            $this->resultModel->calculateScore($resultId);
            return redirect()->to(base_url('/ujian/hasil/' . $resultId))
                ->with('warning', 'Waktu ujian telah habis. Ujian otomatis disubmit');
        }

        $data = [
            'exam' => $exam,
            'questions' => $questions,
            'resultId' => $resultId,
            'endTime' => $endTime,
            'settings' => $this->getSettings()
        ];

        return view('public_exam/exam', $data);
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
        $result = $this->resultModel->find($resultId);

        if (!$result || $result['status'] != 'in_progress') {
            return redirect()->to(base_url('/ujian'))
                ->with('error', 'Sesi ujian tidak valid');
        }

        // Calculate score
        $this->resultModel->calculateScore($resultId);

        return redirect()->to(base_url('/ujian/hasil/' . $resultId))
            ->with('success', 'Ujian berhasil disubmit');
    }

    /**
     * Show exam results
     */
    public function result($resultId)
    {
        $result = $this->resultModel->getResultById($resultId);

        if (!$result) {
            return redirect()->to(base_url('/ujian'))->with('error', 'Hasil tidak ditemukan');
        }

        // Get answers
        $answers = $this->answerModel->getAnswersByResult($resultId);

        $data = [
            'result' => $result,
            'answers' => $answers,
            'passed' => $result['score'] >= $result['passing_score'],
            'settings' => $this->getSettings(),
            'nav_links' => $this->getNavLinks()
        ];

        return view('public_exam/result', $data);
    }

    /**
     * Get site settings
     */
    private function getSettings()
    {
        $settingModel = new \App\Models\SettingModel();
        return $settingModel->getAllSettings();
    }

    /**
     * Get navigation links
     */
    private function getNavLinks()
    {
        $navLinkModel = new \App\Models\NavigationLinkModel();
        return $navLinkModel->getActiveLinks();
    }
}
