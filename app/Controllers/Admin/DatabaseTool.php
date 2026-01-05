<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class DatabaseTool extends BaseController
{
    public function migrate()
    {
        $migrate = \Config\Services::migrations();

        try {
            $migrate->latest();
            return 'Migrations ran successfully.';
        } catch (\Throwable $e) {
            return 'Migration failed: ' . $e->getMessage();
        }
    }

    public function fix_schema()
    {
        $db = \Config\Database::connect();

        // Force Fix for 'is_public' in 'cbt_exams' query issues
        // Use raw SQL compatible with Postgres
        try {
            // Check if column exists
            $fields = $db->getFieldData('cbt_exams');
            $hasColumn = false;
            foreach ($fields as $field) {
                if ($field->name === 'is_public') {
                    $hasColumn = true;
                    break;
                }
            }

            if (!$hasColumn) {
                // Add column manually
                $db->query("ALTER TABLE cbt_exams ADD COLUMN is_public SMALLINT DEFAULT 0");
                return "Column 'is_public' added to 'cbt_exams'.";
            } else {
                return "Column 'is_public' already exists.";
            }
        } catch (\Throwable $e) {
            return "Fix failed: " . $e->getMessage();
        }
    }
}
