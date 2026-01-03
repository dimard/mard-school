-- Create PPDB Settings Table
CREATE TABLE IF NOT EXISTS `ppdb_settings` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert default settings
INSERT INTO `ppdb_settings` (`setting_key`, `setting_value`, `created_at`) VALUES
('ppdb_status', 'closed', NOW()),
('ppdb_year', '2024/2025', NOW()),
('ppdb_quota', '100', NOW()),
('ppdb_start_date', CURDATE(), NOW()),
('ppdb_end_date', DATE_ADD(CURDATE(), INTERVAL 30 DAY), NOW()),
('ppdb_flow_steps', '[{"step":1,"title":"Pendaftaran Online","description":"Isi formulir pendaftaran online dengan lengkap"},{"step":2,"title":"Verifikasi Berkas","description":"Tim admin memverifikasi kelengkapan berkas"},{"step":3,"title":"Tes Masuk","description":"Calon siswa mengikuti tes masuk (jika diperlukan)"},{"step":4,"title":"Pengumuman","description":"Pengumuman hasil seleksi"},{"step":5,"title":"Daftar Ulang","description":"Siswa yang diterima melakukan daftar ulang"}]', NOW()),
('ppdb_requirements', '["Fotocopy Ijazah/SKHUN yang telah dilegalisir","Fotocopy Kartu Keluarga (KK)","Fotocopy Akta Kelahiran","Pas foto berwarna ukuran 3x4 (3 lembar)","Fotocopy KTP Orang Tua/Wali","Surat Keterangan Sehat dari Dokter"]', NOW())
ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);

-- Create PPDB Registrations Table
CREATE TABLE IF NOT EXISTS `ppdb_registrations` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `registration_number` varchar(50) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `birth_place` varchar(100) NOT NULL,
  `birth_date` date NOT NULL,
  `gender` enum('L','P') NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `parent_name` varchar(255) NOT NULL,
  `parent_phone` varchar(20) NOT NULL,
  `parent_occupation` varchar(100) DEFAULT NULL,
  `previous_school` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `document_ijazah` varchar(255) DEFAULT NULL,
  `document_kk` varchar(255) DEFAULT NULL,
  `document_akta` varchar(255) DEFAULT NULL,
  `status` enum('pending','verified','approved','rejected') NOT NULL DEFAULT 'pending',
  `admin_notes` text DEFAULT NULL,
  `verified_by` int(11) UNSIGNED DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `registration_number` (`registration_number`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
