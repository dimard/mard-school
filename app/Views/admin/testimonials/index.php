<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', [
        'pageTitle' => 'Manajemen Testimoni',
        'metaDescription' => 'Kelola Testimoni Alumni'
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
                'pageTitle' => 'Manajemen Testimoni',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'admin/dashboard'],
                    ['label' => 'Manajemen Testimoni']
                ]
            ]) ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="ph ph-check-circle me-2"></i>
                    <?= session()->getFlashdata('success') ?>
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

            <!-- Testimonials Card -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">Testimoni Alumni</h5>
                            <small class="text-muted">Kelola testimoni yang ditampilkan di beranda</small>
                        </div>
                        <a href="<?= base_url('admin/testimonials/create') ?>" class="btn btn-primary">
                            <i class="ph ph-plus me-2"></i>Tambah Testimoni Baru
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (empty($testimonials)): ?>
                        <div class="text-center py-5">
                            <i class="ph ph-quotes" style="font-size: 64px; color: #ccc;"></i>
                            <p class="text-muted mt-3">Belum ada testimoni. Klik "Tambah Testimoni Baru" untuk membuat satu.
                            </p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 100px">Foto</th>
                                        <th>Nama & Peran</th>
                                        <th>Kutipan</th>
                                        <th style="width: 180px" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($testimonials as $testimonial): ?>
                                        <tr>
                                            <td>
                                                <?php if (isset($testimonial['photo']) && $testimonial['photo']): ?>
                                                    <img src="<?= base_url('uploads/testimonials/' . esc($testimonial['photo'])) ?>"
                                                        alt="<?= esc($testimonial['name']) ?>" class="img-thumbnail"
                                                        style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;">
                                                <?php else: ?>
                                                    <div class="bg-light d-flex align-items-center justify-content-center"
                                                        style="width: 80px; height: 80px; border-radius: 50%;">
                                                        <i class="ph ph-user text-muted" style="font-size: 32px;"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <strong><?= esc($testimonial['name']) ?></strong>
                                                <br><small class="text-muted"><?= esc($testimonial['role']) ?></small>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    "<?= esc(substr($testimonial['content'], 0, 80)) ?><?= strlen($testimonial['content']) > 80 ? '...' : '' ?>"
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="<?= base_url('admin/testimonials/edit/' . $testimonial['id']) ?>"
                                                        class="btn btn-sm btn-light-warning" title="Edit">
                                                        <i class="ph ph-pencil"></i>
                                                    </a>
                                                    <a href="<?= base_url('admin/testimonials/delete/' . $testimonial['id']) ?>"
                                                        class="btn btn-sm btn-light-danger" title="Hapus"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus testimoni ini?')">
                                                        <i class="ph ph-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

    <?= view('layouts/footer_js', ['includeCharts' => false]) ?>

</body>

</html>