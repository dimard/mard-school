<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Materi Pelajaran']) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>
    <?php
    // Define siswa menu items based on dashboard (redundancy could be reduced by a centralized menu config or helper)
    // For now assuming sidebar view handles menu generation or we pass it if needed. 
    // Looking at dashboard.php, menuItems are defined there. Ideally sidebar should handle it or it should be shared.
    // However, sidebar view usually expects menuItems if it's dynamic.
    // Let's check how sidebar is implemented. The dashboard passes menuItems. 
    // I will copy the menuItems structure from dashboard.php for consistency if sidebar requires it.
    
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
                    'icon' => 'ph ph-laptop'
                ],
                [
                    'label' => 'Materi Pelajaran',
                    'url' => 'siswa/materials',
                    'icon' => 'ph ph-book-open-text',
                    'active' => true
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
    <?= view('layouts/sidebar', ['menuItems' => $menuItems]) ?>
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Materi Pelajaran',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'siswa/dashboard'],
                    ['label' => 'Materi', 'active' => true]
                ]
            ]) ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Semua Materi Pelajaran</h5>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($materials)): ?>
                                <div class="row g-4">
                                    <?php foreach ($materials as $item): ?>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="card h-100 border material-card">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-start justify-content-between mb-3">
                                                        <div class="fs-1 text-primary">
                                                            <?php if (strpos($item['file_path'], '.pdf') !== false): ?>
                                                                <i class="ph ph-file-pdf"></i>
                                                            <?php elseif (strpos($item['file_path'], '.doc') !== false): ?>
                                                                <i class="ph ph-file-doc"></i>
                                                            <?php else: ?>
                                                                <i class="ph ph-file-text"></i>
                                                            <?php endif; ?>
                                                        </div>
                                                        <span class="badge bg-light-secondary text-secondary">
                                                            <?= date('d M Y', strtotime($item['created_at'])) ?>
                                                        </span>
                                                    </div>
                                                    <h5 class="card-title"><?= esc($item['title']) ?></h5>
                                                    <p class="card-text text-muted small"><?= esc($item['description']) ?></p>
                                                    <div class="mt-3">
                                                        <small class="text-muted d-block mb-1">Kelas:
                                                            <?= esc($item['class_name'] ?? '-') ?></small>
                                                        <small class="text-muted d-block">Guru:
                                                            <?= esc($item['teacher_name'] ?? '-') ?></small>
                                                    </div>
                                                </div>
                                                <div class="card-footer bg-light border-top-0">
                                                    <a href="<?= base_url('siswa/materials/download/' . $item['id']) ?>"
                                                        class="btn btn-sm btn-outline-primary w-100">
                                                        <i class="ph ph-download me-1"></i> Unduh File
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-5 text-muted">
                                    <i class="ph ph-folder-open opacity-25" style="font-size: 3rem;"></i>
                                    <p class="mt-2">Belum ada materi pelajaran yang dibagikan.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= view('layouts/footer_js') ?>
</body>

</html>