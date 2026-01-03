<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Manage CBT Exams']) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>
    <?= view('layouts/sidebar') ?>
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Kelola Ujian',
                'breadcrumbs' => [
                    ['label' => 'Dashboard', 'url' => 'admin/dashboard'],
                    ['label' => 'Ujian CBT']
                ]
            ]) ?>

            <div class="row mb-3">
                <div class="col-12 text-end">
                    <a href="<?= base_url('admin/cbt/create') ?>" class="btn btn-primary">
                        <i class="ph ph-plus me-2"></i>Buat Ujian Baru
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Semua Ujian</h5>
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
                                            <th>#</th>
                                            <th>Nama Ujian</th>
                                            <th>Waktu Mulai</th>
                                            <th>Waktu Selesai</th>
                                            <th>Durasi</th>
                                            <th>Tipe</th>
                                            <th>Kode Akses</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($exams) && !empty($exams)): ?>
                                            <?php foreach ($exams as $index => $exam): ?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td>
                                                        <div class="fw-bold"><?= esc($exam['exam_name']) ?></div>
                                                        <small class="text-muted"><?= esc($exam['description'] ?? '') ?></small>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <i class="ph ph-calendar-blank me-2 text-muted"></i>
                                                            <?= date('d M Y H:i', strtotime($exam['start_time'])) ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <i class="ph ph-calendar-check me-2 text-muted"></i>
                                                            <?= date('d M Y H:i', strtotime($exam['end_time'])) ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light-primary text-primary">
                                                            <i class="ph ph-clock me-1"></i><?= $exam['duration_minutes'] ?>
                                                            menit
                                                        </span>
                                                    </td>
                                                    <!-- Type -->
                                                    <td>
                                                        <?php if ($exam['is_public']): ?>
                                                            <span class="badge bg-light-info text-info"><i
                                                                    class="ph ph-globe me-1"></i> Publik</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-light-secondary text-secondary"><i
                                                                    class="ph ph-lock-key me-1"></i> Privat</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <!-- Access Code -->
                                                    <td>
                                                        <?php if ($exam['is_public']): ?>
                                                            <code class="fw-bold"><?= esc($exam['access_code'] ?? '-') ?></code>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <!-- Status -->
                                                    <td>
                                                        <a href="<?= base_url('admin/cbt/toggle/' . $exam['id']) ?>"
                                                            class="badge bg-<?= $exam['is_active'] ? 'success' : 'secondary' ?> text-white text-decoration-none">
                                                            <?= $exam['is_active'] ? 'Aktif' : 'Draft' ?>
                                                        </a>
                                                    </td>
                                                    <!-- Actions -->
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="<?= base_url('admin/cbt/' . $exam['id'] . '/questions') ?>"
                                                                class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip"
                                                                title="Kelola Soal">
                                                                <i class="ph ph-list-numbers"></i>
                                                            </a>
                                                            <a href="<?= base_url('admin/cbt/edit/' . $exam['id']) ?>"
                                                                class="btn btn-sm btn-light-info" data-bs-toggle="tooltip"
                                                                title="Edit">
                                                                <i class="ph ph-pencil-simple"></i>
                                                            </a>
                                                            <a href="<?= base_url('admin/cbt/delete/' . $exam['id']) ?>"
                                                                class="btn btn-sm btn-light-danger"
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus ujian ini?')"
                                                                data-bs-toggle="tooltip" title="Hapus">
                                                                <i class="ph ph-trash"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="9" class="text-center py-5 text-muted">
                                                    <i class="ph ph-exam opacity-25" style="font-size: 3rem;"></i>
                                                    <p class="mt-2">Belum ada ujian yang dibuat.</p>
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