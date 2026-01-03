<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAttendanceTables extends Migration
{
    public function up()
    {
        // Drop tables if they exist to ensure fresh schema
        $this->forge->dropTable('class_attendance', true);
        $this->forge->dropTable('class_schedules', true);

        // Table: class_schedules
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
            'day_of_week' => [
                'type' => 'TINYINT', // 1=Monday, 7=Sunday
                'constraint' => 1,
            ],
            'start_time' => [
                'type' => 'TIME',
            ],
            'end_time' => [
                'type' => 'TIME',
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
        $this->forge->createTable('class_schedules', true);

        // Table: class_attendance
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
            'schedule_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'date' => [
                'type' => 'DATE',
            ],
            'check_in_time' => [
                'type' => 'DATETIME',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['present', 'late'],
                'default' => 'present',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['class_id', 'user_id', 'date']);
        $this->forge->createTable('class_attendance', true);
    }

    public function down()
    {
        $this->forge->dropTable('class_attendance', true);
        $this->forge->dropTable('class_schedules', true);
    }
}
