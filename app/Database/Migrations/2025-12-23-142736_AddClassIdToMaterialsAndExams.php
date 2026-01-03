<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddClassIdToMaterialsAndExams extends Migration
{
    public function up()
    {
        // Add class_id to materials table
        $fields = [
            'class_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'id'
            ]
        ];
        $this->forge->addColumn('materials', $fields);
        $this->forge->addKey('class_id');

        // Add class_id to cbt_exams table
        $this->forge->addColumn('cbt_exams', $fields);
        $this->forge->addKey('class_id');
    }

    public function down()
    {
        // Remove class_id from materials table
        $this->forge->dropColumn('materials', 'class_id');

        // Remove class_id from cbt_exams table
        $this->forge->dropColumn('cbt_exams', 'class_id');
    }
}
