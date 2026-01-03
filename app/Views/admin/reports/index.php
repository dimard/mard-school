<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Dasbor E-Rapor']) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>
    <?= view('layouts/sidebar') ?>
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'E-Rapor',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'admin/dashboard'],
                    ['label' => 'Laporan']
                ]
            ]) ?>

            <div class="row mb-3">
                <div class="col-12 text-end">
                    <a href="<?= base_url('admin/reports/settings') ?>" class="btn btn-secondary">
                        <i class="ph ph-gear me-2"></i>Pengaturan Laporan
                    </a>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <form method="get" action="" class="row align-items-center">
                        <div class="col-md-4">
                            <label class="form-label">Pilih Kelas</label>
                            <select name="class_id" class="form-select" onchange="this.form.submit()">
                                <option value="">-- Pilih Kelas --</option>
                                <?php foreach ($classes as $cls): ?>
                                    <option value="<?= $cls['id'] ?>" <?= ($selectedClassId == $cls['id']) ? 'selected' : '' ?>>
                                        <?= esc($cls['name']) ?> (<?= esc($cls['code']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <?php if ($selectedClassId && !empty($students)): ?>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Kartu Rapor Siswa</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Nama Siswa</th>
                                        <th>Email</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students as $student): ?>
                                        <tr>
                                            <td>
                                                <div class="fw-bold"><?= esc($student['full_name']) ?></div>
                                            </td>
                                            <td><?= esc($student['email']) ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/reports/print/' . $student['id'] . '/' . $selectedClassId) ?>"
                                                    target="_blank" class="btn btn-primary btn-sm">
                                                    <i class="ph ph-printer me-1"></i> Cetak / Unduh PDF
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php elseif ($selectedClassId): ?>
                <div class="alert alert-info">Tidak ada siswa ditemukan di kelas ini.</div>
            <?php endif; ?>
        </div>
    </div>

    <?= view('layouts/footer_js') ?>
</body>

</html>