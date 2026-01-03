<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePpdbRegistrationsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'registration_number' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'unique' => true,
            ],
            'full_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'nik' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'birth_place' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'birth_date' => [
                'type' => 'DATE',
            ],
            'gender' => [
                'type' => 'ENUM',
                'constraint' => ['L', 'P'],
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'address' => [
                'type' => 'TEXT',
            ],
            'parent_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'parent_phone' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'parent_occupation' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'previous_school' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'photo' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'document_ijazah' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'document_kk' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'document_akta' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'verified', 'approved', 'rejected'],
                'default' => 'pending',
            ],
            'admin_notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'verified_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'verified_at' => [
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
        $this->forge->addKey('registration_number');
        $this->forge->addKey('status');
        $this->forge->createTable('ppdb_registrations');
    }

    public function down()
    {
        $this->forge->dropTable('ppdb_registrations');
    }
}
