-- Add specific theme color settings to settings table
-- Run this in phpMyAdmin

INSERT INTO `settings` (`key`, `value`, `created_at`, `updated_at`) VALUES
('theme_navbar_color', '#04a9f5', NOW(), NOW()),
('theme_slider_overlay_color', '#04a9f5', NOW(), NOW()),
('theme_footer_color', '#04a9f5', NOW(), NOW()),
('theme_button_color', '#04a9f5', NOW(), NOW()),
('theme_link_hover_color', '#04a9f5', NOW(), NOW())
ON DUPLICATE KEY UPDATE updated_at = NOW();

-- Remove old generic color settings (optional)
-- DELETE FROM `settings` WHERE `key` IN ('theme_primary_color', 'theme_secondary_color', 'theme_accent_color');
