<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePpdbSettingsTable extends Migration
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
            'setting_key' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'unique' => true,
            ],
            'setting_value' => [
                'type' => 'TEXT',
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
        $this->forge->createTable('ppdb_settings', true);

        // Insert default settings
        $data = [
            [
                'setting_key' => 'ppdb_status',
                'setting_value' => 'closed',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'ppdb_year',
                'setting_value' => '2024/2025',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'ppdb_quota',
                'setting_value' => '100',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'ppdb_start_date',
                'setting_value' => date('Y-m-d'),
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'ppdb_end_date',
                'setting_value' => date('Y-m-d', strtotime('+30 days')),
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'ppdb_flow_steps',
                'setting_value' => json_encode([
                    ['step' => 1, 'title' => 'Pendaftaran Online', 'description' => 'Isi formulir pendaftaran online dengan lengkap'],
                    ['step' => 2, 'title' => 'Verifikasi Berkas', 'description' => 'Tim admin memverifikasi kelengkapan berkas'],
                    ['step' => 3, 'title' => 'Tes Masuk', 'description' => 'Calon siswa mengikuti tes masuk (jika diperlukan)'],
                    ['step' => 4, 'title' => 'Pengumuman', 'description' => 'Pengumuman hasil seleksi'],
                    ['step' => 5, 'title' => 'Daftar Ulang', 'description' => 'Siswa yang diterima melakukan daftar ulang'],
                ]),
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'ppdb_requirements',
                'setting_value' => json_encode([
                    'Fotocopy Ijazah/SKHUN yang telah dilegalisir',
                    'Fotocopy Kartu Keluarga (KK)',
                    'Fotocopy Akta Kelahiran',
                    'Pas foto berwarna ukuran 3x4 (3 lembar)',
                    'Fotocopy KTP Orang Tua/Wali',
                    'Surat Keterangan Sehat dari Dokter',
                ]),
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('ppdb_settings')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('ppdb_settings');
    }
}
