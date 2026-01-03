<?php

namespace App\Controllers\Admin;

use App\Models\SettingModel;

class ThemeSettings extends \App\Controllers\BaseController
{
    protected $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
    }

    /**
     * Display theme settings page
     */
    public function index()
    {
        $data = [
            'pageTitle' => 'Theme Settings',
            'navbar_color' => $this->settingModel->getSetting('theme_navbar_color', '#04a9f5'),
            'slider_overlay_color' => $this->settingModel->getSetting('theme_slider_overlay_color', '#04a9f5'),
            'footer_color' => $this->settingModel->getSetting('theme_footer_color', '#04a9f5'),
            'button_color' => $this->settingModel->getSetting('theme_button_color', '#04a9f5'),
            'link_hover_color' => $this->settingModel->getSetting('theme_link_hover_color', '#04a9f5'),
            'heading_color' => $this->settingModel->getSetting('theme_heading_color', '#1f2d3d'),
        ];

        return view('admin/theme/index', $data);
    }

    /**
     * Update theme colors
     */
    public function update()
    {
        $navbarColor = $this->request->getPost('theme_navbar_color');
        $sliderColor = $this->request->getPost('theme_slider_overlay_color');
        $footerColor = $this->request->getPost('theme_footer_color');
        $buttonColor = $this->request->getPost('theme_button_color');
        $linkColor = $this->request->getPost('theme_link_hover_color');
        $headingColor = $this->request->getPost('theme_heading_color');

        // Validate hex colors
        if (
            !$this->isValidHexColor($navbarColor) ||
            !$this->isValidHexColor($sliderColor) ||
            !$this->isValidHexColor($footerColor) ||
            !$this->isValidHexColor($buttonColor) ||
            !$this->isValidHexColor($linkColor) ||
            !$this->isValidHexColor($headingColor)
        ) {
            return redirect()->back()->with('error', 'Invalid color format. Please use hex color codes.');
        }

        // Save colors
        $this->settingModel->setSetting('theme_navbar_color', $navbarColor);
        $this->settingModel->setSetting('theme_slider_overlay_color', $sliderColor);
        $this->settingModel->setSetting('theme_footer_color', $footerColor);
        $this->settingModel->setSetting('theme_button_color', $buttonColor);
        $this->settingModel->setSetting('theme_link_hover_color', $linkColor);
        $this->settingModel->setSetting('theme_heading_color', $headingColor);

        // Generate CSS
        $this->generateCSS($navbarColor, $sliderColor, $footerColor, $buttonColor, $linkColor, $headingColor);

        return redirect()->back()->with('success', 'Theme colors updated successfully!');
    }

    /**
     * Reset to default colors
     */
    public function resetToDefault()
    {
        $defaultColor = '#04a9f5';
        $defaultHeadingColor = '#1f2d3d';

        $this->settingModel->setSetting('theme_navbar_color', $defaultColor);
        $this->settingModel->setSetting('theme_slider_overlay_color', $defaultColor);
        $this->settingModel->setSetting('theme_footer_color', $defaultColor);
        $this->settingModel->setSetting('theme_button_color', $defaultColor);
        $this->settingModel->setSetting('theme_link_hover_color', $defaultColor);
        $this->settingModel->setSetting('theme_heading_color', $defaultHeadingColor);

        // Generate CSS
        $this->generateCSS($defaultColor, $defaultColor, $defaultColor, $defaultColor, $defaultColor, $defaultHeadingColor);

        return redirect()->back()->with('success', 'Theme colors reset to default!');
    }

    /**
     * Generate dynamic CSS file
     */
    private function generateCSS($navbarColor, $sliderColor, $footerColor, $buttonColor, $linkColor, $headingColor)
    {
        // Convert hex to RGB for opacity support
        $navbarRgb = $this->hexToRgb($navbarColor);
        $sliderRgb = $this->hexToRgb($sliderColor);

        $cssContent = "/* Theme Dynamic CSS - Auto Generated */\n";
        $cssContent .= "/* Do not edit manually - Use Theme Settings in Admin Panel */\n\n";
        $cssContent .= ":root {\n";
        $cssContent .= "    --navbar-color: {$navbarColor};\n";
        $cssContent .= "    --navbar-rgb: {$navbarRgb};\n";
        $cssContent .= "    --slider-overlay-color: {$sliderColor};\n";
        $cssContent .= "    --slider-overlay-rgb: {$sliderRgb};\n";
        $cssContent .= "    --footer-color: {$footerColor};\n";
        $cssContent .= "    --button-color: {$buttonColor};\n";
        $cssContent .= "    --link-hover-color: {$linkColor};\n";
        $cssContent .= "    --heading-color: {$headingColor};\n";
        $cssContent .= "}\n\n";

        // Hero Slider Background Overlay with opacity (60% = 0.6)
        $cssContent .= "/* Hero Slider Semi-Transparent Overlay */\n";
        $cssContent .= ".untree_co-hero.overlay::before { background-color: rgba(var(--slider-overlay-rgb), 0.6) !important; }\n";
        $cssContent .= ".untree_co-hero .overlay::before { background-color: rgba(var(--slider-overlay-rgb), 0.6) !important; }\n\n";

        // Call to Action Background Overlay (same as slider)
        $cssContent .= "/* Call to Action Section Overlay */\n";
        $cssContent .= ".untree_co-section.overlay::before { background-color: rgba(var(--slider-overlay-rgb), 0.6) !important; }\n";
        $cssContent .= ".untree_co-section.bg-img.overlay::before { background-color: rgba(var(--slider-overlay-rgb), 0.6) !important; }\n\n";

        // Page Header Background (Public Exam Pages)
        $cssContent .= "/* Page Header - Public Exam Pages */\n";
        $cssContent .= ".page-header { background-color: rgba(var(--slider-overlay-rgb), 0.85) !important; padding: 80px 0; }\n";
        $cssContent .= ".page-header h1 { color: #ffffff !important; font-weight: 700; }\n";
        $cssContent .= ".page-header .text-white-opacity { color: rgba(255, 255, 255, 0.8) !important; }\n\n";

        // Navigation Bar - Make TRANSPARENT to blend with slider overlay (Prevent double layer darkening)
        $cssContent .= "/* Navigation Bar - Transparent to blend with Slider */\n";
        $cssContent .= ".site-nav { background-color: transparent !important; background: transparent !important; box-shadow: none !important; }\n";
        $cssContent .= "nav.site-nav .top-bar,\n";
        $cssContent .= "nav.site-nav .pb-2.top-bar,\n";
        $cssContent .= ".site-nav > .top-bar,\n";
        $cssContent .= ".site-nav > .pb-2,\n";
        $cssContent .= ".site-nav .container,\n";
        $cssContent .= ".top-bar,\n";
        $cssContent .= ".pb-2.top-bar { background-color: transparent !important; background: none !important; }\n\n";

        // FORCE Sticky Nav to be WHITE when scrolled - OVERRIDE everything
        $cssContent .= "/* Sticky Nav Styling - White on Scroll */\n";

        // 1. Background White
        $cssContent .= ".sticky-wrapper.is-sticky .sticky-nav,\n";
        $cssContent .= ".sticky-wrapper.is-sticky .js-sticky-header,\n";
        $cssContent .= ".sticky-wrapper.is-sticky .site-navbar,\n";
        $cssContent .= ".sticky-wrapper.is-sticky .site-nav { background-color: #ffffff !important; background: #ffffff !important; box-shadow: 0 4px 15px -5px rgba(0,0,0,0.1) !important; }\n";

        // 2. Change Text Color to Dark/Theme Color when Sticky (so it's visible on white)
        $cssContent .= ".sticky-wrapper.is-sticky .site-menu > li > a { color: #000000 !important; }\n";
        $cssContent .= ".sticky-wrapper.is-sticky .site-menu > li.active > a { color: var(--navbar-color) !important; }\n";
        $cssContent .= ".sticky-wrapper.is-sticky .logo { color: #000000 !important; }\n";

        // 3. Keep Transparent when NOT sticky
        $cssContent .= ".sticky-nav { background-color: transparent; transition: .3s all ease; }\n\n";

        // Footer
        $cssContent .= "/* Footer Background */\n";
        $cssContent .= ".site-footer { background-color: var(--footer-color) !important; }\n\n";

        // Buttons - INCLUDE .btn-secondary for the "Get Started" slider button
        $cssContent .= "/* Buttons */\n";
        $cssContent .= ".btn-primary, .btn-secondary { background-color: var(--button-color) !important; border-color: var(--button-color) !important; color: #fff !important; }\n";
        $cssContent .= ".btn-primary:hover, .btn-secondary:hover { background-color: var(--button-color) !important; opacity: 0.85; }\n";
        $cssContent .= ".btn-book { background-color: var(--button-color) !important; border-color: var(--button-color) !important; }\n\n";

        // Links and Hover States
        $cssContent .= "/* Links and Hover States */\n";
        $cssContent .= "a:hover { color: var(--link-hover-color) !important; }\n";
        $cssContent .= ".site-menu > li.active > a { color: var(--link-hover-color) !important; }\n";
        $cssContent .= ".line-bottom::after { background-color: var(--link-hover-color) !important; }\n";
        $cssContent .= ".service-number { color: var(--link-hover-color) !important; }\n\n";

        // VISIBILITY ENHANCEMENTS (Bold Text)
        $cssContent .= "/* Text Visibility Enhancements - Bold Fonts */\n";
        // Top Bar
        $cssContent .= ".top-bar, .top-bar a, .top-bar span { font-weight: 700 !important; }\n";
        // Navbar
        $cssContent .= ".site-menu > li > a { font-weight: 700 !important; }\n";
        $cssContent .= ".logo { font-weight: 800 !important; }\n";
        // Slider - Back to White
        $cssContent .= ".untree_co-hero .caption { font-weight: 700 !important; color: #ffffff !important; }\n";
        $cssContent .= ".untree_co-hero .heading { font-weight: 800 !important; color: #ffffff !important; }\n";
        $cssContent .= ".untree_co-hero .desc { font-weight: 600 !important; color: #ffffff !important; }\n";
        $cssContent .= ".untree_co-hero .desc p { font-weight: 600 !important; color: #ffffff !important; }\n\n";

        // Homepage H2 Headings Color
        $cssContent .= "/* Homepage H2 Headings */\n";
        $cssContent .= "h2 { color: var(--heading-color) !important; }\n";
        $cssContent .= ".line-bottom { color: var(--heading-color) !important; }\n";
        $cssContent .= "h2 a, h2 a:hover { color: var(--heading-color) !important; text-decoration: none; }\n";

        // News Section - More specific selectors
        $cssContent .= "/* News Section Specific */\n";
        $cssContent .= ".media-h-body h2 { color: var(--heading-color) !important; }\n";
        $cssContent .= ".media-h-body h2 a { color: var(--heading-color) !important; }\n";
        $cssContent .= ".media-h-body h2 a:hover { color: var(--heading-color) !important; text-decoration: none; }\n\n";

        // H3 Headings (Staff, Alumni, etc.)
        $cssContent .= "/* H3 Headings - Staff Names, Alumni Names */\n";
        $cssContent .= "h3 { color: var(--heading-color) !important; }\n";
        $cssContent .= ".staff-name { color: var(--heading-color) !important; }\n";
        $cssContent .= ".author h3 { color: var(--heading-color) !important; }\n";
        $cssContent .= ".block-testimonial .author h3 { color: var(--heading-color) !important; }\n\n";

        // Read More Links in News Section
        $cssContent .= "/* Read More Links */\n";
        $cssContent .= ".media-h-body a { color: var(--heading-color) !important; }\n";
        $cssContent .= ".media-h-body a:hover { color: var(--heading-color) !important; opacity: 0.8; }\n\n";

        // Footer Headings Exception - Keep White
        $cssContent .= "/* Footer Headings - Keep White */\n";
        $cssContent .= ".site-footer h2, .site-footer h3 { color: #ffffff !important; }\n";
        $cssContent .= ".site-footer .widget h3 { color: #ffffff !important; }\n";

        $cssPath = FCPATH . 'assets/css/theme-dynamic.css';

        // Create directory if not exists
        $dir = dirname($cssPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        file_put_contents($cssPath, $cssContent);
    }

    /**
     * Convert hex color to RGB values
     */
    private function hexToRgb($hex)
    {
        // Remove # if present
        $hex = ltrim($hex, '#');

        // Convert to RGB
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        return "{$r}, {$g}, {$b}";
    }

    /**
     * Validate hex color format
     */
    private function isValidHexColor($color)
    {
        return preg_match('/^#[a-f0-9]{6}$/i', $color);
    }
}
