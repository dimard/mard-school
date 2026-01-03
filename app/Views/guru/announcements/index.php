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

    <?= view('layouts/sidebar', ['menuItems' => $menuItems, 'homeUrl' => 'guru/dashboard']) ?>
    <?= view('layouts/topbar', ['notificationCount' => 0, 'notifications' => [], 'profileUrl' => 'guru/profile']) ?>

    <div class="pc-container">
        <div class="pc-content">

            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Pengumuman',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'guru/dashboard'],
                    ['label' => 'Kelas', 'url' => 'guru/classes'],
                    ['label' => esc($class['name']), 'url' => 'guru/classes/view/' . $class['id']],
                    ['label' => 'Pengumuman']
                ]
            ]) ?>

            <?php if (session()->getFlashdata('message')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="ph ph-check-circle me-2"></i><?= session()->getFlashdata('message') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row mb-3">
                <div class="col-12">
                    <a href="<?= base_url('guru/classes/announcements/' . $class['id'] . '/create') ?>"
                        class="btn btn-primary">
                        <i class="ph ph-plus-circle me-2"></i>Buat Pengumuman
                    </a>
                    <a href="<?= base_url('guru/classes/view/' . $class['id']) ?>" class="btn btn-secondary">
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
                                <p class="text-muted">Buat pengumuman pertama Anda untuk berkomunikasi dengan siswa</p>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($announcements as $announcement): ?>
                            <div class="card mb-3">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h5 class="mb-1"><?= esc($announcement['title']) ?></h5>
                                            <small class="text-muted">
                                                Diposting oleh <?= esc($announcement['author_name']) ?> •
                                                <?= date('d M Y, H:i', strtotime($announcement['created_at'])) ?>
                                            </small>
                                        </div>
                                        <div class="btn-group">
                                            <a href="<?= base_url('guru/announcements/edit/' . $announcement['id']) ?>"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="ph ph-pencil"></i>
                                            </a>
                                            <a href="<?= base_url('guru/announcements/delete/' . $announcement['id']) ?>"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')">
                                                <i class="ph ph-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="mb-3"><?= nl2br(esc($announcement['content'])) ?></p>
                                    <div class="d-flex align-items-center text-muted">
                                        <i class="ph ph-chat-circle me-1"></i>
                                        <small><?= $announcement['comment_count'] ?>
                                            komentar</small>
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