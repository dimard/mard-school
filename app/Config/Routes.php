<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ============================================
// PUBLIC ROUTES
// ============================================
$routes->get('/', 'Home::index');
$routes->get('news/(:segment)', 'Home::newsDetail/$1');

// Public CBT Exams
$routes->group('ujian', function ($routes) {
    $routes->get('/', 'PublicExam::index');
    $routes->get('detail/(:num)', 'PublicExam::detail/$1');
    $routes->post('validate-access', 'PublicExam::validateAccess');
    $routes->get('daftar/(:num)', 'PublicExam::register/$1');
    $routes->post('daftar', 'PublicExam::storeParticipant');
    $routes->get('mulai/(:num)', 'PublicExam::exam/$1');
    $routes->post('save-answer', 'PublicExam::saveAnswer');
    $routes->post('submit/(:num)', 'PublicExam::submit/$1');
    $routes->get('hasil/(:num)', 'PublicExam::result/$1');
});

// PPDB (Public Registration)
$routes->group('ppdb', function ($routes) {
    $routes->get('/', 'PPDB::index');
    $routes->post('register', 'PPDB::register');
    $routes->get('success', 'PPDB::success');
    $routes->post('check-status', 'PPDB::checkStatus');
    $routes->get('check-status', 'PPDB::checkStatus');
});

// ============================================
// AUTH ROUTES
// ============================================
$routes->group('auth', function ($routes) {
    $routes->get('login', 'Auth\Login::index');
    $routes->post('login', 'Auth\Login::authenticate');
    $routes->get('logout', 'Auth\Logout::index');
});

