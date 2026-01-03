<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\AssignmentModel;
use App\Models\AssignmentSubmissionModel;
use App\Models\ClassModel;

class Assignments extends BaseController
{
    protected $assignmentModel;
    protected $submissionModel;
    protected $classModel;

    public function __construct()
    {
        $this->assignmentModel = new AssignmentModel();
        $this->submissionModel = new AssignmentSubmissionModel();
        $this->classModel = new ClassModel();
    }

    /**
     * List all assignments for a class
     */
    public function index($classId)
    {
        $class = $this->classModel->find($classId);
        if (!$class || $class['teacher_id'] != session()->get('user_id')) {
            return redirect()->to('guru/classes')->with('error', 'Access denied');
        }

        $data = [
            'class' => $class,
            'assignments' => $this->assignmentModel->getWithSubmissionCount($classId)
        ];

        return view('guru/assignments/index', $data);
    }

    /**
     * Show create assignment form
     */
    public function create($classId)
    {
        $class = $this->classModel->find($classId);
        if (!$class || $class['teacher_id'] != session()->get('user_id')) {
            return redirect()->to('guru/classes')->with('error', 'Access denied');
        }

        $data = ['class' => $class];
        return view('guru/assignments/create', $data);
    }

    /**
     * Store new assignment
     */
    public function store($classId)
    {
        $class = $this->classModel->find($classId);
        if (!$class || $class['teacher_id'] != session()->get('user_id')) {
            return redirect()->to('guru/classes')->with('error', 'Access denied');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'title' => 'required|min_length[3]|max_length[255]',
            'description' => 'required|min_length[10]',
            'deadline' => 'required|valid_date',
            'max_score' => 'required|integer|greater_than[0]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'class_id' => $classId,
            'user_id' => session()->get('user_id'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'deadline' => $this->request->getPost('deadline'),
            'max_score' => $this->request->getPost('max_score')
        ];

        $this->assignmentModel->insert($data);

        return redirect()->to('guru/classes/assignments/' . $classId)
            ->with('message', 'Assignment created successfully');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $assignment = $this->assignmentModel->find($id);

        if (!$assignment || $assignment['user_id'] != session()->get('user_id')) {
            return redirect()->to('guru/classes')->with('error', 'Access denied');
        }

        $class = $this->classModel->find($assignment['class_id']);

        $data = [
            'assignment' => $assignment,
            'class' => $class
        ];

        return view('guru/assignments/edit', $data);
    }

    /**
     * Update assignment
     */
    public function update($id)
    {
        $assignment = $this->assignmentModel->find($id);

        if (!$assignment || $assignment['user_id'] != session()->get('user_id')) {
            return redirect()->to('guru/classes')->with('error', 'Access denied');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'title' => 'required|min_length[3]|max_length[255]',
            'description' => 'required|min_length[10]',
            'deadline' => 'required|valid_date',
            'max_score' => 'required|integer|greater_than[0]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'deadline' => $this->request->getPost('deadline'),
            'max_score' => $this->request->getPost('max_score')
        ];

        $this->assignmentModel->update($id, $data);

        return redirect()->to('guru/classes/assignments/' . $assignment['class_id'])
            ->with('message', 'Assignment updated successfully');
    }

    /**
     * Delete assignment
     */
    public function delete($id)
    {
        $assignment = $this->assignmentModel->find($id);

        if (!$assignment || $assignment['user_id'] != session()->get('user_id')) {
            return redirect()->to('guru/classes')->with('error', 'Access denied');
        }

        $classId = $assignment['class_id'];

        // Delete submissions first
        $this->submissionModel->where('assignment_id', $id)->delete();

        // Delete assignment
        $this->assignmentModel->delete($id);

        return redirect()->to('guru/classes/assignments/' . $classId)
            ->with('message', 'Assignment deleted successfully');
    }

    /**
     * View submissions for an assignment
     */
    public function submissions($assignmentId)
    {
        $assignment = $this->assignmentModel->getWithAuthor($assignmentId);

        if (!$assignment || $assignment['user_id'] != session()->get('user_id')) {
            return redirect()->to('guru/classes')->with('error', 'Access denied');
        }

        $class = $this->classModel->find($assignment['class_id']);
        $submissions = $this->submissionModel->getByAssignment($assignmentId);

        $data = [
            'assignment' => $assignment,
            'class' => $class,
            'submissions' => $submissions
        ];

        return view('guru/assignments/submissions', $data);
    }

    /**
     * Grade a submission
     */
    public function grade($submissionId)
    {
        $submission = $this->submissionModel->find($submissionId);

        if (!$submission) {
            return redirect()->back()->with('error', 'Submission not found');
        }

        // Verify teacher owns the assignment
        $assignment = $this->assignmentModel->find($submission['assignment_id']);
        if ($assignment['user_id'] != session()->get('user_id')) {
            return redirect()->back()->with('error', 'Access denied');
        }

        $score = $this->request->getPost('score');
        $feedback = $this->request->getPost('feedback');

        if ($score < 0 || $score > $assignment['max_score']) {
            return redirect()->back()->with('error', 'Invalid score');
        }

        $this->submissionModel->gradeSubmission($submissionId, $score, $feedback);

        return redirect()->back()->with('message', 'Submission graded successfully');
    }
}
