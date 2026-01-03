<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEReportTables extends Migration
{
    public function up()
    {
        // Table: student_conducts
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'student_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'class_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'grade' => [
                'type' => 'VARCHAR',
                'constraint' => 5, // A, B, C, D
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'teacher_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'academic_year' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'semester' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('student_id');
        $this->forge->addKey('class_id');
        $this->forge->createTable('student_conducts');

        // Table: report_settings
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'header_content' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'footer_content' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'watermark_enabled' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('report_settings');

        // Seed default settings
        $db = \Config\Database::connect();
        $db->table('report_settings')->insert([
            'header_content' => '<div style="text-align: center;"><h3>SCHOOL NAME</h3><p>School Address, City, Country</p></div>',
            'footer_content' => '<div style="text-align: right;"><p>School Principal</p><br><br><br><p>(___________________)</p></div>',
            'watermark_enabled' => 0
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('student_conducts');
        $this->forge->dropTable('report_settings');
    }
}