// ============================================
// ADMIN ROUTES (Role: admin)
// ============================================
$routes->group('admin', ['filter' => 'auth:admin'], function ($routes) {
    // Dashboard
    $routes->get('dashboard', 'Admin\Dashboard::index');

    // News Management
    $routes->get('news', 'Admin\News::index');
    $routes->get('news/create', 'Admin\News::create');
    $routes->post('news/store', 'Admin\News::store');
    $routes->get('news/edit/(:num)', 'Admin\News::edit/$1');
    $routes->post('news/update/(:num)', 'Admin\News::update/$1');
    $routes->get('news/delete/(:num)', 'Admin\News::delete/$1');

    // Slider Management
    $routes->get('slider', 'Admin\Slider::index');
    $routes->get('slider/create', 'Admin\Slider::create');
    $routes->post('slider/store', 'Admin\Slider::store');
    $routes->get('slider/delete/(:num)', 'Admin\Slider::delete/$1');

    // Settings Management
    $routes->get('settings', 'Admin\Settings::index');
    $routes->post('settings/update', 'Admin\Settings::update');
    $routes->post('settings/uploadSlider', 'Admin\\Settings::uploadSlider');
    $routes->post('settings/deleteSlider/(:num)', 'Admin\\Settings::deleteSlider/$1');
    // User Management (Students & Teachers)
    $routes->get('users', 'Admin\Users::index');
    $routes->get('students', 'Admin\Users::students');
    $routes->get('teachers', 'Admin\Users::teachers');
    $routes->get('users/create', 'Admin\Users::create');
    $routes->post('users/store', 'Admin\Users::store');
    $routes->get('users/edit/(:num)', 'Admin\Users::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\Users::update/$1');
    $routes->get('users/delete/(:num)', 'Admin\Users::delete/$1');

    // Student-specific route aliases (for convenience)
    $routes->get('students/add', 'Admin\Users::create');
    $routes->post('students/store', 'Admin\Users::store');
    $routes->get('students/edit/(:num)', 'Admin\Users::edit/$1');
    $routes->post('students/update/(:num)', 'Admin\Users::update/$1');
    $routes->get('students/delete/(:num)', 'Admin\Users::delete/$1');

    // Materials Management
    $routes->get('materials', 'Admin\Materials::index');
    $routes->get('materials/upload', 'Admin\Materials::upload');
    $routes->post('materials/store', 'Admin\Materials::store');
    $routes->get('materials/delete/(:num)', 'Admin\Materials::delete/$1');

    // CBT Exam Management
    $routes->get('cbt', 'Admin\Cbt::index');
    $routes->get('cbt/create', 'Admin\Cbt::create');
    $routes->post('cbt/store', 'Admin\Cbt::store');
    $routes->get('cbt/edit/(:num)', 'Admin\Cbt::edit/$1');
    $routes->post('cbt/update/(:num)', 'Admin\Cbt::update/$1');
    $routes->get('cbt/delete/(:num)', 'Admin\Cbt::delete/$1');
    $routes->get('cbt/toggle/(:num)', 'Admin\Cbt::toggleActive/$1');

    // CBT Questions Management
    $routes->get('cbt/(:num)/questions', 'Admin\CbtQuestions::index/$1');
    $routes->get('cbt/(:num)/questions/create', 'Admin\CbtQuestions::create/$1');
    $routes->post('cbt/(:num)/questions/store', 'Admin\CbtQuestions::store/$1');
    $routes->get('cbt/questions/edit/(:num)', 'Admin\CbtQuestions::edit/$1');
    $routes->post('cbt/questions/update/(:num)', 'Admin\CbtQuestions::update/$1');
    $routes->get('cbt/questions/delete/(:num)', 'Admin\CbtQuestions::delete/$1');

    // CBT Results
    $routes->get('cbt/(:num)/results', 'Admin\CbtResults::index/$1');
    $routes->get('cbt/results/detail/(:num)', 'Admin\CbtResults::detail/$1');

    // Public Exam Reports
    $routes->get('public-exam-reports', 'Admin\PublicCbtReports::index');
    $routes->get('public-exam-reports/details/(:num)', 'Admin\PublicCbtReports::examDetails/$1');
    $routes->get('public-exam-reports/export/(:num)', 'Admin\PublicCbtReports::export/$1');

    // Attendance Recap
    $routes->get('attendance', 'Admin\Attendance::index');
    $routes->get('attendance/scan', 'Admin\Attendance::scan');
    $routes->post('attendance/ajax-scan', 'Admin\Attendance::ajax_scan');
    $routes->get('attendance/recap', 'Admin\Attendance::recap');
    $routes->post('attendance/filter', 'Admin\Attendance::filter');

    // Class Management (Using Guru Controller logic)
    $routes->get('classes', 'Guru\Classes::index');
    $routes->get('classes/create', 'Guru\Classes::create');
    $routes->post('classes/store', 'Guru\Classes::store');
    $routes->get('classes/view/(:num)', 'Guru\Classes::view/$1');
    $routes->get('classes/(:num)/reports', 'Admin\Reports::classReport/$1');

    // Homepage Management
    $routes->get('homepage', 'Admin\Homepage::index');
    $routes->post('homepage/add-nav-link', 'Admin\Homepage::addNavLink');
    $routes->post('homepage/update-nav-link/(:num)', 'Admin\Homepage::updateNavLink/$1');
    $routes->get('homepage/delete-nav-link/(:num)', 'Admin\Homepage::deleteNavLink/$1');
    $routes->post('homepage/update-about', 'Admin\Homepage::updateAbout');
    $routes->post('homepage/update-footer', 'Admin\Homepage::updateFooter');

    // Homepage Features Management
    $routes->post('homepage/add-feature', 'Admin\Homepage::addFeature');
    $routes->post('homepage/update-feature/(:num)', 'Admin\Homepage::updateFeature/$1');
    $routes->get('homepage/delete-feature/(:num)', 'Admin\Homepage::deleteFeature/$1');

    // Theme Settings
    $routes->get('theme', 'Admin\\ThemeSettings::index');
    $routes->post('theme/update', 'Admin\\ThemeSettings::update');
    $routes->get('theme/reset', 'Admin\\ThemeSettings::resetToDefault');

    // Slider Management (Hero Section)
    $routes->get('sliders', 'Admin\Sliders::index');
    $routes->get('sliders/create', 'Admin\Sliders::create');
    $routes->post('sliders/store', 'Admin\Sliders::store');
    $routes->get('sliders/edit/(:num)', 'Admin\Sliders::edit/$1');
    $routes->post('sliders/update/(:num)', 'Admin\Sliders::update/$1');
    $routes->get('sliders/delete/(:num)', 'Admin\Sliders::delete/$1');
    $routes->get('sliders/set-active/(:num)', 'Admin\Sliders::setActive/$1');

    // Staff Management
    $routes->get('staff', 'Admin\Staff::index');
    $routes->get('staff/create', 'Admin\Staff::create');
    $routes->post('staff/store', 'Admin\Staff::store');
    $routes->get('staff/edit/(:num)', 'Admin\Staff::edit/$1');
    $routes->post('staff/update/(:num)', 'Admin\Staff::update/$1');
    $routes->get('staff/delete/(:num)', 'Admin\Staff::delete/$1');
    $routes->get('staff/toggle/(:num)', 'Admin\Staff::toggleActive/$1');

    // Testimonials Management
    $routes->get('testimonials', 'Admin\Testimonials::index');
    $routes->get('testimonials/create', 'Admin\Testimonials::create');
    $routes->post('testimonials/store', 'Admin\Testimonials::store');
    $routes->get('testimonials/edit/(:num)', 'Admin\Testimonials::edit/$1');
    $routes->post('testimonials/update/(:num)', 'Admin\Testimonials::update/$1');
    $routes->get('testimonials/delete/(:num)', 'Admin\Testimonials::delete/$1');

    // E-Reports
    $routes->get('reports', 'Admin\\Reports::index');
    $routes->get('reports/settings', 'Admin\\Reports::settings');
    $routes->post('reports/settings', 'Admin\\Reports::updateSettings');
    $routes->get('reports/print/(:num)/(:num)', 'Admin\\Reports::print/$1/$2');

    // PPDB Management
    $routes->get('ppdb', 'Admin\\PPDB::index');
    $routes->get('ppdb/view/(:num)', 'Admin\\PPDB::view/$1');
    $routes->post('ppdb/update-status/(:num)', 'Admin\\PPDB::updateStatus/$1');
    $routes->get('ppdb/delete/(:num)', 'Admin\\PPDB::delete/$1');
    $routes->get('ppdb/settings', 'Admin\\PPDB::settings');
    $routes->post('ppdb/settings/update', 'Admin\\PPDB::updateSettings');
    $routes->get('ppdb/export', 'Admin\\PPDB::export');
});

