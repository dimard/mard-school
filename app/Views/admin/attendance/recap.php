<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Rekap Absensi']) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>
    <?= view('layouts/sidebar') ?>
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Rekap Absensi',
                'breadcrumbs' => [
                    ['label' => 'Dashboard', 'url' => 'admin/dashboard'],
                    ['label' => 'Absensi', 'url' => 'admin/attendance'],
                    ['label' => 'Rekap']
                ]
            ]) ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Rekap Bulanan</h5>

                            <form action="" method="get" class="d-flex align-items-center gap-2">
                                <select name="month" class="form-select form-select-sm">
                                    <?php for ($m = 1; $m <= 12; $m++): ?>
                                        <option value="<?= $m ?>" <?= $m == $month ? 'selected' : '' ?>>
                                            <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                                <select name="year" class="form-select form-select-sm">
                                    <?php for ($y = date('Y'); $y >= date('Y') - 2; $y--): ?>
                                        <option value="<?= $y ?>" <?= $y == $year ? 'selected' : '' ?>>
                                            <?= $y ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Role</th>
                                            <th class="text-center">Hadir</th>
                                            <th class="text-center">Izin</th>
                                            <th class="text-center">Sakit</th>
                                            <th class="text-center">Alpha</th>
                                            <th class="text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($recap)): ?>
                                            <?php foreach ($recap as $row): ?>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avtar avtar-s btn-light-primary rounded-circle me-2">
                                                                <?php if (!empty($row['user']['avatar'])): ?>
                                                                    <img src="<?= base_url('uploads/avatars/' . $row['user']['avatar']) ?>"
                                                                        alt="Avatar" class="img-fluid rounded-circle">
                                                                <?php else: ?>
                                                                    <i class="ph ph-user"></i>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div>
                                                                <div class="fw-bold">
                                                                    <?= esc($row['user']['full_name']) ?>
                                                                </div>
                                                                <small class="text-muted">
                                                                    <?= esc($row['user']['username']) ?>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge bg-light-<?= $row['user']['role'] == 'siswa' ? 'primary' : 'warning' ?> text-<?= $row['user']['role'] == 'siswa' ? 'primary' : 'warning' ?> border border-<?= $row['user']['role'] == 'siswa' ? 'primary' : 'warning' ?>">
                                                            <?= ucfirst($row['user']['role']) ?>
                                                        </span>
                                                    </td>
                                                    <td class="text-center"><span class="badge bg-success">
                                                            <?= $row['stats']['hadir'] ?>
                                                        </span></td>
                                                    <td class="text-center"><span class="badge bg-info">
                                                            <?= $row['stats']['izin'] ?>
                                                        </span></td>
                                                    <td class="text-center"><span class="badge bg-warning">
                                                            <?= $row['stats']['sakit'] ?>
                                                        </span></td>
                                                    <td class="text-center"><span class="badge bg-danger">
                                                            <?= $row['stats']['alpha'] ?>
                                                        </span></td>
                                                    <td class="text-center fw-bold">
                                                        <?= $row['stats']['total'] ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="7" class="text-center py-5 text-muted">Tidak ada data.</td>
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