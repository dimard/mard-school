<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => esc($subClass['subject_name'])]) ?>
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
                'pageTitle' => esc($subClass['subject_name']),
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'siswa/dashboard'],
                    ['label' => 'Kelas Saya', 'url' => 'siswa/classes'],
                    ['label' => esc($subClass['class_name']), 'url' => 'siswa/classes/view/' . $subClass['class_id']],
                    ['label' => esc($subClass['subject_name'])]
                ]
            ]) ?>

            <!-- Sub Class Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-primary text-white">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="text-white mb-2"><?= esc($subClass['subject_name']) ?></h2>
                                    <p class="text-white-50 mb-0"><?= esc($subClass['description']) ?></p>
                                    <div class="mt-3">
                                        <span class="text-white">
                                            <i class="ph ph-user me-1"></i>Guru:
                                            <strong><?= esc($subClass['teacher_name']) ?></strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-none d-md-block">
                                    <i class="ph ph-books" style="font-size: 5rem; opacity: 0.2;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Tabs -->
                <div class="col-12">
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link <?= $tab == 'stream' ? 'active' : '' ?>"
                                href="<?= current_url() ?>?tab=stream">
                                <i class="ph ph-chats-circle me-1"></i>Aktivitas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $tab == 'assignments' ? 'active' : '' ?>"
                                href="<?= current_url() ?>?tab=assignments">
                                <i class="ph ph-file-text me-1"></i>Tugas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $tab == 'materials' ? 'active' : '' ?>"
                                href="<?= current_url() ?>?tab=materials">
                                <i class="ph ph-book-open me-1"></i>Materi
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- Stream Tab -->
                        <?php if ($tab == 'stream'): ?>
                            <div class="tab-pane show active">
                                <?php if (empty($announcements)): ?>
                                    <div class="card">
                                        <div class="card-body text-center py-5">
                                            <i class="ph ph-chats-circle text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                                            <h5 class="mt-3 text-muted">Belum Ada Pengumuman</h5>
                                            <p class="text-muted">Belum ada pengumuman.</p>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <?php foreach ($announcements as $announcement): ?>
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <h5 class="mb-1"><?= esc($announcement['title']) ?></h5>
                                                    <small
                                                        class="text-muted"><?= date('M d, Y', strtotime($announcement['created_at'])) ?></small>
                                                </div>
                                                <p class="text-muted small mb-2">
                                                    <i class="ph ph-user me-1"></i><?= esc($announcement['author_name']) ?>
                                                </p>
                                                <p class="mb-3"><?= nl2br(esc($announcement['content'])) ?></p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="text-muted small">
                                                        <i class="ph ph-chat-circle me-1"></i><?= $announcement['comment_count'] ?>
                                                        comments
                                                    </span>
                                                    <a href="<?= base_url('siswa/announcements/view/' . $announcement['id']) ?>"
                                                        class="btn btn-sm btn-light-primary">
                                                        Lihat Detail
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Assignments Tab -->
                        <?php if ($tab == 'assignments'): ?>
                            <div class="tab-pane show active">
                                <?php if (empty($assignments)): ?>
                                    <div class="card">
                                        <div class="card-body text-center py-5">
                                            <i class="ph ph-file-text text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                                            <h5 class="mt-3 text-muted">Tidak Ada Tugas</h5>
                                            <p class="text-muted">Belum ada tugas yang diposting.</p>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="row">
                                        <?php foreach ($assignments as $assignment): ?>
                                            <div class="col-md-6 mb-3">
                                                <div class="card h-100">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                            <h5 class="mb-1"><?= esc($assignment['title']) ?></h5>
                                                            <?php if (strtotime($assignment['deadline']) < time()): ?>
                                                                <span class="badge bg-danger">Tutup</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-success">Buka</span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <p class="text-muted small mb-2"><?= esc($assignment['description']) ?></p>
                                                        <div
                                                            class="d-flex justify-content-between align-items-center text-muted small mb-3">
                                                            <span><i class="ph ph-clock me-1"></i>Due:
                                                                <?= date('M d, Y', strtotime($assignment['deadline'])) ?></span>
                                                            <span><i class="ph ph-trophy me-1"></i><?= $assignment['max_score'] ?>
                                                                pts</span>
                                                        </div>
                                                        <div class="d-grid">
                                                            <a href="<?= base_url('siswa/assignments/view/' . $assignment['id']) ?>"
                                                                class="btn btn-sm btn-primary">
                                                                Lihat Tugas
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Materials Tab -->
                        <?php if ($tab == 'materials'): ?>
                            <div class="tab-pane show active">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Materi Pelajaran</h5>
                                    </div>
                                    <div class="card-body">
                                        <?php if (empty($materials)): ?>
                                            <div class="text-center py-4 text-muted">
                                                <i class="ph ph-folder-open mb-2" style="font-size: 2rem;"></i>
                                                <p>Belum ada materi yang diunggah.</p>
                                            </div>
                                        <?php else: ?>
                                            <div class="list-group list-group-flush">
                                                <?php foreach ($materials as $material): ?>
                                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6 class="mb-1"><?= esc($material['title']) ?></h6>
                                                            <small class="text-muted"><?= esc($material['description']) ?></small>
                                                        </div>
                                                        <a href="<?= base_url('siswa/materials/download/' . $material['id']) ?>"
                                                            class="btn btn-sm btn-light-primary">
                                                            <i class="ph ph-download me-1"></i> Unduh
                                                        </a>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= view('layouts/footer_js', ['includeCharts' => false]) ?>
</body>

</html>