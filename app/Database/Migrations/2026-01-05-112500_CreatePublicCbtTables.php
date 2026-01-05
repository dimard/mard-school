<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePublicCbtTables extends Migration
{
    public function up()
    {
        // 1. Add column is_public to cbt_exams
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

        // 2. Table: public_cbt_access
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'exam_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'access_code' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'unique' => true,
            ],
            'max_participants' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'current_participants' => [
                'type' => 'INT',
                'constraint' => 11,
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
        $this->forge->addKey('access_code');
        $this->forge->addForeignKey('exam_id', 'cbt_exams', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('public_cbt_access', true);

        // 3. Table: public_cbt_participants
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'exam_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'full_name' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'class_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => true,
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'school_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'additional_data' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
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
        $this->forge->addForeignKey('exam_id', 'cbt_exams', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('public_cbt_participants', true);

        // 4. Table: public_cbt_results
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'exam_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'participant_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'start_time' => [
                'type' => 'DATETIME',
            ],
            'end_time' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'score' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true,
            ],
            'total_correct' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'total_wrong' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            // ENUM 'in_progress', 'completed', 'timeout' converted to VARCHAR
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'in_progress',
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
        $this->forge->addForeignKey('exam_id', 'cbt_exams', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('participant_id', 'public_cbt_participants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('public_cbt_results', true);

        // 5. Table: public_cbt_answers
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'result_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'question_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            // ENUM 'A', 'B', ... converted to VARCHAR
            'user_answer' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
                'null' => true,
            ],
            'is_correct' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => true,
            ],
            'answered_at' => [
                'type' => 'DATETIME',
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
        $this->forge->addForeignKey('result_id', 'public_cbt_results', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('question_id', 'cbt_questions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('public_cbt_answers', true);
    }

    public function down()
    {
        $this->forge->dropTable('public_cbt_answers', true);
        $this->forge->dropTable('public_cbt_results', true);
        $this->forge->dropTable('public_cbt_participants', true);
        $this->forge->dropTable('public_cbt_access', true);

        if ($this->db->getFieldData('cbt_exams', 'is_public')) {
            $this->forge->dropColumn('cbt_exams', 'is_public');
        }
    }
}
