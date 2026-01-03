<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CbtExamModel;

class Cbt extends BaseController
{
    protected $cbtExamModel;
    protected $publicAccessModel;

    public function __construct()
    {
        $this->cbtExamModel = new CbtExamModel();
        $this->publicAccessModel = new \App\Models\PublicCbtAccessModel();
    }

    public function index()
    {
        // Join with public access to show codes in list
        $exams = $this->cbtExamModel->select('cbt_exams.*, public_cbt_access.access_code')
            ->join('public_cbt_access', 'public_cbt_access.exam_id = cbt_exams.id', 'left')
            ->findAll();

        $data = [
            'exams' => $exams
        ];
        return view('admin/cbt/index', $data);
    }

    public function create()
    {
        return view('admin/cbt/create');
    }

    public function store()
    {
        $isPublic = $this->request->getPost('is_public') ? 1 : 0;

        $data = [
            'exam_name' => $this->request->getPost('exam_name'),
            'description' => $this->request->getPost('description'),
            'start_time' => $this->request->getPost('start_time'),
            'end_time' => $this->request->getPost('end_time'),
            'duration_minutes' => $this->request->getPost('duration_minutes'),
            'passing_score' => $this->request->getPost('passing_score'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'is_public' => $isPublic,
            'created_by' => session()->get('user_id')
        ];

        // Start transaction
        $db = \Config\Database::connect();
        $db->transStart();

        if ($this->cbtExamModel->insert($data) === false) {
            return redirect()->back()->withInput()->with('errors', $this->cbtExamModel->errors());
        }

        $examId = $this->cbtExamModel->getInsertID();

        // If public exam, create access code
        if ($isPublic) {
            $accessCode = $this->request->getPost('access_code');

            // Generate if empty
            if (empty($accessCode)) {
                $accessCode = $this->publicAccessModel->generateAccessCode();
            }

            $accessData = [
                'exam_id' => $examId,
                'access_code' => $accessCode,
                'max_participants' => $this->request->getPost('max_participants') ?: null
            ];

            if ($this->publicAccessModel->insert($accessData) === false) {
                // Transaction rollback will happen automatically on error if transStatus is checked or exception thrown
                // But insert returns ID or false.
                // We should check errors.
                $db->transRollback();
                return redirect()->back()->withInput()->with('errors', $this->publicAccessModel->errors());
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Failed to create exam');
        }

        return redirect()->to(base_url('admin/cbt'))->with('message', 'Exam created successfully');
    }

    public function edit($id)
    {
        $data['exam'] = $this->cbtExamModel->getPublicExamWithAccess($id);

        if (!$data['exam']) {
            // Fallback for non-public exams or if join returns null (shouldn't happen with left join logic in model but good to be safe)
            $data['exam'] = $this->cbtExamModel->find($id);
        }

        if (!$data['exam']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Exam not found');
        }
        return view('admin/cbt/edit', $data);
    }

    public function update($id)
    {
        $isPublic = $this->request->getPost('is_public') ? 1 : 0;

        $data = [
            'exam_name' => $this->request->getPost('exam_name'),
            'description' => $this->request->getPost('description'),
            'start_time' => $this->request->getPost('start_time'),
            'end_time' => $this->request->getPost('end_time'),
            'duration_minutes' => $this->request->getPost('duration_minutes'),
            'passing_score' => $this->request->getPost('passing_score'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'is_public' => $isPublic
        ];

        $db = \Config\Database::connect();
        $db->transStart();

        if ($this->cbtExamModel->update($id, $data) === false) {
            return redirect()->back()->withInput()->with('errors', $this->cbtExamModel->errors());
        }

        // Handle Public Access settings
        $existingAccess = $this->publicAccessModel->getByExamId($id);

        if ($isPublic) {
            $accessCode = $this->request->getPost('access_code');

            // If regenerating or new
            if (empty($accessCode) && !$existingAccess) {
                $accessCode = $this->publicAccessModel->generateAccessCode();
            } elseif (empty($accessCode) && $existingAccess) {
                $accessCode = $existingAccess['access_code']; // Keep existing if not changed/provided
            }

            $accessData = [
                'access_code' => $accessCode,
                'max_participants' => $this->request->getPost('max_participants') ?: null
            ];

            if ($existingAccess) {
                $this->publicAccessModel->update($existingAccess['id'], $accessData);
            } else {
                $accessData['exam_id'] = $id;
                $this->publicAccessModel->insert($accessData);
            }
        } else {
            // If switched to not public, maybe we should delete access info? 
            // Or keep it. Let's keep it for now but it won't be used.
        }

        $db->transComplete();

        return redirect()->to(base_url('admin/cbt'))->with('message', 'Exam updated successfully');
    }

    public function delete($id)
    {
        $this->cbtExamModel->delete($id);
        return redirect()->to(base_url('admin/cbt'))->with('message', 'Exam deleted successfully');
    }

    public function toggleActive($id)
    {
        $exam = $this->cbtExamModel->find($id);
        if ($exam) {
            $newState = $exam['is_active'] ? 0 : 1;
            $this->cbtExamModel->update($id, ['is_active' => $newState]);
        }
        return redirect()->back();
    }
}
