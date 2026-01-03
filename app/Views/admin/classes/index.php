<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Manage Classes']) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>
    <?= view('layouts/sidebar') ?>
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Kelola Kelas',
                'breadcrumbs' => [
                    ['label' => 'Dashboard', 'url' => 'admin/dashboard'],
                    ['label' => 'Kelas']
                ]
            ]) ?>

            <div class="row mb-3">
                <div class="col-12 text-end">
                    <a href="<?= base_url('admin/classes/create') ?>" class="btn btn-primary">
                        <i class="ph ph-plus-circle me-2"></i>Buat Kelas Baru
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Semua Kelas</h5>
                        </div>
                        <div class="card-body">
                            <?php if (session()->getFlashdata('message')): ?>
                                <div class="alert alert-success alert-dismissible fade show">
                                    <i class="ph ph-check-circle me-2"></i><?= session()->getFlashdata('message') ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <?php if (session()->getFlashdata('error')): ?>
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <i class="ph ph-x-circle me-2"></i><?= session()->getFlashdata('error') ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>Nama Kelas</th>
                                            <th>Kode</th>
                                            <th>ID Guru</th>
                                            <th>Siswa</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($classes) && !empty($classes)): ?>
                                            <?php foreach ($classes as $class): ?>
                                                <tr>
                                                    <td>
                                                        <div class="fw-bold"><?= esc($class['name']) ?></div>
                                                        <small
                                                            class="text-muted"><?= esc($class['description'] ?: '-') ?></small>
                                                    </td>
                                                    <td><span
                                                            class="badge bg-light-primary text-primary"><?= esc($class['code']) ?></span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge bg-light-secondary"><?= esc($class['teacher_id']) ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light-info">
                                                            <?= isset($class['student_count']) ? $class['student_count'] : '0' ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="<?= base_url('admin/classes/view/' . $class['id']) ?>"
                                                                class="btn btn-sm btn-light-primary" data-bs-toggle="tooltip"
                                                                title="Lihat">
                                                                <i class="ph ph-eye"></i> Lihat
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center py-5 text-muted">Tidak ada data kelas.
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