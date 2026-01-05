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
}
