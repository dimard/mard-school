<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Attendance Logs']) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>
    <?= view('layouts/sidebar') ?>
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Riwayat Absensi',
                'breadcrumbs' => [
                    ['label' => 'Dashboard', 'url' => 'admin/dashboard'],
                    ['label' => 'Absensi']
                ]
            ]) ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <h5 class="mb-0">Absensi Harian</h5>
                                <a href="<?= base_url('admin/attendance/scan') ?>"
                                    class="btn btn-sm btn-outline-success">
                                    <i class="ph ph-qr-code me-1"></i> Scan
                                </a>
                                <a href="<?= base_url('admin/attendance/recap') ?>" class="btn btn-sm btn-outline-info">
                                    <i class="ph ph-table me-1"></i> Rekap
                                </a>
                            </div>

                            <form action="<?= base_url('admin/attendance/filter') ?>" method="post"
                                class="d-flex align-items-center">
                                <label class="me-2 text-muted fw-bold">Tanggal:</label>
                                <div class="input-group input-group-sm">
                                    <input type="date" name="date" class="form-control" value="<?= $date ?>" required>
                                    <button type="submit" class="btn btn-primary"><i
                                            class="ph ph-magnifying-glass me-1"></i> Filter</button>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-3 text-primary">
                                <i class="ph ph-calendar-blank me-2"></i>Data untuk
                                <?= date('d F Y', strtotime($date)) ?>
                            </h6>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>Waktu Masuk</th>
                                            <th>Pengguna</th>
                                            <th>Peran</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($attendance) && !empty($attendance)): ?>
                                            <?php foreach ($attendance as $log): ?>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avtar avtar-s btn-light-success rounded-circle me-3">
                                                                <i class="ph ph-clock"></i>
                                                            </div>
                                                            <div class="fw-bold fs-5">
                                                                <?= date('H:i', strtotime($log['check_in_time'])) ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avtar avtar-s btn-light-primary rounded-circle me-2">
                                                                <i class="ph ph-user"></i>
                                                            </div>
                                                            <div>
                                                                <div class="fw-bold"><?= esc($log['full_name']) ?></div>
                                                                <small class="text-muted">ID:
                                                                    <?= isset($log['user_id']) ? $log['user_id'] : '-' ?></small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><span
                                                            class="badge bg-light-primary text-primary border border-primary">Siswa</span>
                                                    </td>
                                                    <td><span class="badge bg-success">Hadir</span></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4" class="text-center py-5 text-muted">
                                                    <i class="ph ph-clock opacity-25" style="font-size: 3rem;"></i>
                                                    <p class="mt-2">Tidak ada data absensi untuk tanggal ini.</p>
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