<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CbtExamModel;
use App\Models\PublicCbtParticipantModel;
use App\Models\PublicCbtResultModel;

class PublicCbtReports extends BaseController
{
    protected $examModel;
    protected $participantModel;
    protected $resultModel;

    public function __construct()
    {
        $this->examModel = new CbtExamModel();
        $this->participantModel = new PublicCbtParticipantModel();
        $this->resultModel = new PublicCbtResultModel();
    }

    public function index()
    {
        $exams = $this->examModel->where('is_public', 1)->findAll();

        $reports = [];
        foreach ($exams as $exam) {
            $stats = $this->participantModel->getExamStatistics($exam['id']);
            $reports[] = array_merge($exam, $stats);
        }

        $data = [
            'reports' => $reports
        ];

        return view('admin/public_reports/index', $data);
    }

    public function examDetails($examId)
    {
        $exam = $this->examModel->find($examId);

        if (!$exam || !$exam['is_public']) {
            return redirect()->to(base_url('admin/public-exam-reports'))->with('error', 'Exam not found or not public');
        }

        $participants = $this->participantModel->getParticipantsWithResults($examId);

        $data = [
            'exam' => $exam,
            'participants' => $participants
        ];

        return view('admin/public_reports/details', $data);
    }

    public function export($examId)
    {
        $exam = $this->examModel->find($examId);
        if (!$exam) {
            return redirect()->back();
        }

        $participants = $this->participantModel->getParticipantsWithResults($examId);

        // Simple CSV Export
        $filename = 'public_exam_report_' . $examId . '_' . date('Y-m-d') . '.csv';

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        // Header
        fputcsv($output, ['Full Name', 'Class', 'Email', 'Phone', 'School', 'Score', 'Correct', 'Wrong', 'Status', 'Start Time', 'End Time']);

        foreach ($participants as $p) {
            fputcsv($output, [
                $p['full_name'],
                $p['class_name'],
                $p['email'],
                $p['phone'],
                $p['school_name'],
                $p['score'],
                $p['total_correct'],
                $p['total_wrong'],
                $p['status'],
                $p['start_time'],
                $p['end_time']
            ]);
        }

        fclose($output);
        exit;
    }
}
