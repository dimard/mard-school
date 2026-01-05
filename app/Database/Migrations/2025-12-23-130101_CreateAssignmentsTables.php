<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAssignmentsTables extends Migration
{
    public function up()
    {
        // Table: class_assignments
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'class_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'description' => [
                'type' => 'TEXT',
            ],
            'deadline' => [
                'type' => 'DATETIME',
            ],
            'max_score' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 100,
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
        $this->forge->addKey('class_id');
        $this->forge->createTable('class_assignments', true);

        // Table: assignment_submissions
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'assignment_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'file_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'submission_text' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'score' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'feedback' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'submitted_at' => [
                'type' => 'DATETIME',
            ],
            'graded_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('assignment_id');
        $this->forge->addKey('user_id');
        $this->forge->createTable('assignment_submissions', true);
    }

    public function down()
    {
        $this->forge->dropTable('assignment_submissions');
        $this->forge->dropTable('class_assignments');
    }
}
