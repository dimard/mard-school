<?php

namespace App\Models;

use CodeIgniter\Model;

class SubClassMemberModel extends Model
{
    protected $table = 'sub_class_members';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['sub_class_id', 'student_id', 'joined_at'];

    // No timestamps for this table, we use joined_at

    /**
     * Get all members of a sub class
     */
    public function getMembers($subClassId)
    {
        return $this->select('sub_class_members.*, users.full_name, users.nis, users.email')
            ->join('users', 'users.id = sub_class_members.student_id')
            ->where('sub_class_id', $subClassId)
            ->orderBy('users.full_name', 'ASC')
            ->findAll();
    }

    /**
     * Add a single member to sub class
     */
    public function addMember($subClassId, $studentId)
    {
        // Check if already member
        if ($this->isMember($subClassId, $studentId)) {
            return true; // Already a member
        }

        return $this->insert([
            'sub_class_id' => $subClassId,
            'student_id' => $studentId,
            'joined_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Auto-add all students from main class to sub class
     */
    public function addMembersFromClass($subClassId, $classId)
    {
        $classMemberModel = new \App\Models\ClassMemberModel();
        $students = $classMemberModel->where('class_id', $classId)->findAll();

        $added = 0;
        foreach ($students as $student) {
            if ($this->addMember($subClassId, $student['student_id'])) {
                $added++;
            }
        }

        return $added;
    }

    /**
     * Check if student is member of sub class
     */
    public function isMember($subClassId, $studentId)
    {
        return $this->where(['sub_class_id' => $subClassId, 'student_id' => $studentId])->countAllResults() > 0;
    }

    /**
     * Get all sub classes a student is member of
     */
    public function getStudentSubClasses($studentId)
    {
        return $this->select('sub_class_members.*, sub_classes.subject_name, sub_classes.class_id, classes.name as class_name')
            ->join('sub_classes', 'sub_classes.id = sub_class_members.sub_class_id')
            ->join('classes', 'classes.id = sub_classes.class_id')
            ->where('sub_class_members.student_id', $studentId)
            ->orderBy('classes.name', 'ASC')
            ->orderBy('sub_classes.subject_name', 'ASC')
            ->findAll();
    }

    /**
     * Get sub classes for a student in a specific main class
     */
    public function getSubClassesByClassAndStudent($classId, $studentId)
    {
        return $this->select('sub_classes.id, sub_classes.subject_name, sub_classes.code, sub_classes.description, users.full_name as teacher_name, sub_class_members.joined_at')
            ->join('sub_classes', 'sub_classes.id = sub_class_members.sub_class_id')
            ->join('users', 'users.id = sub_classes.teacher_id')
            ->where('sub_classes.class_id', $classId)
            ->where('sub_class_members.student_id', $studentId)
            ->orderBy('sub_classes.subject_name', 'ASC')
            ->findAll();
    }

    /**
     * Remove member from sub class
     */
    public function removeMember($subClassId, $studentId)
    {
        return $this->where(['sub_class_id' => $subClassId, 'student_id' => $studentId])->delete();
    }

    /**
     * Remove all members from sub class
     */
    public function removeAllMembers($subClassId)
    {
        return $this->where('sub_class_id', $subClassId)->delete();
    }
}
