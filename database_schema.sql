-- ============================================
-- Database Schema untuk Sistem Informasi Sekolah
-- CodeIgniter 4 + MySQL
-- ============================================

-- Database Creation
CREATE DATABASE IF NOT EXISTS `school_system` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `school_system`;

-- ============================================
-- 1. TABEL USERS (Admin & Siswa)
-- ============================================
CREATE TABLE `users` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `full_name` VARCHAR(200) NOT NULL,
  `role` ENUM('admin', 'siswa', 'guru') NOT NULL DEFAULT 'siswa',
  `avatar` VARCHAR(255) DEFAULT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `address` TEXT DEFAULT NULL,
  `nis` VARCHAR(50) DEFAULT NULL COMMENT 'Nomor Induk Siswa (untuk role siswa)',
  `kelas` VARCHAR(50) DEFAULT NULL COMMENT 'Kelas siswa (contoh: X IPA 1)',
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_role` (`role`),
  INDEX `idx_nis` (`nis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 2. TABEL NEWS/ARTICLES (Berita & Artikel)
-- ============================================
CREATE TABLE `news` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `content` TEXT NOT NULL,
  `excerpt` VARCHAR(500) DEFAULT NULL COMMENT 'Ringkasan berita',
  `thumbnail` VARCHAR(255) DEFAULT NULL,
  `category` VARCHAR(100) DEFAULT 'Umum',
  `author_id` INT(11) UNSIGNED NOT NULL,
  `views` INT(11) NOT NULL DEFAULT 0,
  `is_published` TINYINT(1) NOT NULL DEFAULT 1,
  `published_at` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_slug` (`slug`),
  INDEX `idx_published` (`is_published`),
  INDEX `idx_author` (`author_id`),
  FOREIGN KEY (`author_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 3. TABEL SETTINGS (CMS - Slider, Header, Footer)
-- ============================================
CREATE TABLE `settings` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `setting_key` VARCHAR(100) NOT NULL UNIQUE,
  `setting_value` TEXT DEFAULT NULL,
  `setting_type` ENUM('text', 'image', 'json', 'html') NOT NULL DEFAULT 'text',
  `description` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 4. TABEL SLIDERS (Hero Slider Images)
