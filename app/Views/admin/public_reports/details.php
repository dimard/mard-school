<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Exam Details']) ?>
    <?= view('layouts/head_css') ?>
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url('assets/css/plugins/dataTables.bootstrap5.min.css') ?>">
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>
    <?= view('layouts/sidebar') ?>
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Detail Laporan',
                'breadcrumbs' => [
                    ['label' => 'Dashboard', 'url' => 'admin/dashboard'],
                    ['label' => 'Laporan', 'url' => 'admin/public-exam-reports'],
                    ['label' => esc($exam['exam_name'])]
                ]
            ]) ?>

            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h3>
                                        <?= esc($exam['exam_name']) ?>
                                    </h3>
                                    <p class="text-muted">
                                        <?= esc($exam['description']) ?>
                                    </p>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <h2 class="mb-0 text-primary">
                                        <?= count($participants) ?>
                                    </h2>
                                    <p class="text-muted mb-0">Total Peserta</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Daftar Peserta</h5>
                            <a href="<?= base_url('admin/public-exam-reports/export/' . $exam['id']) ?>"
                                class="btn btn-success btn-sm">
                                <i class="ph ph-download-simple me-2"></i>Ekspor CSV
                            </a>
                        </div>
                        <div class="card-body">
                            <table id="detailsTable" class="table table-striped table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>Sekolah</th>
                                        <th>Nilai</th>
                                        <th>Benar</th>
                                        <th>Salah</th>
                                        <th>Status</th>
                                        <th>Waktu Pengerjaan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($participants as $p): ?>
                                        <tr>
                                            <td class="text-start">
                                                <div class="fw-bold">
                                                    <?= esc($p['full_name']) ?>
                                                </div>
                                                <small class="text-muted">
                                                    <?= esc($p['email'] ?? '-') ?>
                                                </small>
                                            </td>
                                            <td>
                                                <?= esc($p['class_name']) ?>
                                            </td>
                                            <td>
                                                <?= esc($p['school_name'] ?? '-') ?>
                                            </td>
                                            <td
                                                class="fw-bold fs-5 <?= ($p['score'] >= $exam['passing_score']) ? 'text-success' : 'text-danger' ?>">
                                                <?= number_format($p['score'], 1) ?>
                                            </td>
                                            <td class="text-success">
                                                <?= $p['total_correct'] ?>
                                            </td>
                                            <td class="text-danger">
                                                <?= $p['total_wrong'] ?>
                                            </td>
                                            <td>
                                                <?php if ($p['status'] == 'completed'): ?>
                                                    <span class="badge bg-success">Selesai</span>
                                                <?php elseif ($p['status'] == 'in_progress'): ?>
                                                    <span class="badge bg-warning text-dark">Sedang Mengerjakan</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">
                                                        <?= $p['status'] ?>
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <small>
                                                    <?php
                                                    if ($p['start_time'] && $p['end_time']) {
                                                        $start = strtotime($p['start_time']);
                                                        $end = strtotime($p['end_time']);
                                                        echo round(($end - $start) / 60) . ' menit';
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?>
                                                </small>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= view('layouts/footer_js') ?>
    <!-- DataTables -->
    <script src="<?= base_url('assets/js/plugins/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/plugins/dataTables.bootstrap5.min.js') ?>"></script>
    <script>
        $('#detailsTable').DataTable();
    </script>
</body>

</html>