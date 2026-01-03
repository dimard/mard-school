<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Hasil Ujian']) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>

    <?php
    $menuItems = [
        [
            'caption' => 'Navigasi',
            'items' => [
                ['label' => 'Dashboard', 'url' => 'siswa/dashboard', 'icon' => 'ph ph-house-line']
            ]
        ],
        [
            'caption' => 'Akademik',
            'items' => [
                ['label' => 'Kelas Saya', 'url' => 'siswa/classes', 'icon' => 'ph ph-chalkboard'],
                ['label' => 'Ujian CBT', 'url' => 'siswa/cbt', 'icon' => 'ph ph-laptop', 'active' => true],
                ['label' => 'Materi Pelajaran', 'url' => 'siswa/materials', 'icon' => 'ph ph-book-open-text']
            ]
        ],
        [
            'caption' => 'Akun',
            'icon' => 'ph ph-user',
            'items' => [
                [
                    'label' => 'Profil Saya',
                    'url' => 'siswa/profile',
                    'icon' => 'ph ph-user-circle'
                ]
            ]
        ]
    ];
    ?>
    <?= view('layouts/sidebar', ['menuItems' => $menuItems, 'homeUrl' => 'siswa/dashboard']) ?>
    <?= view('layouts/topbar', ['notificationCount' => 0, 'notifications' => [], 'profileUrl' => 'siswa/profile']) ?>

    <div class="pc-container">
        <div class="pc-content">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card text-center">
                        <div class="card-body py-5">
                            <div class="mb-4">
                                <div class="avtar avtar-xl bg-light-warning text-warning d-inline-flex">
                                    <i class="ph ph-trophy" style="font-size: 2.5rem;"></i>
                                </div>
                            </div>

                            <h2 class="mb-1">Ujian Selesai!</h2>
                            <p class="text-muted mb-4">Anda telah berhasil menyelesaikan
                                <strong><?= esc($exam['exam_name']) ?></strong>
                            </p>

                            <div class="card bg-light-primary border-0 mb-4 d-inline-block mx-auto"
                                style="min-width: 200px;">
                                <div class="card-body">
                                    <small class="text-primary fw-bold text-uppercase">Nilai Anda</small>
                                    <div class="display-3 fw-bold text-primary my-2">
                                        <?= number_format($result['score'], 0) ?>
                                    </div>
                                    <small class="text-muted">dari 100</small>
                                </div>
                            </div>

                            <div class="row g-3 justify-content-center mb-5">
                                <div class="col-auto">
                                    <div class="d-flex align-items-center p-3 border rounded bg-white">
                                        <i class="ph ph-clock-counter-clockwise text-muted me-2"></i>
                                        <div class="text-start">
                                            <small class="d-block text-muted" style="line-height:1">Dimulai</small>
                                            <strong><?= date('H:i', strtotime($result['start_time'])) ?></strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="d-flex align-items-center p-3 border rounded bg-white">
                                        <i class="ph ph-check-circle text-muted me-2"></i>
                                        <div class="text-start">
                                            <small class="d-block text-muted" style="line-height:1">Selesai</small>
                                            <strong><?= date('H:i', strtotime($result['end_time'])) ?></strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-sm-flex justify-content-center">
                                <?php if (!empty($exam['class_id'])): ?>
                                    <a href="<?= base_url('siswa/classes/view/' . $exam['class_id'] . '?tab=exams') ?>"
                                        class="btn btn-outline-secondary px-4">
                                        <i class="ph ph-arrow-left me-2"></i>Kembali ke Kelas
                                    </a>
                                <?php else: ?>
                                    <a href="<?= base_url('siswa/cbt') ?>" class="btn btn-outline-secondary px-4">
                                        <i class="ph ph-arrow-left me-2"></i>Kembali ke Ujian
                                    </a>
                                <?php endif; ?>
                                <a href="<?= base_url('siswa/dashboard') ?>" class="btn btn-primary px-4">
                                    Ke Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= view('layouts/footer_js', ['includeCharts' => false]) ?>
</body>

</html>