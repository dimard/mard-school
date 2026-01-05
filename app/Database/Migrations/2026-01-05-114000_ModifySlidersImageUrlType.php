<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifySlidersImageUrlType extends Migration
{
    public function up()
    {
        // Change image_url column to TEXT/LONGTEXT to support Base64
        // In PostgreSQL 'TEXT' holds unlimited length strings.
        // In MySQL 'TEXT' is 64KB, 'LONGTEXT' is 4GB.
        // CI4 Forge 'TEXT' maps to TEXT in Postgres and MySQL.
        // To be safe for MySQL, we might explicitly want MEDIUMTEXT or LONGTEXT if using MySQL locally.
        // But for Vercel (Postgres), TEXT is sufficient.

        $fields = [
            'image_url' => [
                'type' => 'TEXT', // This is safe for Postgres (unlimited) and usually enough for optimized images on MySQL
                'null' => false,
            ],
        ];

        $this->forge->modifyColumn('sliders', $fields);
    }

    public function down()
    {
        // Revert back to VARCHAR
        $fields = [
            'image_url' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
        ];
        $this->forge->modifyColumn('sliders', $fields);
    }
}
