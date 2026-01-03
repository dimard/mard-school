<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSubClassIdToMaterials extends Migration
{
    public function up()
    {
        $fields = [
            'sub_class_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'class_id'
            ],
        ];

        $this->forge->addColumn('materials', $fields);
        $this->forge->addKey('sub_class_id');
    }

    public function down()
    {
        $this->forge->dropColumn('materials', 'sub_class_id');
    }
}
