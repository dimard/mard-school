<?php

namespace App\Models;

use CodeIgniter\Model;

class HomepageSectionModel extends Model
{
    protected $table = 'homepage_sections';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'section_key',
        'title',
        'subtitle',
        'content',
        'image_path',
        'button_text',
        'button_url',
        'extra_data',
        'is_active'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get section by key
     */
    public function getSectionByKey($key)
    {
        $section = $this->where('section_key', $key)->first();

        // Decode JSON extra_data if exists
        if ($section && !empty($section['extra_data'])) {
            $section['extra_data'] = json_decode($section['extra_data'], true);
        }

        return $section;
    }

    /**
     * Update or create section
     */
    public function updateSection($key, $data)
    {
        // Encode extra_data to JSON if array
        if (isset($data['extra_data']) && is_array($data['extra_data'])) {
            $data['extra_data'] = json_encode($data['extra_data']);
        }

        $existing = $this->where('section_key', $key)->first();

        if ($existing) {
            return $this->update($existing['id'], $data);
        } else {
            $data['section_key'] = $key;
            return $this->insert($data);
        }
    }

    /**
     * Get all active sections
     */
    public function getActiveSections()
    {
        return $this->where('is_active', 1)->findAll();
    }
}
