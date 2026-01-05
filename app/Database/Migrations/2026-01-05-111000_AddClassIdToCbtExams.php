<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddClassIdToCbtExams extends Migration
{
    public function up()
    {
        $fields = [
            'class_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'id'
            ],
        ];

        // Check if column exists before adding
        if (!$this->db->getFieldData('cbt_exams', 'class_id')) {
            $this->forge->addColumn('cbt_exams', $fields);

            // Add Foreign Key (optional, can skip if simple structure preferred)
            // $this->forge->addForeignKey('class_id', 'classes', 'id', 'CASCADE', 'CASCADE');
            // $this->forge->processIndexes('cbt_exams');

            // Manual query for FK to be safe with existing data
            $this->db->query('ALTER TABLE cbt_exams ADD CONSTRAINT fk_exam_class FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE ON UPDATE CASCADE');
        }
    }

    public function down()
    {
        if ($this->db->getFieldData('cbt_exams', 'class_id')) {
            $this->forge->dropForeignKey('cbt_exams', 'fk_exam_class');
            $this->forge->dropColumn('cbt_exams', 'class_id');
        }
    }
}
