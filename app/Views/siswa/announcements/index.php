<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', [
        'pageTitle' => 'Pengumuman - ' . esc($class['name']),
        'metaDescription' => 'Pengumuman Kelas'
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

            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Pengumuman',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'siswa/dashboard'],
                    ['label' => 'Kelas', 'url' => 'siswa/classes'],
                    ['label' => esc($class['name']), 'url' => 'siswa/classes/view/' . $class['id']],
                    ['label' => 'Pengumuman']
                ]
            ]) ?>

            <div class="row mb-3">
                <div class="col-12">
                    <a href="<?= base_url('siswa/classes/view/' . $class['id']) ?>" class="btn btn-secondary">
                        <i class="ph ph-arrow-left me-2"></i>Kembali ke Kelas
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <?php if (empty($announcements)): ?>
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <i class="ph ph-megaphone text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                                <h5 class="mt-3 text-muted">Belum Ada Pengumuman</h5>
                                <p class="text-muted">Guru Anda belum memposting pengumuman apapun</p>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($announcements as $announcement): ?>
                            <div class="card mb-3">
                                <div class="card-header bg-primary">
                                    <h5 class="text-white mb-1"><?= esc($announcement['title']) ?></h5>
                                    <small class="text-white-50">
                                        Diposting oleh <?= esc($announcement['author_name']) ?> •
                                        <?= date('d M Y, H:i', strtotime($announcement['created_at'])) ?>
                                    </small>
                                </div>
                                <div class="card-body">
                                    <p class="mb-3"><?= nl2br(esc($announcement['content'])) ?></p>

                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center text-muted">
                                            <i class="ph ph-chat-circle me-1"></i>
                                            <small><?= $announcement['comment_count'] ?>
                                                komentar</small>
                                        </div>
                                        class="btn btn-sm btn-primary">
                                        <i class="ph ph-eye me-1"></i> Lihat & Komentar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

    <?= view('layouts/footer_js', ['includeCharts' => false]) ?>

</body>

</html>