// ============================================
// GURU ROUTES (Role: guru)
// ============================================
$routes->group('guru', ['filter' => 'auth:guru'], function ($routes) {
    // Dashboard
    $routes->get('dashboard', 'Guru\Dashboard::index');

    // Materials
    $routes->get('materials', 'Guru\Materials::index');
    $routes->get('materials/upload', 'Guru\Materials::upload');
    $routes->post('materials/store', 'Guru\Materials::store');
    $routes->get('materials/delete/(:num)', 'Guru\Materials::delete/$1');

    // Students
    $routes->get('students', 'Guru\Students::index');

    // Reports
    $routes->get('reports', 'Guru\Reports::index');

    // Conduct Input
    $routes->get('conduct', 'Guru\Conduct::index');
    $routes->post('conduct/save', 'Guru\Conduct::save');

    // Class Management
    $routes->get('classes', 'Guru\Classes::index');
    $routes->get('classes/create', 'Guru\Classes::create');
    $routes->post('classes/store', 'Guru\Classes::store');
    $routes->get('classes/view/(:num)', 'Guru\Classes::view/$1');

    // Class Announcements
    $routes->get('classes/announcements/(:num)', 'Guru\\Announcements::index/$1');
    $routes->get('classes/announcements/(:num)/create', 'Guru\\Announcements::create/$1');
    $routes->post('classes/announcements/(:num)/store', 'Guru\\Announcements::store/$1');
    $routes->get('announcements/view/(:num)', 'Guru\\Announcements::view/$1');
    $routes->get('announcements/edit/(:num)', 'Guru\\Announcements::edit/$1');
    $routes->post('announcements/update/(:num)', 'Guru\\Announcements::update/$1');
    $routes->get('announcements/delete/(:num)', 'Guru\\Announcements::delete/$1');

    // Assignments
    $routes->get('classes/assignments/(:num)', 'Guru\\Assignments::index/$1');
    $routes->get('classes/assignments/(:num)/create', 'Guru\\Assignments::create/$1');
    $routes->post('classes/assignments/(:num)/store', 'Guru\\Assignments::store/$1');
    $routes->get('assignments/edit/(:num)', 'Guru\\Assignments::edit/$1');
    $routes->post('assignments/update/(:num)', 'Guru\\Assignments::update/$1');
    $routes->get('assignments/delete/(:num)', 'Guru\\Assignments::delete/$1');
    $routes->get('assignments/(:num)/submissions', 'Guru\\Assignments::submissions/$1');
    $routes->post('assignments/submissions/(:num)/grade', 'Guru\\Assignments::grade/$1');

    // Attendance
    $routes->get('classes/attendance/(:num)', 'Guru\\Attendance::index/$1');
    $routes->post('classes/attendance/(:num)/schedule', 'Guru\\Attendance::storeSchedule/$1');
    $routes->get('attendance/schedule/delete/(:num)', 'Guru\\Attendance::deleteSchedule/$1');

    // CBT Management
    $routes->get('cbt', 'Guru\\Cbt::index');
    $routes->get('cbt/create', 'Guru\\Cbt::create');
    $routes->post('cbt/store', 'Guru\\Cbt::store');
    $routes->get('cbt/edit/(:num)', 'Guru\\Cbt::edit/$1');
    $routes->post('cbt/update/(:num)', 'Guru\\Cbt::update/$1');
    $routes->get('cbt/delete/(:num)', 'Guru\\Cbt::delete/$1');
    $routes->get('cbt/toggle/(:num)', 'Guru\\Cbt::toggleActive/$1');

    // CBT Questions Management
    $routes->get('cbt/(:num)/questions', 'Guru\\CbtQuestions::index/$1');
    $routes->get('cbt/(:num)/questions/create', 'Guru\\CbtQuestions::create/$1');
    $routes->post('cbt/(:num)/questions/store', 'Guru\\CbtQuestions::store/$1');
    $routes->get('cbt/questions/edit/(:num)', 'Guru\\CbtQuestions::edit/$1');
    $routes->post('cbt/questions/update/(:num)', 'Guru\\CbtQuestions::update/$1');
    $routes->get('cbt/questions/delete/(:num)', 'Guru\\CbtQuestions::delete/$1');

    // CBT Results
    $routes->get('cbt/(:num)/results', 'Guru\\CbtResults::index/$1'); // Optional: if we want teachers to see results
    $routes->get('cbt/results/detail/(:num)', 'Guru\\CbtResults::detail/$1'); // Optional

    // Settings
    $routes->get('settings', 'Guru\\Settings::index');
    $routes->post('settings/update', 'Guru\\Settings::update');
    $routes->get('profile', 'Guru\\Settings::index'); // Route alias for profile

    // Class Reports
    $routes->get('classes/(:num)/reports', 'Guru\\Reports::classReport/$1');

    // Sub Class Management (Homeroom Teacher)
    $routes->get('classes/(:num)/sub-classes/create', 'Guru\\Classes::createSubClass/$1');
    $routes->post('classes/(:num)/sub-classes/store', 'Guru\\Classes::storeSubClass/$1');
    $routes->get('sub-classes/edit/(:num)', 'Guru\\Classes::editSubClass/$1');
    $routes->post('sub-classes/update/(:num)', 'Guru\\Classes::updateSubClass/$1');
    $routes->get('sub-classes/delete/(:num)', 'Guru\\Classes::deleteSubClass/$1');

    // Conduct Management
    $routes->get('classes/(:num)/conduct', 'Guru\\Classes::conduct/$1');
    $routes->post('classes/(:num)/conduct/batch', 'Guru\\Classes::storeConductBatch/$1');

    // Report Overview  
    $routes->get('classes/(:num)/report-overview', 'Guru\\Classes::reportOverview/$1');

    // Sub Classes (Subject Teacher)
    $routes->get('sub-classes', 'Guru\\SubClasses::index');
    $routes->get('sub-classes/view/(:num)', 'Guru\\SubClasses::view/$1');

    // Sub Class Announcements
    $routes->get('sub-classes/(:num)/announcements/create', 'Guru\\SubClasses::createAnnouncement/$1');
    $routes->post('sub-classes/(:num)/announcements/store', 'Guru\\SubClasses::storeAnnouncement/$1');

    // Sub Class Assignments  
    $routes->get('sub-classes/(:num)/assignments/create', 'Guru\\SubClasses::createAssignment/$1');
    $routes->post('sub-classes/(:num)/assignments/store', 'Guru\\SubClasses::storeAssignment/$1');
    $routes->get('sub-classes/assignments/(:num)/grade', 'Guru\\SubClasses::gradeAssignment/$1');

    // Sub Class Materials
    $routes->get('sub-classes/(:num)/materials/create', 'Guru\\SubClasses::createMaterial/$1');
    $routes->post('sub-classes/(:num)/materials/store', 'Guru\\SubClasses::storeMaterial/$1');
});

