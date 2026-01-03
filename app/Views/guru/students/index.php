<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Siswa Saya']) ?>
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
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Siswa Saya',
                'breadcrumbs' => [
                    ['label' => 'Dashboard', 'url' => 'guru/dashboard'],
                    ['label' => 'Siswa']
                ]
            ]) ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Direktori Siswa</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>Info Siswa</th>
                                            <th>Kontak</th>
                                            <th>Kelas</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($students)): ?>
                                            <tr>
                                                <td colspan="4" class="text-center py-5 text-muted">
                                                    <i class="ph ph-student opacity-25" style="font-size: 3rem;"></i>
                                                    <p class="mt-2">Belum ada siswa yang ditugaskan kepada Anda.</p>
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($students as $student): ?>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avtar avtar-s btn-light-primary rounded-circle me-3">
                                                                <i class="ph ph-user"></i>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0 fw-bold"><?= esc($student['full_name']) ?></h6>
                                                                <small class="text-muted">NIS:
                                                                    <?= esc($student['nis'] ?? '-') ?></small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="small">
                                                            <div class="mb-1"><i
                                                                    class="ph ph-envelope me-2 text-muted"></i><?= esc($student['email']) ?>
                                                            </div>
                                                            <div><i
                                                                    class="ph ph-phone me-2 text-muted"></i><?= esc($student['phone'] ?? '-') ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light-info text-info rounded-pill">
                                                            <?= esc($student['kelas'] ?? 'Belum Masuk Kelas') ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?php if ($student['is_active']): ?>
                                                            <span class="badge bg-success rounded-pill">Aktif</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-danger rounded-pill">Tidak Aktif</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
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

    <?= view('layouts/footer_js') ?>
</body>

</html>