-- ============================================
CREATE TABLE `sliders` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `image_url` VARCHAR(255) NOT NULL,
  `link` VARCHAR(255) DEFAULT NULL,
  `sort_order` INT(11) NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_active` (`is_active`),
  INDEX `idx_sort` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 5. TABEL CBT_EXAMS (Daftar Ujian)
-- ============================================
CREATE TABLE `cbt_exams` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `exam_name` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `duration_minutes` INT(11) NOT NULL DEFAULT 60 COMMENT 'Durasi ujian dalam menit',
  `passing_score` DECIMAL(5,2) NOT NULL DEFAULT 70.00,
  `total_questions` INT(11) NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '0=tidak aktif, 1=aktif (bisa dikerjakan)',
  `start_time` TIMESTAMP NULL DEFAULT NULL,
  `end_time` TIMESTAMP NULL DEFAULT NULL,
  `created_by` INT(11) UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_active` (`is_active`),
  FOREIGN KEY (`created_by`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 6. TABEL CBT_QUESTIONS (Bank Soal)
-- ============================================
CREATE TABLE `cbt_questions` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `exam_id` INT(11) UNSIGNED NOT NULL,
  `question_text` TEXT NOT NULL,
  `option_a` TEXT NOT NULL,
  `option_b` TEXT NOT NULL,
  `option_c` TEXT NOT NULL,
  `option_d` TEXT NOT NULL,
  `option_e` TEXT DEFAULT NULL,
  `correct_answer` ENUM('A', 'B', 'C', 'D', 'E') NOT NULL,
  `points` DECIMAL(5,2) NOT NULL DEFAULT 1.00,
  `question_order` INT(11) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_exam` (`exam_id`),
  FOREIGN KEY (`exam_id`) REFERENCES `cbt_exams`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 7. TABEL CBT_RESULTS (Hasil Ujian Siswa)
-- ============================================
CREATE TABLE `cbt_results` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `exam_id` INT(11) UNSIGNED NOT NULL,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `start_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_time` TIMESTAMP NULL DEFAULT NULL,
  `score` DECIMAL(5,2) DEFAULT NULL,
  `total_correct` INT(11) DEFAULT 0,
  `total_wrong` INT(11) DEFAULT 0,
  `status` ENUM('in_progress', 'completed', 'timeout') NOT NULL DEFAULT 'in_progress',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_exam` (`exam_id`),
  INDEX `idx_user` (`user_id`),
  INDEX `idx_status` (`status`),
  FOREIGN KEY (`exam_id`) REFERENCES `cbt_exams`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  UNIQUE KEY `unique_user_exam` (`exam_id`, `user_id`) COMMENT 'Setiap siswa hanya bisa mengerjakan 1x per ujian'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 8. TABEL CBT_ANSWERS (Jawaban Siswa)
-- ============================================
CREATE TABLE `cbt_answers` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `result_id` INT(11) UNSIGNED NOT NULL,
  `question_id` INT(11) UNSIGNED NOT NULL,
  `user_answer` ENUM('A', 'B', 'C', 'D', 'E') DEFAULT NULL,
  `is_correct` TINYINT(1) DEFAULT NULL,
  `answered_at` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_result` (`result_id`),
  INDEX `idx_question` (`question_id`),
  FOREIGN KEY (`result_id`) REFERENCES `cbt_results`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`question_id`) REFERENCES `cbt_questions`(`id`) ON DELETE CASCADE,
  UNIQUE KEY `unique_result_question` (`result_id`, `question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 9. TABEL ATTENDANCE (Presensi Online)
-- ============================================
CREATE TABLE `attendance` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `attendance_date` DATE NOT NULL,
  `check_in_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` ENUM('hadir', 'izin', 'sakit', 'alpha') NOT NULL DEFAULT 'hadir',
  `notes` TEXT DEFAULT NULL,
  `location` VARCHAR(255) DEFAULT NULL COMMENT 'Koordinat GPS atau alamat (opsional)',
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_user` (`user_id`),
  INDEX `idx_date` (`attendance_date`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  UNIQUE KEY `unique_user_date` (`user_id`, `attendance_date`) COMMENT 'Satu siswa hanya bisa presensi 1x per hari'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 10. TABEL MATERIALS (Materi Pembelajaran)
-- ============================================
CREATE TABLE `materials` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `file_name` VARCHAR(255) NOT NULL,
  `file_path` VARCHAR(255) NOT NULL,
  `file_type` VARCHAR(50) DEFAULT NULL COMMENT 'pdf, docx, pptx, dll',
  `file_size` BIGINT DEFAULT NULL COMMENT 'Ukuran file dalam bytes',
  `category` VARCHAR(100) DEFAULT 'Umum',
  `uploaded_by` INT(11) UNSIGNED NOT NULL,
  `download_count` INT(11) NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_category` (`category`),
  INDEX `idx_active` (`is_active`),
  FOREIGN KEY (`uploaded_by`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- DATA SAMPLE (Optional - untuk testing)
-- ============================================

-- Insert Admin Default
INSERT INTO `users` (`username`, `email`, `password`, `full_name`, `role`, `is_active`) VALUES
('admin', 'admin@sekolah.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin', 1);
-- Password: password (hashed dengan bcrypt)

-- Insert Siswa Sample
INSERT INTO `users` (`username`, `email`, `password`, `full_name`, `role`, `nis`, `kelas`, `is_active`) VALUES
('siswa001', 'siswa001@sekolah.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Ahmad Santoso', 'siswa', '2024001', 'X IPA 1', 1),
('siswa002', 'siswa002@sekolah.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Siti Nurhaliza', 'siswa', '2024002', 'X IPA 1', 1);

-- Insert Settings Default
INSERT INTO `settings` (`setting_key`, `setting_value`, `setting_type`, `description`) VALUES
('site_name', 'SMA Negeri 1 Indonesia', 'text', 'Nama Website'),
('site_tagline', 'Pusat Pendidikan Berkualitas', 'text', 'Tagline Website'),
('header_text', 'Selamat Datang di Portal Siswa', 'html', 'Teks Header'),
('footer_text', '&copy; 2025 SMA Negeri 1 Indonesia. All Rights Reserved.', 'html', 'Teks Footer'),
('contact_email', 'info@sekolah.com', 'text', 'Email Kontak'),
('contact_phone', '021-12345678', 'text', 'Nomor Telepon');

-- ============================================
-- 11. TABEL CLASSES (Kelas Virtual)
-- ============================================
CREATE TABLE `classes` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(10) NOT NULL UNIQUE,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `teacher_id` INT(11) UNSIGNED NOT NULL,
  `created_by` INT(11) UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`teacher_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 12. TABEL CLASS_MEMBERS (Anggota Kelas)
-- ============================================
CREATE TABLE `class_members` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `class_id` INT(11) UNSIGNED NOT NULL,
  `student_id` INT(11) UNSIGNED NOT NULL,
  `joined_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`class_id`) REFERENCES `classes`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`student_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  UNIQUE KEY `unique_member` (`class_id`, `student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 13. TABEL CLASS_ATTENDANCE (Presensi Kelas)
-- ============================================
CREATE TABLE `class_attendance` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `class_id` INT(11) UNSIGNED NOT NULL,
  `student_id` INT(11) UNSIGNED NOT NULL,
  `date` DATE NOT NULL,
  `topic` VARCHAR(255) DEFAULT NULL,
  `status` ENUM('present', 'late', 'absent', 'excused') NOT NULL DEFAULT 'present',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`class_id`) REFERENCES `classes`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`student_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- UPDATE TABLES FOR SCOPED RESOURCES
-- ============================================
-- ALTER TABLE `materials` ADD COLUMN `class_id` INT(11) UNSIGNED DEFAULT NULL;
-- ALTER TABLE `materials` ADD CONSTRAINT `fk_material_class` FOREIGN KEY (`class_id`) REFERENCES `classes`(`id`) ON DELETE CASCADE;
-- ALTER TABLE `cbt_exams` ADD COLUMN `class_id` INT(11) UNSIGNED DEFAULT NULL;
-- ALTER TABLE `cbt_exams` ADD CONSTRAINT `fk_exam_class` FOREIGN KEY (`class_id`) REFERENCES `classes`(`id`) ON DELETE CASCADE;

-- ============================================
-- END OF DATABASE SCHEMA
-- ============================================
