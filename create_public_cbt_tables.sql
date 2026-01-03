-- ============================================
-- Public CBT System Database Schema
-- Migration for Public Exam Feature
-- ============================================

USE `school_system`;

-- ============================================
-- 1. Add is_public column to existing cbt_exams table
-- ============================================
ALTER TABLE `cbt_exams` 
ADD COLUMN `is_public` TINYINT(1) NOT NULL DEFAULT 0 
COMMENT 'Public exam accessible without login' 
AFTER `is_active`;

-- ============================================
-- 2. Table for Public Exam Access Codes
-- ============================================
CREATE TABLE IF NOT EXISTS `public_cbt_access` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `exam_id` INT(11) UNSIGNED NOT NULL,
  `access_code` VARCHAR(50) NOT NULL UNIQUE,
  `max_participants` INT(11) DEFAULT NULL COMMENT 'NULL = unlimited participants',
  `current_participants` INT(11) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`exam_id`) REFERENCES `cbt_exams`(`id`) ON DELETE CASCADE,
  INDEX `idx_access_code` (`access_code`),
  INDEX `idx_exam` (`exam_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 3. Table for Public Exam Participants
-- ============================================
CREATE TABLE IF NOT EXISTS `public_cbt_participants` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `exam_id` INT(11) UNSIGNED NOT NULL,
  `full_name` VARCHAR(200) NOT NULL,
  `class_name` VARCHAR(100) DEFAULT NULL COMMENT 'Kelas/Grade peserta',
  `email` VARCHAR(150) DEFAULT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `school_name` VARCHAR(255) DEFAULT NULL,
  `additional_data` TEXT DEFAULT NULL COMMENT 'JSON for additional custom fields',
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`exam_id`) REFERENCES `cbt_exams`(`id`) ON DELETE CASCADE,
  INDEX `idx_exam` (`exam_id`),
  INDEX `idx_full_name` (`full_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 4. Table for Public Exam Results
-- ============================================
CREATE TABLE IF NOT EXISTS `public_cbt_results` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `exam_id` INT(11) UNSIGNED NOT NULL,
  `participant_id` INT(11) UNSIGNED NOT NULL,
  `start_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_time` TIMESTAMP NULL DEFAULT NULL,
  `score` DECIMAL(5,2) DEFAULT NULL,
  `total_correct` INT(11) DEFAULT 0,
  `total_wrong` INT(11) DEFAULT 0,
  `status` ENUM('in_progress', 'completed', 'timeout') NOT NULL DEFAULT 'in_progress',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`exam_id`) REFERENCES `cbt_exams`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`participant_id`) REFERENCES `public_cbt_participants`(`id`) ON DELETE CASCADE,
  INDEX `idx_exam` (`exam_id`),
  INDEX `idx_participant` (`participant_id`),
  INDEX `idx_status` (`status`),
  UNIQUE KEY `unique_participant_exam` (`exam_id`, `participant_id`) COMMENT 'One attempt per participant per exam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 5. Table for Public Exam Answers
-- ============================================
CREATE TABLE IF NOT EXISTS `public_cbt_answers` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `result_id` INT(11) UNSIGNED NOT NULL,
  `question_id` INT(11) UNSIGNED NOT NULL,
  `user_answer` ENUM('A', 'B', 'C', 'D', 'E') DEFAULT NULL,
  `is_correct` TINYINT(1) DEFAULT NULL,
  `answered_at` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`result_id`) REFERENCES `public_cbt_results`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`question_id`) REFERENCES `cbt_questions`(`id`) ON DELETE CASCADE,
  INDEX `idx_result` (`result_id`),
  INDEX `idx_question` (`question_id`),
  UNIQUE KEY `unique_result_question` (`result_id`, `question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- END OF PUBLIC CBT MIGRATION
-- ============================================
