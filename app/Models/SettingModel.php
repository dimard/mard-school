<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'setting_key',
        'setting_value',
        'setting_type',
        'description'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'setting_key' => 'required|is_unique[settings.setting_key,id,{id}]',
        'setting_type' => 'required|in_list[text,image,json,html]'
    ];

    /**
     * Get setting value by key
     */
    public function getSetting($key, $default = null)
    {
        $setting = $this->where('setting_key', $key)->first();
        return $setting ? $setting['setting_value'] : $default;
    }

    /**
     * Update or create setting
     */
    public function setSetting($key, $value, $type = 'text', $description = null)
    {
        $existing = $this->where('setting_key', $key)->first();

        if ($existing) {
            return $this->update($existing['id'], [
                'setting_value' => $value,
                'setting_type' => $type,
                'description' => $description ?? $existing['description']
            ]);
        } else {
            return $this->insert([
                'setting_key' => $key,
                'setting_value' => $value,
                'setting_type' => $type,
                'description' => $description
            ]);
        }
    }

    /**
     * Get all settings as key-value pairs
     */
    public function getAllSettings()
    {
        $settings = $this->findAll();
        $result = [];
        foreach ($settings as $setting) {
            $result[$setting['setting_key']] = $setting['setting_value'];
        }
        return $result;
    }

    /**
     * Get multiple settings by keys
     * Returns associative array with keys and values
     */
    public function getMultiple($keys)
    {
        $result = [];
        foreach ($keys as $key) {
            $result[$key] = $this->getSetting($key);
        }
        return $result;
    }

    /**
     * Update or create a setting (alias for setSetting)
     */
    public function updateSetting($key, $value, $type = 'text')
    {
        return $this->setSetting($key, $value, $type);
    }
}
