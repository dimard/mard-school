<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Tugas - ' . esc($class['name'])]) ?>
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
                ['label' => 'Kelas Saya', 'url' => 'siswa/classes', 'icon' => 'ph ph-chalkboard', 'active' => true],
                ['label' => 'Ujian CBT', 'url' => 'siswa/cbt', 'icon' => 'ph ph-laptop'],
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
            <?= view('layouts/breadcrumb', ['pageTitle' => 'Tugas', 'breadcrumbs' => [['label' => 'Beranda', 'url' => 'siswa/dashboard'], ['label' => 'Kelas', 'url' => 'siswa/classes'], ['label' => esc($class['name']), 'url' => 'siswa/classes/view/' . $class['id']], ['label' => 'Tugas']]]) ?>

            <div class="row mb-3">
                <div class="col-12">
                    <a href="<?= base_url('siswa/classes/view/' . $class['id']) ?>" class="btn btn-secondary">
                        <i class="ph ph-arrow-left me-2"></i>Kembali ke Kelas
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <?php if (empty($assignments)): ?>
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <i class="ph ph-file-text text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                                <h5 class="mt-3 text-muted">Belum Ada Tugas</h5>
                                <p class="text-muted">Guru Anda belum memposting tugas apapun.</p>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="row">
                            <?php foreach ($assignments as $assignment): ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0 text-truncate" title="<?= esc($assignment['title']) ?>">
                                                <?= esc($assignment['title']) ?>
                                            </h5>
                                            <?php if ($assignment['submitted']): ?>
                                                <span class="badge bg-success">Dikumpulkan</span>
                                            <?php elseif ($assignment['is_late']): ?>
                                                <span class="badge bg-danger">Terlewat</span>
                                            <?php else: ?>
                                                <span class="badge bg-primary">Ditugaskan</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-body">
                                            <p class="text-muted small mb-3">
                                                <i class="ph ph-calendar me-1"></i> Tenggat:
                                                <?= date('d M Y, H:i', strtotime($assignment['deadline'])) ?>
                                            </p>
                                            <p class="card-text text-truncate-3">
                                                <?= esc(mb_substr($assignment['description'], 0, 100)) ?>...
                                            </p>
                                        </div>
                                        <div class="card-footer bg-light-secondary border-top-0">
                                            <div class="d-grid">
                                                <a href="<?= base_url('siswa/assignments/view/' . $assignment['id']) ?>"
                                                    class="btn btn-primary">
                                                    Lihat & Kumpulkan
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?= view('layouts/footer_js', ['includeCharts' => false]) ?>
</body>

</html>