<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', [
        'pageTitle' => esc($announcement['title']) . ' - Pengumuman',
        'metaDescription' => 'Detail Pengumuman'
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
                'pageTitle' => 'Detail Pengumuman',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'guru/dashboard'],
                    ['label' => 'Kelas', 'url' => 'guru/classes'],
                    ['label' => esc($class['name']), 'url' => 'guru/classes/view/' . $class['id']],
                    ['label' => 'Pengumuman', 'url' => 'guru/classes/announcements/' . $class['id']],
                    ['label' => 'Detail']
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
                    <a href="<?= base_url('guru/classes/announcements/' . $class['id']) ?>" class="btn btn-secondary">
                        <i class="ph ph-arrow-left me-2"></i>Kembali ke Pengumuman
                    </a>
                    <a href="<?= base_url('guru/announcements/edit/' . $announcement['id']) ?>" class="btn btn-primary">
                        <i class="ph ph-pencil me-2"></i>Edit
                    </a>
                    <a href="<?= base_url('guru/announcements/delete/' . $announcement['id']) ?>" class="btn btn-danger"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini dan semua komentarnya?')">
                        <i class="ph ph-trash me-2"></i>Hapus
                    </a>
                </div>
            </div>

            <!-- Announcement Card -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-2"><?= esc($announcement['title']) ?></h4>
                            <div class="text-muted">
                                <i class="ph ph-user me-1"></i>Diposting oleh <?= esc($announcement['author_name']) ?>
                                <span class="mx-2">•</span>
                                <i
                                    class="ph ph-calendar me-1"></i><?= date('d M Y, H:i', strtotime($announcement['created_at'])) ?>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="announcement-content" style="white-space: pre-wrap;">
                                <?= esc($announcement['content']) ?>
                            </div>
                        </div>
                    </div>

                    <!-- Comments Section -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="ph ph-chat-circle me-2"></i>Komentar (<?= count($comments) ?>)
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php if (empty($comments)): ?>
                                <div class="text-center py-4 text-muted">
                                    <i class="ph ph-chat-dots" style="font-size: 3rem; opacity: 0.3;"></i>
                                    <p class="mt-2">Belum ada komentar</p>
                                </div>
                            <?php else: ?>
                                <div class="comments-list">
                                    <?php foreach ($comments as $comment): ?>
                                        <div class="border-bottom pb-3 mb-3">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar avatar-sm bg-light-primary text-primary rounded-circle">
                                                        <span class="text-uppercase">
                                                            <?= substr(esc($comment['full_name']), 0, 1) ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="mb-0">
                                                            <?= esc($comment['full_name']) ?>
                                                            <?php if ($comment['role'] === 'guru'): ?>
                                                                <span class="badge bg-light-success text-success ms-1">Guru</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-light-info text-info ms-1">Siswa</span>
                                                            <?php endif; ?>
                                                        </h6>
                                                        <small class="text-muted">
                                                            <?= date('d M Y, H:i', strtotime($comment['created_at'])) ?>
                                                        </small>
                                                    </div>
                                                    <p class="mb-0 mt-2" style="white-space: pre-wrap;">
                                                        <?= esc($comment['comment']) ?>
                                                    </p>
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

        </div>
    </div>

    <?= view('layouts/footer_js', ['includeCharts' => false]) ?>

</body>

</html>