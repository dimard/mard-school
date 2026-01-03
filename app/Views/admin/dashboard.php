<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', [
        'pageTitle' => 'Admin Dashboard',
        'metaDescription' => 'School Management System - Admin Dashboard'
    ]) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">

    <?= view('layouts/loader') ?>

    <?php
    // Menu items are handled centrally in layouts/sidebar.php
    ?>

    <?= view('layouts/sidebar', [
        'homeUrl' => 'admin/dashboard'
    ]) ?>

    <?= view('layouts/topbar', [
        'notificationCount' => 0,
        'notifications' => [],
        'profileUrl' => 'admin/profile',
        'settingsUrl' => 'admin/settings'
    ]) ?>

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">

            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Statistik Dashboard',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'admin/dashboard'],
                    ['label' => 'Dashboard']
                ]
            ]) ?>

            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- Statistics Cards -->
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-4">Total Siswa</h6>
                            <div class="row d-flex align-items-center">
                                <div class="col-9">
                                    <h3 class="f-w-300 d-flex align-items-center m-b-0">
                                        <i class="ph ph-arrow-up text-success f-30 m-r-10"></i>
                                        <?= $totalSiswa ?? 0 ?>
                                    </h3>
                                </div>
                                <div class="col-3 text-end">
                                    <i class="ph ph-student text-primary f-40"></i>
                                </div>
                            </div>
                            <div class="progress m-t-30" style="height: 7px">
                                <div class="progress-bar bg-brand-color-1" role="progressbar" style="width: 85%"
                                    aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-4">Hadir Hari Ini</h6>
                            <div class="row d-flex align-items-center">
                                <div class="col-9">
                                    <h3 class="f-w-300 d-flex align-items-center m-b-0">
                                        <i class="ph ph-check-circle text-success f-30 m-r-10"></i>
                                        <?= $todayAttendance ?? 0 ?>
                                    </h3>
                                </div>
                                <div class="col-3 text-end">
                                    <i class="ph ph-clipboard-text text-success f-40"></i>
                                </div>
                            </div>
                            <div class="progress m-t-30" style="height: 7px">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 70%"
                                    aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-4">Ujian Aktif</h6>
                            <div class="row d-flex align-items-center">
                                <div class="col-9">
                                    <h3 class="f-w-300 d-flex align-items-center m-b-0">
                                        <i class="ph ph-exam text-warning f-30 m-r-10"></i>
                                        <?= $activeExams ?? 0 ?>
                                    </h3>
                                </div>
                                <div class="col-3 text-end">
                                    <i class="ph ph-desktop text-warning f-40"></i>
                                </div>
                            </div>
                            <div class="progress m-t-30" style="height: 7px">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 45%"
                                    aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-4">Total Berita</h6>
                            <div class="row d-flex align-items-center">
                                <div class="col-9">
                                    <h3 class="f-w-300 d-flex align-items-center m-b-0">
                                        <i class="ph ph-newspaper text-info f-30 m-r-10"></i>
                                        <?= $totalBerita ?? 0 ?>
                                    </h3>
                                </div>
                                <div class="col-3 text-end">
                                    <i class="ph ph-article text-info f-40"></i>
                                </div>
                            </div>
                            <div class="progress m-t-30" style="height: 7px">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 60%"
                                    aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent News & Quick Actions -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5>Berita Terbaru</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>Judul</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($recentNews) && !empty($recentNews)): ?>
                                            <?php foreach ($recentNews as $news): ?>
                                                <tr>
                                                    <td><?= esc($news['title']) ?></td>
                                                    <td><?= date('d M Y', strtotime($news['created_at'])) ?></td>
                                                    <td><span class="badge bg-success">Published</span></td>
                                                    <td>
                                                        <a href="<?= base_url('admin/news/edit/' . $news['id']) ?>"
                                                            class="btn btn-sm btn-link-primary">
                                                            <i class="ph ph-pencil"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">Tidak ada berita tersedia
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Aksi Cepat</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="<?= base_url('admin/news/create') ?>" class="btn btn-outline-primary">
                                    <i class="ph ph-plus me-2"></i> Buat Berita Baru
                                </a>
                                <a href="<?= base_url('admin/classes/create') ?>" class="btn btn-outline-info">
                                    <i class="ph ph-chalkboard me-2"></i> Buat Kelas
                                </a>
                                <a href="<?= base_url('admin/cbt/create') ?>" class="btn btn-outline-warning">
                                    <i class="ph ph-plus me-2"></i> Buat Ujian
                                </a>
                                <a href="<?= base_url('admin/students/add') ?>" class="btn btn-outline-success">
                                    <i class="ph ph-user-plus me-2"></i> Tambah Siswa
                                </a>
                                <a href="<?= base_url('admin/users/create') ?>" class="btn btn-outline-secondary">
                                    <i class="ph ph-users-three me-2"></i> Tambah Pengguna
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->

        </div>
    </div>
    <!-- [ Main Content ] end -->

    <?= view('layouts/footer_js', ['includeCharts' => false]) ?>

</body>

</html>