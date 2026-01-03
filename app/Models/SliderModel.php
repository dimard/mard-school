<?php

namespace App\Models;

use CodeIgniter\Model;

class SliderModel extends Model
{
    protected $table = 'sliders';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'title',
        'description',
        'image_url',
        'link',
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
        'image_url' => 'required',
        'sort_order' => 'integer'
    ];

    /**
     * Get active sliders ordered by sort_order
     */
    public function getActiveSliders()
    {
        return $this->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }

    /**
     * Get next sort order
     */
    public function getNextSortOrder()
    {
        $last = $this->orderBy('sort_order', 'DESC')->first();
        return $last ? ($last['sort_order'] + 1) : 1;
    }
}
