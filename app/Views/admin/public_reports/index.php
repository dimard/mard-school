<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Public Exam Reports']) ?>
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
                'pageTitle' => 'Laporan Ujian Publik',
                'breadcrumbs' => [
                    ['label' => 'Dashboard', 'url' => 'admin/dashboard'],
                    ['label' => 'Laporan']
                ]
            ]) ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Performa Ujian Publik</h5>
                        </div>
                        <div class="card-body">
                            <table id="reportTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Ujian</th>
                                        <th>Periode</th>
                                        <th>Peserta</th>
                                        <th>Selesai</th>
                                        <th>Nilai Tertinggi</th>
                                        <th>Nilai Terendah</th>
                                        <th>Rata-rata</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($reports as $r): ?>
                                        <tr>
                                            <td>
                                                <div class="fw-bold">
                                                    <?= esc($r['exam_name']) ?>
                                                </div>
                                                <span class="badge bg-light text-dark border">
                                                    <?= esc($r['total_questions']) ?> Soal
                                                </span>
                                            </td>
                                            <td>
                                                <small>
                                                    <?= date('d/m/y', strtotime($r['start_time'])) ?> -
                                                    <?= date('d/m/y', strtotime($r['end_time'])) ?>
                                                </small>
                                            </td>
                                            <td>
                                                <?= $r['total_participants'] ?>
                                            </td>
                                            <td>
                                                <?= $r['completed_count'] ?>
                                            </td>
                                            <td class="text-success">
                                                <?= number_format($r['highest_score'] ?? 0, 1) ?>
                                            </td>
                                            <td class="text-danger">
                                                <?= number_format($r['lowest_score'] ?? 0, 1) ?>
                                            </td>
                                            <td class="fw-bold">
                                                <?= number_format($r['average_score'] ?? 0, 1) ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('admin/public-exam-reports/details/' . $r['id']) ?>"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="ph ph-eye me-1"></i> Detail
                                                </a>
                                                <a href="<?= base_url('admin/public-exam-reports/export/' . $r['id']) ?>"
                                                    class="btn btn-sm btn-success">
                                                    <i class="ph ph-download-simple me-1"></i> CSV
                                                </a>
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
        $('#reportTable').DataTable();
    </script>
</body>

</html>