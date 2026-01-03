<?php

namespace App\Models;

use CodeIgniter\Model;

class NavigationLinkModel extends Model
{
    protected $table = 'navigation_links';
    protected $primaryKey = 'id';
    protected $allowedFields = ['label', 'url', 'sort_order', 'is_active', 'target'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get all active navigation links ordered by sort_order
     */
    public function getActiveLinks()
    {
        return $this->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }

    /**
     * Get all links for admin management
     */
    public function getAllLinks()
    {
        return $this->orderBy('sort_order', 'ASC')
            ->findAll();
    }

    /**
     * Update sort order
     */
    public function updateSortOrder($id, $sortOrder)
    {
        return $this->update($id, ['sort_order' => $sortOrder]);
    }
}
