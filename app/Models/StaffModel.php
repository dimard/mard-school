<?php

namespace App\Models;

use CodeIgniter\Model;

class StaffModel extends Model
{
    protected $table = 'staff';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'name',
        'position',
        'bio',
        'photo',
        'facebook_url',
        'twitter_url',
        'linkedin_url',
        'sort_order',
        'is_active'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|max_length[255]',
        'position' => 'required|max_length[255]',
        'bio' => 'permit_empty|max_length[500]',
        'facebook_url' => 'permit_empty|valid_url|max_length[255]',
        'twitter_url' => 'permit_empty|valid_url|max_length[255]',
        'linkedin_url' => 'permit_empty|valid_url|max_length[255]',
        'sort_order' => 'permit_empty|integer',
        'is_active' => 'permit_empty|in_list[0,1]',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Staff name is required',
            'max_length' => 'Name cannot exceed 255 characters'
        ],
        'position' => [
            'required' => 'Position is required',
            'max_length' => 'Position cannot exceed 255 characters'
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Get all active staff members, ordered by sort_order
     */
    public function getActiveStaff()
    {
        return $this->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Get staff count
     */
    public function getStaffCount($activeOnly = false)
    {
        if ($activeOnly) {
            return $this->where('is_active', 1)->countAllResults();
        }
        return $this->countAll();
    }

    /**
     * Toggle staff active status
     */
    public function toggleActive($id)
    {
        $staff = $this->find($id);
        if ($staff) {
            return $this->update($id, ['is_active' => $staff['is_active'] ? 0 : 1]);
        }
        return false;
    }
}
