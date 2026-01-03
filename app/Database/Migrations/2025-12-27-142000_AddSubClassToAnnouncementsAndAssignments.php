<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSubClassToAnnouncementsAndAssignments extends Migration
{
    public function up()
    {
        // Add sub_class_id and is_general to class_announcements
        $announcementFields = [
            'sub_class_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'class_id'
            ],
            'is_general' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'after' => 'sub_class_id'
            ],
        ];

        $this->forge->addColumn('class_announcements', $announcementFields);

        // Add sub_class_id to class_assignments
        $assignmentFields = [
            'sub_class_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'class_id'
            ],
        ];

        $this->forge->addColumn('class_assignments', $assignmentFields);
    }

    public function down()
    {
        $this->forge->dropColumn('class_announcements', ['sub_class_id', 'is_general']);
        $this->forge->dropColumn('class_assignments', 'sub_class_id');
    }
}
