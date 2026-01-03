<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', [
        'pageTitle' => 'Manajemen Staf',
        'metaDescription' => 'Kelola Anggota Staf'
    ]) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">

    <?= view('layouts/loader') ?>

    <?php
    // Menu items are handled centrally in layouts/sidebar.php
    ?>

    <?= view('layouts/sidebar', ['homeUrl' => 'admin/dashboard']) ?>
    <?= view('layouts/topbar', ['notificationCount' => 0, 'notifications' => [], 'profileUrl' => 'admin/profile']) ?>

    <div class="pc-container">
        <div class="pc-content">

            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Manajemen Staf',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'admin/dashboard'],
                    ['label' => 'Manajemen Staf']
                ]
            ]) ?>

            <?php if (session()->getFlashdata('message')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="ph ph-check-circle me-2"></i>
                    <?= session()->getFlashdata('message') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="ph ph-x-circle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Staff Card -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">Anggota Staf</h5>
                            <small class="text-muted">Kelola anggota tim Anda yang ditampilkan di beranda</small>
                        </div>
                        <a href="<?= base_url('admin/staff/create') ?>" class="btn btn-primary">
                            <i class="ph ph-plus me-2"></i>Tambah Staf Baru
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (empty($staff)): ?>
                        <div class="text-center py-5">
                            <i class="ph ph-users-three" style="font-size: 64px; color: #ccc;"></i>
                            <p class="text-muted mt-3">Belum ada anggota staf. Klik "Tambah Staf Baru" untuk membuat satu.
                            </p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 100px">Foto</th>
                                        <th>Nama & Posisi</th>
                                        <th>Bio</th>
                                        <th style="width: 80px" class="text-center">Urutan</th>
                                        <th style="width: 100px" class="text-center">Status</th>
                                        <th style="width: 180px" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($staff as $member): ?>
                                        <tr>
                                            <td>
                                                <?php if (isset($member['photo']) && $member['photo']): ?>
                                                    <img src="<?= base_url('uploads/staff/' . esc($member['photo'])) ?>"
                                                        alt="<?= esc($member['name']) ?>" class="img-thumbnail"
                                                        style="width: 80px; height: 80px; object-fit: cover;">
                                                <?php else: ?>
                                                    <div class="bg-light d-flex align-items-center justify-content-center"
                                                        style="width: 80px; height: 80px;">
                                                        <i class="ph ph-user text-muted" style="font-size: 32px;"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <strong><?= esc($member['name']) ?></strong>
                                                <br><small class="text-muted"><?= esc($member['position']) ?></small>
                                            </td>
                                            <td>
                                                <?php if (isset($member['bio']) && $member['bio']): ?>
                                                    <small><?= esc(substr($member['bio'], 0, 60)) ?><?= strlen($member['bio']) > 60 ? '...' : '' ?></small>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="badge bg-light-secondary"><?= esc(isset($member['sort_order']) ? $member['sort_order'] : 0) ?></span>
                                            </td>
                                            <td class="text-center">
                                                <?php if (isset($member['is_active']) && $member['is_active']): ?>
                                                    <span class="badge bg-success">
                                                        <i class="ph ph-check me-1"></i>Aktif
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="<?= base_url('admin/staff/edit/' . $member['id']) ?>"
                                                        class="btn btn-sm btn-light-warning" title="Edit">
                                                        <i class="ph ph-pencil"></i>
                                                    </a>
                                                    <a href="<?= base_url('admin/staff/toggle/' . $member['id']) ?>"
                                                        class="btn btn-sm btn-light-info"
                                                        title="<?= (isset($member['is_active']) && $member['is_active']) ? 'Nonaktifkan' : 'Aktifkan' ?>">
                                                        <i
                                                            class="ph ph-<?= (isset($member['is_active']) && $member['is_active']) ? 'eye-slash' : 'eye' ?>"></i>
                                                    </a>
                                                    <a href="<?= base_url('admin/staff/delete/' . $member['id']) ?>"
                                                        class="btn btn-sm btn-light-danger" title="Hapus"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus anggota staf ini?')">
                                                        <i class="ph ph-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Info Box -->
                        <div class="alert alert-info mt-3">
                            <i class="ph ph-info me-2"></i>
                            <strong>Tip:</strong> Anggota staf dengan status "Aktif" akan ditampilkan di beranda.
                            Gunakan urutan untuk mengontrol urutan tampilan.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

    <?= view('layouts/footer_js', ['includeCharts' => false]) ?>

</body>

</html>