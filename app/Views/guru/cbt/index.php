<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Kelola Ujian']) ?>
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
                ['label' => 'Kelas Saya', 'url' => 'guru/classes', 'icon' => 'ph ph-chalkboard'],
                ['label' => 'Materi', 'url' => 'guru/materials', 'icon' => 'ph ph-book-open-text'],
                ['label' => 'Ujian CBT', 'url' => 'guru/cbt', 'icon' => 'ph ph-laptop', 'active' => true],
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
    <?= view('layouts/sidebar', [
        'menuItems' => $menuItems,
        'homeUrl' => 'guru/dashboard'
    ]) ?>
    <?= view('layouts/topbar', ['notificationCount' => 0, 'notifications' => [], 'profileUrl' => 'guru/profile']) ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Ujian CBT',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'guru/dashboard'],
                    ['label' => 'Ujian CBT']
                ]
            ]) ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Daftar Ujian</h5>
                            <a href="<?= base_url('guru/cbt/create') ?>"
                                class="btn btn-primary d-inline-flex align-items-center">
                                <i class="ti ti-plus me-1"></i> Buat Ujian Baru
                            </a>
                        </div>
                        <div class="card-body">
                            <?php if (session()->getFlashdata('message')): ?>
                                <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
                            <?php endif; ?>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Ujian</th>
                                            <th>Kelas</th>
                                            <th>Durasi</th>
                                            <th>Waktu Mulai</th>
                                            <th>Status</th>
                                            <th>Soal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($exams as $index => $exam): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td>
                                                    <div class="fw-bold"><?= esc($exam['exam_name']) ?></div>
                                                    <small class="text-muted"><?= esc($exam['description']) ?></small>
                                                </td>
                                                <td>
                                                    <!-- Fetch class name if possible, for now ID -->
                                                    Class ID: <?= esc($exam['class_id']) ?>
                                                </td>
                                                <td><?= esc($exam['duration_minutes']) ?> menit</td>
                                                <td><?= esc($exam['start_time']) ?></td>
                                                <td>
                                                    <a href="<?= base_url('guru/cbt/toggle/' . $exam['id']) ?>"
                                                        class="badge bg-<?= $exam['is_active'] ? 'success' : 'danger' ?> text-decoration-none"
                                                        onclick="return confirm('Apakah Anda yakin ingin mengubah status?')">
                                                        <?= $exam['is_active'] ? 'Aktif' : 'Draft' ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-secondary"><?= esc($exam['total_questions']) ?></span>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="<?= base_url('guru/cbt/' . $exam['id'] . '/questions') ?>"
                                                            class="btn btn-info" title="Kelola Soal">
                                                            <i class="ph ph-list-numbers"></i>
                                                        </a>
                                                        <a href="<?= base_url('guru/cbt/edit/' . $exam['id']) ?>"
                                                            class="btn btn-warning" title="Edit Ujian">
                                                            <i class="ph ph-pencil"></i>
                                                        </a>
                                                        <a href="<?= base_url('guru/cbt/delete/' . $exam['id']) ?>"
                                                            class="btn btn-danger"
                                                            onclick="return confirm('Hapus ujian ini?')" title="Hapus">
                                                            <i class="ph ph-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php if (empty($exams)): ?>
                                            <tr>
                                                <td colspan="8" class="text-center py-4 text-muted">Belum ada ujian. Klik
                                                    "Buat Ujian Baru" untuk memulai.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
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