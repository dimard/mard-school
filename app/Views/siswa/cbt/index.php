<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Ujian Tersedia']) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>

    <?php
    $menuItems = [
        [
            'caption' => 'Navigasi',
            'items' => [
                [
                    'label' => 'Dashboard',
                    'url' => 'siswa/dashboard',
                    'icon' => 'ph ph-house-line'
                ]
            ]
        ],
        [
            'caption' => 'Akademik',
            'icon' => 'ph ph-book-open',
            'items' => [
                [
                    'label' => 'Kelas Saya',
                    'url' => 'siswa/classes',
                    'icon' => 'ph ph-chalkboard'
                ],
                [
                    'label' => 'Ujian CBT',
                    'url' => 'siswa/cbt',
                    'icon' => 'ph ph-laptop',
                    'active' => true
                ],
                [
                    'label' => 'Materi Pelajaran',
                    'url' => 'siswa/materials',
                    'icon' => 'ph ph-book-open-text'
                ],
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
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Ujian Tersedia',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'siswa/dashboard'],
                    ['label' => 'Ujian']
                ]
            ]) ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <i class="ph ph-warning-circle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <i class="ph ph-check-circle me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <?php if (empty($activeExams)): ?>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <div class="mb-4">
                                    <i class="ph ph-exam text-muted" style="font-size: 4rem; opacity: 0.2;"></i>
                                </div>
                                <h5>Tidak Ada Ujian Tersedia</h5>
                                <p class="text-muted">Tidak ada jadwal ujian untuk Anda saat ini.</p>
                                <a href="<?= base_url('siswa/classes') ?>" class="btn btn-primary mt-3">Lihat Kelas</a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($activeExams as $exam): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avtar avtar-s bg-light-primary text-primary me-2">
                                                <i class="ph ph-exam"></i>
                                            </div>
                                            <?php if (empty($exam['class_id'])): ?>
                                                <span class="badge bg-light-warning text-warning border border-warning">Ujian
                                                    Sekolah
                                                    (UTS/UAS)</span>
                                            <?php endif; ?>
                                        </div>
                                        <span class="badge bg-light-success text-success">Aktif</span>
                                    </div>
                                    <h5 class="card-title"><?= esc($exam['exam_name']) ?></h5>
                                    <p class="card-text text-muted small mb-4">
                                        <?= esc($exam['description'] ?: 'Tidak ada deskripsi.') ?>
                                    </p>

                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div class="d-flex align-items-center text-muted small">
                                            <i class="ph ph-clock me-1"></i>
                                            <?= $exam['duration_minutes'] ?> menit
                                        </div>
                                        <div class="d-flex align-items-center text-muted small">
                                            <i class="ph ph-calendar me-1"></i>
                                            <?= date('d M', strtotime($exam['start_time'])) ?>
                                        </div>
                                    </div>

                                    <div class="d-grid">
                                        <a href="<?= base_url('siswa/cbt/start/' . $exam['id']) ?>" class="btn btn-primary">
                                            Mulai Ujian <i class="ph ph-arrow-right ms-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?= view('layouts/footer_js', ['includeCharts' => false]) ?>
</body>

</html>