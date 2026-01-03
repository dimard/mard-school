<?php

namespace App\Models;

use CodeIgniter\Model;

class PPDBSettingModel extends Model
{
    protected $table = 'ppdb_settings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['setting_key', 'setting_value', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get setting value by key
     */
    public function getSetting($key, $default = null)
    {
        $setting = $this->where('setting_key', $key)->first();
        return $setting ? $setting['setting_value'] : $default;
    }

    /**
     * Set/Update setting value
     */
    public function setSetting($key, $value)
    {
        $existing = $this->where('setting_key', $key)->first();

        if ($existing) {
            return $this->update($existing['id'], [
                'setting_value' => $value,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            return $this->insert([
                'setting_key' => $key,
                'setting_value' => $value,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * Get all settings as key-value array
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
     * Check if PPDB registration is open
     */
    public function isPPDBOpen()
    {
        $status = $this->getSetting('ppdb_status');
        $startDate = $this->getSetting('ppdb_start_date');
        $endDate = $this->getSetting('ppdb_end_date');
        $today = date('Y-m-d');

        if ($status !== 'open') {
            return false;
        }

        if ($startDate && $today < $startDate) {
            return false;
        }

        if ($endDate && $today > $endDate) {
            return false;
        }

        return true;
    }

    /**
     * Get PPDB flow steps
     */
    public function getFlowSteps()
    {
        $steps = $this->getSetting('ppdb_flow_steps', '[]');
        return json_decode($steps, true) ?: [];
    }

    /**
     * Get PPDB requirements
     */
    public function getRequirements()
    {
        $requirements = $this->getSetting('ppdb_requirements', '[]');
        return json_decode($requirements, true) ?: [];
    }

    /**
     * Get registration period info
     */
    public function getRegistrationPeriod()
    {
        return [
            'start_date' => $this->getSetting('ppdb_start_date'),
            'end_date' => $this->getSetting('ppdb_end_date'),
            'year' => $this->getSetting('ppdb_year'),
            'quota' => (int) $this->getSetting('ppdb_quota', 0),
            'status' => $this->getSetting('ppdb_status'),
            'is_open' => $this->isPPDBOpen()
        ];
    }
}
