<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\AssignmentModel;
use App\Models\AssignmentSubmissionModel;
use App\Models\ClassModel;
use App\Models\ClassMemberModel;

class Assignments extends BaseController
{
    protected $assignmentModel;
    protected $submissionModel;
    protected $classModel;
    protected $memberModel;

    public function __construct()
    {
        $this->assignmentModel = new AssignmentModel();
        $this->submissionModel = new AssignmentSubmissionModel();
        $this->classModel = new ClassModel();
        $this->memberModel = new ClassMemberModel();
    }

    /**
     * List all assignments for a class
     */
    public function index($classId)
    {
        // Verify student is member
        $isMember = $this->memberModel
            ->where('class_id', $classId)
            ->where('student_id', session()->get('user_id'))
            ->first();

        if (!$isMember) {
            return redirect()->to('siswa/classes')->with('error', 'You are not a member of this class');
        }

        $class = $this->classModel->find($classId);
        $assignments = $this->assignmentModel->getByClass($classId);

        // Add submission status for each assignment
        foreach ($assignments as &$assignment) {
            $submission = $this->submissionModel->getByStudent($assignment['id'], session()->get('user_id'));
            $assignment['submitted'] = $submission ? true : false;
            $assignment['submission'] = $submission;
            $assignment['is_late'] = strtotime($assignment['deadline']) < time();
        }

        $data = [
            'class' => $class,
            'assignments' => $assignments
        ];

        return view('siswa/assignments/index', $data);
    }

    /**
     * View assignment detail
     */
    public function view($assignmentId)
    {
        $assignment = $this->assignmentModel->getWithAuthor($assignmentId);

        if (!$assignment) {
            return redirect()->to('siswa/classes')->with('error', 'Assignment not found');
        }

        // Verify student is member
        $isMember = $this->memberModel
            ->where('class_id', $assignment['class_id'])
            ->where('student_id', session()->get('user_id'))
            ->first();

        if (!$isMember) {
            return redirect()->to('siswa/classes')->with('error', 'Access denied');
        }

        $class = $this->classModel->find($assignment['class_id']);
        $submission = $this->submissionModel->getByStudent($assignmentId, session()->get('user_id'));

        $data = [
            'assignment' => $assignment,
            'class' => $class,
            'submission' => $submission,
            'is_late' => strtotime($assignment['deadline']) < time()
        ];

        return view('siswa/assignments/view', $data);
    }

    /**
     * Submit assignment
     */
    public function submit($assignmentId)
    {
        $assignment = $this->assignmentModel->find($assignmentId);

        if (!$assignment) {
            return redirect()->to('siswa/classes')->with('error', 'Assignment not found');
        }

        // Verify student is member
        $isMember = $this->memberModel
            ->where('class_id', $assignment['class_id'])
            ->where('student_id', session()->get('user_id'))
            ->first();

        if (!$isMember) {
            return redirect()->to('siswa/classes')->with('error', 'Access denied');
        }

        $submissionText = $this->request->getPost('submission_text');
        $file = $this->request->getFile('file');

        if (empty($submissionText) && (!$file || !$file->isValid())) {
            return redirect()->back()->with('error', 'Please provide submission text or upload a file');
        }

        $data = [
            'assignment_id' => $assignmentId,
            'user_id' => session()->get('user_id'),
            'submission_text' => $submissionText
        ];

        // Handle file upload
        if ($file && $file->isValid()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/assignments', $newName);
            $data['file_path'] = 'uploads/assignments/' . $newName;
        }

        $this->submissionModel->submitAssignment($data);

        return redirect()->to('siswa/assignments/view/' . $assignmentId)
            ->with('message', 'Assignment submitted successfully');
    }
}
