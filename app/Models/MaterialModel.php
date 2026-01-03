<?php

namespace App\Models;

use CodeIgniter\Model;

class MaterialModel extends Model
{
    protected $table = 'materials';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'class_id',
        'sub_class_id',
        'title',
        'description',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'category',
        'uploaded_by',
        'download_count',
        'is_active'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'title' => 'required|min_length[3]',
        'file_name' => 'required',
        'file_path' => 'required',
        'uploaded_by' => 'required|integer'
    ];

    /**
     * Get active materials
     */
    public function getActiveMaterials($category = null)
    {
        $builder = $this->select('materials.*, users.full_name as uploader_name')
            ->join('users', 'users.id = materials.uploaded_by')
            ->where('materials.is_active', 1);

        if ($category) {
            $builder->where('materials.category', $category);
        }

        return $builder->orderBy('materials.created_at', 'DESC')->findAll();
    }

    /**
     * Get material with uploader info
     */
    public function getMaterialWithUploader($id)
    {
        return $this->select('materials.*, users.full_name as uploader_name')
            ->join('users', 'users.id = materials.uploaded_by')
            ->where('materials.id', $id)
            ->first();
    }

    /**
     * Increment download counter
     */
    public function incrementDownload($id)
    {
        return $this->set('download_count', 'download_count + 1', false)
            ->where('id', $id)
            ->update();
    }

    /**
     * Get unique categories
     */
    public function getCategories()
    {
        return $this->distinct()
            ->select('category')
            ->where('is_active', 1)
            ->orderBy('category', 'ASC')
            ->findAll();
    }

    /**
     * Format file size
     */
    public function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    /**
     * Get materials for a specific sub class
     */
    public function getBySubClass($subClassId)
    {
        return $this->select('materials.*, users.full_name as uploader_name')
            ->join('users', 'users.id = materials.uploaded_by')
            ->where('materials.sub_class_id', $subClassId)
            ->where('materials.is_active', 1)
            ->orderBy('materials.created_at', 'DESC')
            ->findAll();
    }
}
