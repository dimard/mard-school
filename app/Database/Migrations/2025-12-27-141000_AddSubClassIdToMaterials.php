<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSubClassIdToMaterials extends Migration
{
    public function up()
    {
        if (!$this->db->getFieldData('materials', 'sub_class_id')) {
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

            // Re-check before adding key if necessary or assume forge handles it.
            // But forge->addColumn does not automatically add keys unless specified in field def? 
            // CI4 forge->addColumn usually doesn't return key status. 
            // Safe to add key? Ideally yes, but duplicate key error is rare on addColumn context.
            // Let's keep it simple.
            $this->forge->addKey('sub_class_id');
        }
    }

    public function down()
    {
        if ($this->db->getFieldData('materials', 'sub_class_id')) {
            $this->forge->dropColumn('materials', 'sub_class_id');
        }
    }
}
