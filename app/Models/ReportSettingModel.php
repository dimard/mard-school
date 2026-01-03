<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportSettingModel extends Model
{
    protected $table = 'report_settings';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'header_content',
        'footer_content',
        'watermark_enabled'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getSettings()
    {
        $settings = $this->first();
        if (!$settings) {
            // Return defaults if not found (though migration seeds it)
            return [
                'header_content' => '<div style="text-align: center;"><h3>SCHOOL NAME</h3></div>',
                'footer_content' => '<div style="text-align: right;"><p>Principal</p></div>',
                'watermark_enabled' => 0
            ];
        }
        return $settings;
    }
}