// ============================================
// SISWA ROUTES (Role: siswa)
// ============================================
$routes->group('siswa', ['filter' => 'auth:siswa'], function ($routes) {
    // Dashboard
    $routes->get('dashboard', 'Siswa\Dashboard::index');

    // Classes
    $routes->get('classes', 'Siswa\Classes::index');
    $routes->post('classes/join', 'Siswa\Classes::join');
    $routes->get('classes/view/(:num)', 'Siswa\Classes::view/$1');

    // CBT Exams
    $routes->get('cbt', 'Siswa\Cbt::index');
    $routes->get('cbt/start/(:num)', 'Siswa\Cbt::start/$1');
    $routes->post('cbt/answer', 'Siswa\Cbt::saveAnswer');
    $routes->post('cbt/submit/(:num)', 'Siswa\Cbt::submit/$1');
    $routes->get('cbt/result/(:num)', 'Siswa\Cbt::result/$1');

    // Materials
    $routes->get('materials', 'Siswa\Materials::index');
    $routes->get('materials/download/(:num)', 'Siswa\Materials::download/$1');

    // Profile
    $routes->get('profile', 'Siswa\Profile::index');
    $routes->post('profile/update', 'Siswa\Profile::update');

    // Class Announcements
    $routes->get('classes/(:num)/announcements', 'Siswa\\Announcements::index/$1');
    $routes->get('announcements/view/(:num)', 'Siswa\\Announcements::view/$1');
    $routes->post('announcements/(:num)/comment', 'Siswa\\Announcements::addComment/$1');

    // Assignments
    $routes->get('classes/(:num)/assignments', 'Siswa\\Assignments::index/$1');
    $routes->get('assignments/view/(:num)', 'Siswa\\Assignments::view/$1');
    $routes->post('assignments/(:num)/submit', 'Siswa\\Assignments::submit/$1');

    // Attendance
    $routes->get('classes/(:num)/attendance', 'Siswa\\Attendance::index/$1');
    $routes->post('classes/(:num)/checkin', 'Siswa\\Attendance::checkIn/$1');

    // Sub Classes
    $routes->get('sub-classes/view/(:num)', 'Siswa\\Classes::viewSubClass/$1');
});
