<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixCbtExamsIsPublic extends Migration
{
    public function up()
    {
        // Force add is_public column if it really doesn't exist.
        // We use a raw query or try/catch around addColumn to be sure, 
        // or just rely on getFieldData but ensure it works.

        // Sometimes getFieldData fails if table schema is cached. 
        // We will try to add it.

        if (!$this->db->getFieldData('cbt_exams', 'is_public')) {
            $fields = [
                'is_public' => [
                    'type' => 'TINYINT',
                    'constraint' => 1,
                    'default' => 0,
                    'after' => 'is_active'
                ],
            ];
            $this->forge->addColumn('cbt_exams', $fields);
        }
    }

    public function down()
    {
        if ($this->db->getFieldData('cbt_exams', 'is_public')) {
            $this->forge->dropColumn('cbt_exams', 'is_public');
        }
    }
}
