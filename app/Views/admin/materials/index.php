<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Materi Pembelajaran']) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>
    <?= view('layouts/sidebar') ?>
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Materi Pembelajaran',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'admin/dashboard'],
                    ['label' => 'Materi']
                ]
            ]) ?>

            <div class="row mb-3">
                <div class="col-12 text-end">
                    <a href="<?= base_url('admin/materials/upload') ?>" class="btn btn-primary">
                        <i class="ph ph-upload-simple me-2"></i>Unggah Materi Baru
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Semua Materi</h5>
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
                                            <th>Info Materi</th>
                                            <th>Detail</th>
                                            <th>Statistik</th>
                                            <th>Diunggah Oleh</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($materials) && !empty($materials)): ?>
                                            <?php foreach ($materials as $material): ?>
                                                <tr>
                                                    <td style="min-width: 250px;">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <?php
                                                                $icon = 'ph-file';
                                                                $color = 'primary';
                                                                $type = strtolower($material['file_type']);
                                                                if (in_array($type, ['pdf'])) {
                                                                    $icon = 'ph-file-pdf';
                                                                    $color = 'danger';
                                                                } elseif (in_array($type, ['doc', 'docx'])) {
                                                                    $icon = 'ph-file-doc';
                                                                    $color = 'primary';
                                                                } elseif (in_array($type, ['xls', 'xlsx'])) {
                                                                    $icon = 'ph-file-xls';
                                                                    $color = 'success';
                                                                } elseif (in_array($type, ['ppt', 'pptx'])) {
                                                                    $icon = 'ph-file-ppt';
                                                                    $color = 'warning';
                                                                } elseif (in_array($type, ['jpg', 'png', 'jpeg'])) {
                                                                    $icon = 'ph-image';
                                                                    $color = 'info';
                                                                } elseif (in_array($type, ['zip', 'rar'])) {
                                                                    $icon = 'ph-file-archive';
                                                                    $color = 'secondary';
                                                                }
                                                                ?>
                                                                <div
                                                                    class="avtar avtar-s bg-light-<?= $color ?> text-<?= $color ?>">
                                                                    <i class="ph <?= $icon ?> f-20"></i>
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <h6 class="mb-0"><?= esc($material['title']) ?></h6>
                                                                <small class="text-muted text-truncate d-block"
                                                                    style="max-width: 200px;">
                                                                    <?= esc($material['description'] ?: 'Tidak ada deskripsi') ?>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="mb-1"><span
                                                                class="badge bg-light-info text-info"><?= esc($material['category']) ?></span>
                                                        </div>
                                                        <small
                                                            class="text-muted"><?= $material['file_size'] ? number_format($material['file_size'] / 1024, 2) . ' KB' : 'Tidak Diketahui' ?></small>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <i class="ph ph-download-simple me-1 text-muted"></i>
                                                            <span><?= $material['download_count'] ?></span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avtar avtar-xs btn-light-secondary rounded-circle me-2">
                                                                <i class="ph ph-user"></i>
                                                            </div>
                                                            <div>
                                                                <div class="fw-bold fs-7"><?= esc($material['uploader_name']) ?>
                                                                </div>
                                                                <small
                                                                    class="text-muted"><?= date('d M Y', strtotime($material['created_at'])) ?></small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="<?= base_url('admin/materials/delete/' . $material['id']) ?>"
                                                            class="btn btn-icon btn-light-danger"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus materi ini?')"
                                                            data-bs-toggle="tooltip" title="Hapus">
                                                            <i class="ph ph-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center py-5 text-muted">
                                                    <i class="ph ph-files opacity-25" style="font-size: 3rem;"></i>
                                                    <p class="mt-2">Tidak ada materi pembelajaran ditemukan.</p>
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