<?php

namespace App\Models;

use CodeIgniter\Model;

class ClassModel extends Model
{
    protected $table = 'classes';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['code', 'name', 'description', 'teacher_id', 'created_by'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[3]',
        'code' => 'required|is_unique[classes.code]',
        'teacher_id' => 'required|integer'
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;

    public function generateCode()
    {
        do {
            $code = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
            $exists = $this->where('code', $code)->countAllResults();
        } while ($exists > 0);

        return $code;
    }
}
