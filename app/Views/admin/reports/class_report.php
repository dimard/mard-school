<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', [
        'pageTitle' => 'Laporan Kelas - ' . esc($class['name']),
        'metaDescription' => 'Laporan Nilai Siswa'
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
                ['label' => 'Beranda', 'url' => 'admin/dashboard', 'icon' => 'ph ph-house-line']
            ]
        ],
        [
            'caption' => 'Manajemen',
            'items' => [
                ['label' => 'Kelas', 'url' => 'admin/classes', 'icon' => 'ph ph-chalkboard', 'active' => true],
                ['label' => 'Pengguna', 'url' => 'admin/users', 'icon' => 'ph ph-users'],
                ['label' => 'Berita', 'url' => 'admin/news', 'icon' => 'ph ph-newspaper']
            ]
        ]
    ];
    ?>

    <?= view('layouts/sidebar', ['menuItems' => $menuItems, 'homeUrl' => 'admin/dashboard']) ?>
    <?= view('layouts/topbar', ['notificationCount' => 0, 'notifications' => [], 'profileUrl' => 'admin/profile']) ?>

    <div class="pc-container">
        <div class="pc-content">

            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Laporan Kelas',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'admin/dashboard'],
                    ['label' => 'Kelas', 'url' => 'admin/classes'],
                    ['label' => esc($class['name']), 'url' => 'admin/classes/view/' . $class['id']],
                    ['label' => 'Laporan']
                ]
            ]) ?>

            <div class="row mb-3">
                <div class="col-12">
                    <a href="<?= base_url('admin/classes/view/' . $class['id']) ?>" class="btn btn-secondary">
                        <i class="ph ph-arrow-left me-2"></i>Kembali ke Kelas
                    </a>
                </div>
            </div>

            <!-- Class Statistics -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <i class="ph ph-users-three" style="font-size: 2.5rem; opacity: 0.7;"></i>
                                <div class="ms-3">
                                    <h6 class="mb-0 text-white">Total Siswa</h6>
                                    <h3 class="mb-0 text-white"><?= $statistics['total_students'] ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <i class="ph ph-trophy" style="font-size: 2.5rem; opacity: 0.7;"></i>
                                <div class="ms-3">
                                    <h6 class="mb-0 text-white">Nilai Tertinggi</h6>
                                    <h3 class="mb-0 text-white"><?= number_format($statistics['highest_score'], 2) ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <i class="ph ph-chart-line" style="font-size: 2.5rem; opacity: 0.7;"></i>
                                <div class="ms-3">
                                    <h6 class="mb-0 text-white">Rata-rata Kelas</h6>
                                    <h3 class="mb-0 text-white"><?= number_format($statistics['class_average'], 2) ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-dark">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <i class="ph ph-trend-down" style="font-size: 2.5rem; opacity: 0.7;"></i>
                                <div class="ms-3">
                                    <h6 class="mb-0">Nilai Terendah</h6>
                                    <h3 class="mb-0"><?= number_format($statistics['lowest_score'], 2) ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Student Grades Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="ph ph-chart-bar me-2"></i>Nilai & Peringkat Siswa
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php if (empty($report)): ?>
                                <div class="text-center py-5">
                                    <i class="ph ph-users text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                                    <h5 class="mt-3 text-muted">Tidak Ada Siswa di Kelas</h5>
                                    <p class="text-muted">Siswa perlu bergabung dengan kelas ini terlebih dahulu</p>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Peringkat</th>
                                                <th>NIS</th>
                                                <th>Nama Siswa</th>
                                                <th class="text-center">Rata-rata CBT</th>
                                                <th class="text-center">Rata-rata Tugas</th>
                                                <th class="text-center">Rata-rata Gabungan</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($report as $student): ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <?php if ($student['rank'] <= 3): ?>
                                                            <span class="badge bg-warning text-dark">
                                                                <i class="ph ph-medal"></i> #<?= $student['rank'] ?>
                                                            </span>
                                                        <?php else: ?>
                                                            <strong><?= $student['rank'] ?></strong>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= esc($student['nis']) ?></td>
                                                    <td>
                                                        <strong><?= esc($student['full_name']) ?></strong>
                                                        <br>
                                                        <small class="text-muted">
                                                            <?= $student['cbt_count'] ?> CBT •
                                                            <?= $student['assignment_count'] ?> Tugas
                                                        </small>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-light-primary text-primary">
                                                            <?= number_format($student['cbt_average'], 2) ?>
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-light-info text-info">
                                                            <?= number_format($student['assignment_average'], 2) ?>
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <strong class="fs-5">
                                                            <?= number_format($student['combined_average'], 2) ?>
                                                        </strong>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if ($student['combined_average'] >= 75): ?>
                                                            <span class="badge bg-success">Sangat Baik</span>
                                                        <?php elseif ($student['combined_average'] >= 60): ?>
                                                            <span class="badge bg-info">Baik</span>
                                                        <?php elseif ($student['combined_average'] >= 50): ?>
                                                            <span class="badge bg-warning">Cukup</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-danger">Perlu Perbaikan</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-4 text-muted">
                                    <p class="mb-1"><strong>Catatan:</strong></p>
                                    <ul class="mb-0">
                                        <li>Rata-rata Gabungan = (Rata-rata CBT + Rata-rata Tugas) / 2</li>
                                        <li>Siswa diberi peringkat berdasarkan nilai Rata-rata Gabungan</li>
                                        <li>Hanya ujian CBT yang selesai dan tugas yang dinilai yang dihitung</li>
                                    </ul>
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