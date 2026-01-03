<?php

namespace App\Models;

use CodeIgniter\Model;

class SubClassModel extends Model
{
    protected $table = 'sub_classes';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['class_id', 'subject_name', 'teacher_id', 'code', 'description'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'class_id' => 'required|integer',
        'subject_name' => 'required|min_length[3]',
        'teacher_id' => 'required|integer',
        'code' => 'required|is_unique[sub_classes.code]'
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;

    /**
     * Generate unique code for sub class
     */
    public function generateCode()
    {
        do {
            $code = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
            $exists = $this->where('code', $code)->countAllResults();
        } while ($exists > 0);

        return $code;
    }

    /**
     * Get all sub classes for a specific main class
     */
    public function getByClass($classId)
    {
        return $this->select('sub_classes.*, users.full_name as teacher_name, users.email as teacher_email')
            ->join('users', 'users.id = sub_classes.teacher_id')
            ->where('class_id', $classId)
            ->orderBy('subject_name', 'ASC')
            ->findAll();
    }

    /**
     * Get sub class with teacher info
     */
    public function getWithTeacher($id)
    {
        return $this->select('sub_classes.*, users.full_name as teacher_name, users.email as teacher_email, classes.name as class_name')
            ->join('users', 'users.id = sub_classes.teacher_id')
            ->join('classes', 'classes.id = sub_classes.class_id')
            ->where('sub_classes.id', $id)
            ->first();
    }

    /**
     * Get all sub classes assigned to a teacher
     */
    public function getByTeacher($teacherId)
    {
        return $this->select('sub_classes.*, classes.name as class_name, classes.code as class_code')
            ->join('classes', 'classes.id = sub_classes.class_id')
            ->where('sub_classes.teacher_id', $teacherId)
            ->orderBy('classes.name', 'ASC')
            ->orderBy('sub_classes.subject_name', 'ASC')
            ->findAll();
    }

    /**
     * Check if a teacher is authorized to manage this sub class
     */
    public function isTeacherAuthorized($subClassId, $teacherId)
    {
        return $this->where(['id' => $subClassId, 'teacher_id' => $teacherId])->countAllResults() > 0;
    }

    /**
     * Get sub class with member count
     */
    public function getWithMemberCount($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sub_classes');

        return $builder->select('sub_classes.*, users.full_name as teacher_name, classes.name as class_name, COUNT(sub_class_members.id) as member_count')
            ->join('users', 'users.id = sub_classes.teacher_id')
            ->join('classes', 'classes.id = sub_classes.class_id')
            ->join('sub_class_members', 'sub_class_members.sub_class_id = sub_classes.id', 'left')
            ->where('sub_classes.id', $id)
            ->groupBy('sub_classes.id')
            ->get()
            ->getRowArray();
    }

    /**
     * Get sub classes by class with member count
     */
    public function getByClassWithMemberCount($classId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sub_classes');

        return $builder->select('sub_classes.*, users.full_name as teacher_name, COUNT(sub_class_members.id) as member_count')
            ->join('users', 'users.id = sub_classes.teacher_id')
            ->join('sub_class_members', 'sub_class_members.sub_class_id = sub_classes.id', 'left')
            ->where('sub_classes.class_id', $classId)
            ->groupBy('sub_classes.id')
            ->orderBy('sub_classes.subject_name', 'ASC')
            ->get()
            ->getResultArray();
    }
}
