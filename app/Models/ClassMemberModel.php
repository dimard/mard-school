<?php

namespace App\Models;

use CodeIgniter\Model;

class ClassMemberModel extends Model
{
    protected $table = 'class_members';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['class_id', 'student_id', 'joined_at'];

    // Helper to check if student is in class
    public function isMember($classId, $studentId)
    {
        return $this->where(['class_id' => $classId, 'student_id' => $studentId])->countAllResults() > 0;
    }

    public function getMembers($classId)
    {
        return $this->select('class_members.*, users.full_name, users.nis, users.email')
            ->join('users', 'users.id = class_members.student_id')
            ->where('class_id', $classId)
            ->orderBy('users.full_name', 'ASC')
            ->findAll();
    }

    public function getStudentsByClass($classId)
    {
        return $this->getMembers($classId);
    }
}
