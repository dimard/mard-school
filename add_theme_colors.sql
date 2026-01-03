-- Add theme color settings to settings table
-- Run this in phpMyAdmin

-- Insert default theme color settings
INSERT INTO `settings` (`key`, `value`, `created_at`, `updated_at`) VALUES
('theme_primary_color', '#04a9f5', NOW(), NOW()),
('theme_secondary_color', '#1de9b6', NOW(), NOW()),
('theme_accent_color', '#f4516c', NOW(), NOW())
ON DUPLICATE KEY UPDATE updated_at = NOW();
