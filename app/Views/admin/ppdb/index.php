<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Manajemen PPDB']) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>
    <?= view('layouts/sidebar') ?>
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Manajemen PPDB',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'admin/dashboard'],
                    ['label' => 'PPDB']
                ]
            ]) ?>

            <div class="row">
                <!-- Statistics Cards -->
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avtar avtar-s bg-light-primary">
                                        <i class="ph ph-users"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Total Pendaftar</h6>
                                    <h4 class="mb-0"><?= $statistics['total'] ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avtar avtar-s bg-light-warning">
                                        <i class="ph ph-clock"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Menunggu</h6>
                                    <h4 class="mb-0"><?= $statistics['pending'] ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avtar avtar-s bg-light-success">
                                        <i class="ph ph-check-circle"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Diterima</h6>
                                    <h4 class="mb-0"><?= $statistics['approved'] ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avtar avtar-s bg-light-danger">
                                        <i class="ph ph-x-circle"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Ditolak</h6>
                                    <h4 class="mb-0"><?= $statistics['rejected'] ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Table -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5>Daftar Pendaftar</h5>
                                <div>
                                    <a href="<?= base_url('admin/ppdb/export') ?>" class="btn btn-sm btn-success">
                                        <i class="ph ph-download me-1"></i>Ekspor
                                    </a>
                                    <a href="<?= base_url('admin/ppdb/settings') ?>" class="btn btn-sm btn-primary">
                                        <i class="ph ph-gear me-1"></i>Pengaturan
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Flash Messages -->
                            <?php if (session()->getFlashdata('success')): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?= session()->getFlashdata('success') ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <?php if (session()->getFlashdata('error')): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?= session()->getFlashdata('error') ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <!-- Filter -->
                            <div class="mb-3">
                                <a href="<?= base_url('admin/ppdb?status=all') ?>"
                                    class="btn btn-sm <?= $current_status == 'all' ? 'btn-primary' : 'btn-outline-primary' ?>">Semua</a>
                                <a href="<?= base_url('admin/ppdb?status=pending') ?>"
                                    class="btn btn-sm <?= $current_status == 'pending' ? 'btn-warning' : 'btn-outline-warning' ?>">Menunggu</a>
                                <a href="<?= base_url('admin/ppdb?status=verified') ?>"
                                    class="btn btn-sm <?= $current_status == 'verified' ? 'btn-info' : 'btn-outline-info' ?>">Terverifikasi</a>
                                <a href="<?= base_url('admin/ppdb?status=approved') ?>"
                                    class="btn btn-sm <?= $current_status == 'approved' ? 'btn-success' : 'btn-outline-success' ?>">Diterima</a>
                                <a href="<?= base_url('admin/ppdb?status=rejected') ?>"
                                    class="btn btn-sm <?= $current_status == 'rejected' ? 'btn-danger' : 'btn-outline-danger' ?>">Ditolak</a>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No. Reg</th>
                                            <th>Nama Lengkap</th>
                                            <th>Email</th>
                                            <th>No. HP</th>
                                            <th>Status</th>
                                            <th>Tanggal Daftar</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($registrations)): ?>
                                            <tr>
                                                <td colspan="7" class="text-center py-4">
                                                    <i class="ph ph-clipboard-text opacity-25" style="font-size: 3rem;"></i>
                                                    <p class="mt-2 text-muted">Belum ada pendaftar</p>
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($registrations as $reg): ?>
                                                <tr>
                                                    <td><strong><?= esc($reg['registration_number']) ?></strong></td>
                                                    <td><?= esc($reg['full_name']) ?></td>
                                                    <td><?= esc($reg['email']) ?></td>
                                                    <td><?= esc($reg['phone']) ?></td>
                                                    <td>
                                                        <?php
                                                        $badgeClass = [
                                                            'pending' => 'bg-warning',
                                                            'verified' => 'bg-info',
                                                            'approved' => 'bg-success',
                                                            'rejected' => 'bg-danger',
                                                        ];
                                                        $statusLabel = [
                                                            'pending' => 'Menunggu',
                                                            'verified' => 'Terverifikasi',
                                                            'approved' => 'Diterima',
                                                            'rejected' => 'Ditolak',
                                                        ];
                                                        ?>
                                                        <span
                                                            class="badge <?= $badgeClass[$reg['status']] ?? 'bg-secondary' ?>">
                                                            <?= $statusLabel[$reg['status']] ?? ucfirst($reg['status']) ?>
                                                        </span>
                                                    </td>
                                                    <td><?= date('d M Y', strtotime($reg['created_at'])) ?></td>
                                                    <td>
                                                        <a href="<?= base_url('admin/ppdb/view/' . $reg['id']) ?>"
                                                            class="btn btn-sm btn-link-primary" title="Lihat Detail">
                                                            <i class="ph ph-eye"></i>
                                                        </a>
                                                        <a href="<?= base_url('admin/ppdb/delete/' . $reg['id']) ?>"
                                                            class="btn btn-sm btn-link-danger"
                                                            onclick="return confirm('Hapus data pendaftar ini?')" title="Hapus">
                                                            <i class="ph ph-trash"></i>
                                                        </a>
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