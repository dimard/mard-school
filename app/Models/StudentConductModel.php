<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentConductModel extends Model
{
    protected $table = 'student_conducts';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'student_id',
        'class_id',
        'grade',
        'description',
        'teacher_id',
        'academic_year',
        'semester'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'student_id' => 'required|integer',
        'class_id' => 'required|integer',
        'grade' => 'required|in_list[A,B,C,D]',
        'description' => 'required',
        'teacher_id' => 'required|integer'
    ];

    /**
     * Get conduct for a specific student in a class
     */
    public function getStudentConduct($studentId, $classId)
    {
        return $this->where('student_id', $studentId)
            ->where('class_id', $classId)
            ->orderBy('created_at', 'DESC')
            ->first();
    }
}
