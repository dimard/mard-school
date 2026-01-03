<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', [
        'pageTitle' => esc($announcement['title']),
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
                'pageTitle' => esc($announcement['title']),
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'siswa/dashboard'],
                    ['label' => 'Kelas', 'url' => 'siswa/classes'],
                    ['label' => esc($class['name']), 'url' => 'siswa/classes/view/' . $class['id']],
                    ['label' => 'Pengumuman', 'url' => 'siswa/classes/' . $class['id'] . '/announcements'],
                    ['label' => 'Detail']
                ]
            ]) ?>

            <?php if (session()->getFlashdata('message')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="ph ph-check-circle me-2"></i><?= session()->getFlashdata('message') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="ph ph-warning me-2"></i><?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Announcement Content -->
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card mb-3">
                        <div class="card-header bg-primary">
                            <h4 class="text-white mb-2"><?= esc($announcement['title']) ?></h4>
                            <small class="text-white-50">
                                <i class="ph ph-user-circle me-1"></i> <?= esc($announcement['author_name']) ?>
                                <span class="mx-2">•</span>
                                <i class="ph ph-clock me-1"></i>
                                <?= date('d M Y, H:i', strtotime($announcement['created_at'])) ?>
                            </small>
                        </div>
                        <div class="card-body">
                            <div class="announcement-content">
                                <?= nl2br(esc($announcement['content'])) ?>
                            </div>
                        </div>
                    </div>

                    <!-- Comments Section -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="ph ph-chat-circle me-2"></i>Komentar (<?= count($comments) ?>)
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Add Comment Form -->
                            <form action="<?= base_url('siswa/announcements/' . $announcement['id'] . '/comment') ?>"
                                method="POST" class="mb-4">
                                <?= csrf_field() ?>
                                <div class="mb-3">
                                    <label for="comment" class="form-label">Tambahkan komentar</label>
                                    <textarea class="form-control" id="comment" name="comment" rows="3"
                                        placeholder="Tulis komentar Anda di sini..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ph ph-paper-plane-right me-2"></i>Kirim Komentar
                                </button>
                            </form>

                            <hr>

                            <!-- Comments List -->
                            <?php if (empty($comments)): ?>
                                <div class="text-center py-4">
                                    <i class="ph ph-chat-circle-dots text-muted" style="font-size: 3rem; opacity: 0.3;"></i>
                                    <p class="text-muted mt-2 mb-0">Belum ada komentar. Jadilah yang pertama berkomentar!
                                    </p>
                                </div>
                            <?php else: ?>
                                <div class="comments-list">
                                    <?php foreach ($comments as $comment): ?>
                                        <div class="comment mb-3 pb-3 border-bottom">
                                            <div class="d-flex align-items-start">
                                                <div class="avtar avtar-s btn-light-primary me-3 flex-shrink-0">
                                                    <i class="ph ph-user"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="mb-1">
                                                        <strong><?= esc($comment['full_name']) ?></strong>
                                                        <span
                                                            class="badge bg-light-<?= $comment['role'] == 'guru' ? 'success' : 'info' ?> ms-2">
                                                            <?= ucfirst($comment['role']) ?>
                                                        </span>
                                                    </div>
                                                    <p class="mb-1"><?= nl2br(esc($comment['comment'])) ?></p>
                                                    <small class="text-muted">
                                                        <i class="ph ph-clock me-1"></i>
                                                        <?= date('d M Y, H:i', strtotime($comment['created_at'])) ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="<?= base_url('siswa/classes/' . $class['id'] . '/announcements') ?>"
                            class="btn btn-secondary">
                            <i class="ph ph-arrow-left me-2"></i>Kembali ke Pengumuman
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?= view('layouts/footer_js', ['includeCharts' => false]) ?>

</body>

</html>