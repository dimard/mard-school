<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Kelas Saya']) ?>
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
                    'icon' => 'ph ph-chalkboard',
                    'active' => true
                ],
                [
                    'label' => 'Ujian CBT',
                    'url' => 'siswa/cbt',
                    'icon' => 'ph ph-laptop'
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
                'pageTitle' => 'Kelas Saya',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'siswa/dashboard'],
                    ['label' => 'Kelas Saya']
                ]
            ]) ?>

            <?php if (session()->getFlashdata('message')): ?>
                <div class="alert alert-success alert-dismissible fade show"><i
                        class="ph ph-check-circle me-2"></i><?= session()->getFlashdata('message') ?><button type="button"
                        class="btn-close" data-bs-dismiss="alert"></button></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show"><i
                        class="ph ph-warning me-2"></i><?= session()->getFlashdata('error') ?><button type="button"
                        class="btn-close" data-bs-dismiss="alert"></button></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('info')): ?>
                <div class="alert alert-info alert-dismissible fade show"><i
                        class="ph ph-info me-2"></i><?= session()->getFlashdata('info') ?><button type="button"
                        class="btn-close" data-bs-dismiss="alert"></button></div>
            <?php endif; ?>

            <!-- Join Class Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-primary text-white pattern-0">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h4 class="text-white mb-3">Gabung Kelas Baru</h4>
                                    <form action="<?= base_url('siswa/classes/join') ?>" method="post" class="row g-3">
                                        <?= csrf_field() ?>
                                        <div class="col-md-8">
                                            <input type="text" name="code" class="form-control"
                                                placeholder="Masukkan kode kelas (contoh: XY72K9)" required>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-dark w-100">
                                                <i class="ph ph-sign-in me-2"></i>Gabung Kelas
                                            </button>
                                        </div>
                                    </form>
                                    <small class="text-white-50 mt-2 d-block">Minta kode kelas kepada guru Anda.</small>
                                </div>
                                <div class="col-md-4 text-center d-none d-md-block">
                                    <i class="ph ph-chalkboard-teacher" style="font-size: 6rem; opacity: 0.3;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enrolled Classes Grid -->
            <div class="row">
                <?php if (empty($classes)): ?>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <div class="mb-4">
                                    <i class="ph ph-books text-muted" style="font-size: 4rem; opacity: 0.2;"></i>
                                </div>
                                <h5>Belum Ada Kelas</h5>
                                <p class="text-muted">Anda belum bergabung dengan kelas manapun. Masukkan kode di atas untuk
                                    memulai!</p>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($classes as $class): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100">
                                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="text-white mb-1 text-truncate" style="max-width: 200px;">
                                            <?= esc($class['name']) ?>
                                        </h5>
                                        <small class="text-white-50"><i class="ph ph-user me-1"></i>
                                            <?= esc($class['teacher_name']) ?></small>
                                    </div>
                                    <div class="dropdown">
                                        <a href="#" class="text-white-50" data-bs-toggle="dropdown"><i
                                                class="ph ph-dots-three-vertical"></i></a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item"
                                                href="<?= base_url('siswa/classes/view/' . $class['id']) ?>">Lihat Detail</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="card-text text-muted small text-truncate-3 mb-4" style="min-height: 4.5em;">
                                        <?= esc($class['description'] ?: 'Tidak ada deskripsi untuk kelas ini.') ?>
                                    </p>
                                    <div class="d-grid">
                                        <a href="<?= base_url('siswa/classes/view/' . $class['id']) ?>"
                                            class="btn btn-outline-primary">
                                            Masuk Kelas <i class="ph ph-arrow-right ms-2"></i>
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