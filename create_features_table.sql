-- ============================================
-- TABEL HOMEPAGE_FEATURES (Our Features Section)
-- ============================================
CREATE TABLE IF NOT EXISTS `homepage_features` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `icon_class` VARCHAR(100) NOT NULL COMMENT 'CSS class for icon (e.g., uil uil-book-open)',
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `sort_order` INT(11) NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_active` (`is_active`),
  INDEX `idx_sort` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default features
INSERT INTO `homepage_features` (`icon_class`, `title`, `description`, `sort_order`, `is_active`) VALUES
('uil uil-book-open', 'Virtual Classes', 'Create and manage online classrooms with code-based enrollment system.', 1, 1),
('uil uil-clipboard-notes', 'CBT Exams', 'Computer-based testing with automatic grading and detailed analytics.', 2, 1),
('uil uil-book-alt', 'Assignments', 'Distribute and grade assignments with deadline tracking.', 3, 1),
('uil uil-clock', 'Attendance', 'Digital attendance tracking with real-time monitoring.', 4, 1),
('uil uil-chart-line', 'Reports', 'Comprehensive performance reports and student rankings.', 5, 1),
('uil uil-users-alt', 'User Management', 'Manage admin, teachers, and students with role-based access.', 6, 1);
