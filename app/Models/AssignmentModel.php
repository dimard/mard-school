<?php

namespace App\Models;

use CodeIgniter\Model;

class AssignmentModel extends Model
{
    protected $table = 'class_assignments';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['class_id', 'sub_class_id', 'user_id', 'title', 'description', 'deadline', 'max_score'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get all assignments for a specific class
     */
    public function getByClass($classId)
    {
        return $this->select('class_assignments.*, users.full_name as teacher_name')
            ->join('users', 'users.id = class_assignments.user_id')
            ->where('class_id', $classId)
            ->orderBy('deadline', 'DESC')
            ->findAll();
    }

    /**
     * Get assignment with submission count
     */
    public function getWithSubmissionCount($classId)
    {
        return $this->select('class_assignments.*, users.full_name as teacher_name, COUNT(assignment_submissions.id) as submission_count')
            ->join('users', 'users.id = class_assignments.user_id')
            ->join('assignment_submissions', 'assignment_submissions.assignment_id = class_assignments.id', 'left')
            ->where('class_id', $classId)
            ->groupBy('class_assignments.id')
            ->orderBy('deadline', 'DESC')
            ->findAll();
    }

    /**
     * Get assignment with author info
     */
    public function getWithAuthor($id)
    {
        return $this->select('class_assignments.*, users.full_name as teacher_name')
            ->join('users', 'users.id = class_assignments.user_id')
            ->where('class_assignments.id', $id)
            ->first();
    }

    /**
     * Check if assignment is past deadline
     */
    public function isPastDeadline($id)
    {
        $assignment = $this->find($id);
        if (!$assignment)
            return false;

        return strtotime($assignment['deadline']) < time();
    }

    /**
     * Get all assignments for a specific sub class
     */
    public function getBySubClass($subClassId)
    {
        return $this->select('class_assignments.*, users.full_name as teacher_name')
            ->join('users', 'users.id = class_assignments.user_id')
            ->where('sub_class_id', $subClassId)
            ->orderBy('deadline', 'DESC')
            ->findAll();
    }

    /**
     * Get assignments for sub class with submission count
     */
    public function getBySubClassWithSubmissionCount($subClassId)
    {
        return $this->select('class_assignments.*, users.full_name as teacher_name, COUNT(assignment_submissions.id) as submission_count')
            ->join('users', 'users.id = class_assignments.user_id')
            ->join('assignment_submissions', 'assignment_submissions.assignment_id = class_assignments.id', 'left')
            ->where('sub_class_id', $subClassId)
            ->groupBy('class_assignments.id')
            ->orderBy('deadline', 'DESC')
            ->findAll();
    }
}
