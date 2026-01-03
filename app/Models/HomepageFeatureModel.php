<?php

namespace App\Models;

use CodeIgniter\Model;

class HomepageFeatureModel extends Model
{
    protected $table = 'homepage_features';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'icon_class',
        'title',
        'description',
        'sort_order',
        'is_active'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get all active features ordered by sort_order
     */
    public function getActiveFeatures()
    {
        return $this->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }

    /**
     * Get all features (for admin management)
     */
    public function getAllFeatures()
    {
        return $this->orderBy('sort_order', 'ASC')->findAll();
    }
}
