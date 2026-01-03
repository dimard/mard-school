<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', [
        'pageTitle' => 'Kelas Saya',
        'metaDescription' => 'Kelas Guru - Sistem Manajemen Sekolah'
    ]) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">

    <?= view('layouts/loader') ?>

    <?php
    $menuItems = [
        [
            'caption' => 'Navigasi',
            'items' => [
                ['label' => 'Dashboard', 'url' => 'guru/dashboard', 'icon' => 'ph ph-house-line']
            ]
        ],
        [
            'caption' => 'Akademik',
            'items' => [
                ['label' => 'Kelas Saya', 'url' => 'guru/classes', 'icon' => 'ph ph-chalkboard', 'active' => true],
                ['label' => 'Materi', 'url' => 'guru/materials', 'icon' => 'ph ph-book-open-text'],
                ['label' => 'Ujian CBT', 'url' => 'guru/cbt', 'icon' => 'ph ph-laptop'],
            ]
        ],
        [
            'caption' => 'Administrasi',
            'items' => [
                ['label' => 'Laporan', 'url' => 'guru/reports', 'icon' => 'ph ph-chart-line']
            ]
        ],
        [
            'caption' => 'Akun',
            'items' => [
                ['label' => 'Profil Saya', 'url' => 'guru/profile', 'icon' => 'ph ph-user-circle'],
                ['label' => 'Pengaturan', 'url' => 'guru/settings', 'icon' => 'ph ph-gear']
            ]
        ]
    ];
    ?>
    <?= view('layouts/sidebar', [
        'menuItems' => $menuItems,
        'homeUrl' => 'guru/dashboard'
    ]) ?>

    <?= view('layouts/topbar', [
        'notificationCount' => 0,
        'notifications' => [],
        'profileUrl' => 'guru/profile',
        'settingsUrl' => 'guru/settings'
    ]) ?>

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">

            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Kelas Saya',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'guru/dashboard'],
                    ['label' => 'Kelas Saya']
                ]
            ]) ?>

            <?php if (session()->getFlashdata('message')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="ph ph-check-circle me-2"></i>
                    <?= session()->getFlashdata('message') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Create Class Button -->
            <div class="row mb-3">
                <div class="col-12">
                    <a href="<?= base_url('guru/classes/create') ?>" class="btn btn-primary">
                        <i class="ph ph-plus-circle me-2"></i>Buat Kelas Baru
                    </a>
                </div>
            </div>

            <!-- Classes Grid -->
            <div class="row">
                <?php if (empty($classes)): ?>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <i class="ph ph-chalkboard-teacher text-muted" style="font-size: 5rem; opacity: 0.3;"></i>
                                <h4 class="mt-4 text-muted">Belum Ada Kelas</h4>
                                <p class="text-muted mb-4">Buat kelas untuk mulai mengelola siswa dan materi Anda</p>
                                <a href="<?= base_url('guru/classes/create') ?>" class="btn btn-primary">
                                    <i class="ph ph-plus-circle me-2"></i>Buat Kelas Pertama Anda
                                </a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($classes as $class): ?>
                        <div class="col-xl-4 col-md-6">
                            <div class="card">
                                <div class="card-header bg-primary">
                                    <h5 class="text-white mb-1"><?= esc($class['name']) ?></h5>
                                    <span class="badge bg-white text-primary">
                                        <i class="ph ph-key me-1"></i><?= esc($class['code']) ?>
                                    </span>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted mb-3">
                                        <?= esc($class['description'] ?: 'Tidak ada deskripsi.') ?>
                                    </p>

                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="badge bg-light-secondary">
                                                <i class="ph ph-users me-1"></i>
                                                <?= isset($class['student_count']) ? $class['student_count'] : '0' ?> Siswa
                                            </span>
                                        </div>
                                        <a href="<?= base_url('guru/classes/view/' . $class['id']) ?>"
                                            class="btn btn-primary btn-sm">
                                            <i class="ph ph-sign-in me-1"></i>Masuk Kelas
                                        </a>
                                    </div>
                                </div>
                                <div class="card-footer bg-light-secondary">
                                    <div class="row text-center">
                                        <div class="col-12">
                                            <a href="<?= base_url('guru/materials?class_id=' . $class['id']) ?>"
                                                class="btn btn-sm btn-success w-100">
                                                <i class="ph ph-book-open me-1"></i>Materi
                                            </a>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <small class="text-muted d-block text-center">
                                            <i class="ph ph-info me-1"></i>Tindakan lainnya di detail kelas
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>
    </div>
    <!-- [ Main Content ] end -->

    <?= view('layouts/footer_js', ['includeCharts' => false]) ?>

</body>

</html>