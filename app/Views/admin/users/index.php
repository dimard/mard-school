<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => $title ?? 'Manajemen Pengguna']) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>
    <?= view('layouts/sidebar') ?>
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => $title ?? 'Manajemen Pengguna',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'admin/dashboard'],
                    ['label' => 'Pengguna']
                ]
            ]) ?>

            <div class="row mb-3">
                <div class="col-12 text-end">
                    <a href="<?= base_url('admin/users/create') ?>" class="btn btn-primary">
                        <i class="ph ph-user-plus me-2"></i>Tambah Pengguna
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Daftar Pengguna</h5>
                        </div>
                        <div class="card-body">
                            <?php if (session()->getFlashdata('message')): ?>
                                <div class="alert alert-success alert-dismissible fade show">
                                    <i class="ph ph-check-circle me-2"></i><?= session()->getFlashdata('message') ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>Info Pengguna</th>
                                            <th>Peran</th>
                                            <th>Kontak</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($users) && !empty($users)): ?>
                                            <?php foreach ($users as $user): ?>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avtar avtar-s btn-light-primary rounded-circle me-3">
                                                                <i class="ph ph-user"></i>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0 fw-bold"><?= esc($user['full_name']) ?></h6>
                                                                <small class="text-muted">@<?= esc($user['username']) ?></small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $badgeClass = 'bg-light-success text-success';
                                                        if ($user['role'] == 'admin')
                                                            $badgeClass = 'bg-light-danger text-danger';
                                                        if ($user['role'] == 'guru')
                                                            $badgeClass = 'bg-light-primary text-primary';
                                                        ?>
                                                        <span
                                                            class="badge <?= $badgeClass ?>"><?= strtoupper(esc($user['role'])) ?></span>
                                                    </td>
                                                    <td>
                                                        <div><i class="ph ph-envelope me-1 text-muted"></i>
                                                            <?= esc($user['email']) ?></div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-success rounded-pill">Aktif</span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="<?= base_url('admin/users/edit/' . $user['id']) ?>"
                                                                class="btn btn-sm btn-light-info" data-bs-toggle="tooltip"
                                                                title="Edit">
                                                                <i class="ph ph-pencil-simple"></i>
                                                            </a>
                                                            <a href="<?= base_url('admin/users/delete/' . $user['id']) ?>"
                                                                class="btn btn-sm btn-light-danger"
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')"
                                                                data-bs-toggle="tooltip" title="Hapus">
                                                                <i class="ph ph-trash"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center py-5 text-muted">
                                                    <i class="ph ph-users opacity-25" style="font-size: 3rem;"></i>
                                                    <p class="mt-2">Tidak ada pengguna ditemukan.</p>
                                                </td>
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

    <?= view('layouts/footer_js') ?>
</body>

</html>