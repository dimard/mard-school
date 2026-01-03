<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Absensi - ' . esc($class['name'])]) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>
    <?php
    $menuItems = [
        [
            'caption' => 'Navigasi',
            'items' => [
                ['label' => 'Dashboard', 'url' => 'guru/dashboard', 'icon' => 'ph ph-house-line']
            ]
        ],
        [
            'caption' => 'Akademik',
            'items' => [
                ['label' => 'Kelas Saya', 'url' => 'guru/classes', 'icon' => 'ph ph-chalkboard', 'active' => true],
                ['label' => 'Materi', 'url' => 'guru/materials', 'icon' => 'ph ph-book-open-text'],
                ['label' => 'Ujian CBT', 'url' => 'guru/cbt', 'icon' => 'ph ph-laptop'],
            ]
        ],
        [
            'caption' => 'Administrasi',
            'items' => [
                ['label' => 'Laporan', 'url' => 'guru/reports', 'icon' => 'ph ph-chart-line']
            ]
        ],
        [
            'caption' => 'Akun',
            'items' => [
                ['label' => 'Profil Saya', 'url' => 'guru/profile', 'icon' => 'ph ph-user-circle'],
                ['label' => 'Pengaturan', 'url' => 'guru/settings', 'icon' => 'ph ph-gear']
            ]
        ]
    ];
    ?>
    <?= view('layouts/sidebar', ['menuItems' => $menuItems, 'homeUrl' => 'guru/dashboard']) ?>
    <?= view('layouts/topbar', ['notificationCount' => 0, 'notifications' => [], 'profileUrl' => 'guru/profile']) ?>
    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Manajemen Absensi',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'guru/dashboard'],
                    ['label' => esc($class['name']), 'url' => 'guru/classes/view/' . $class['id']],
                    ['label' => 'Absensi']
                ]
            ]) ?>

            <div class="row">
                <!-- Schedule Management -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Jadwal Kelas</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('guru/classes/attendance/' . $class['id'] . '/schedule') ?>"
                                method="POST" class="mb-4">
                                <?= csrf_field() ?>
                                <div class="mb-3">
                                    <label class="form-label">Hari</label>
                                    <select class="form-select" name="day_of_week" required>
                                        <option value="1">Senin</option>
                                        <option value="2">Selasa</option>
                                        <option value="3">Rabu</option>
                                        <option value="4">Kamis</option>
                                        <option value="5">Jumat</option>
                                        <option value="6">Sabtu</option>
                                        <option value="7">Minggu</option>
                                    </select>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label">Waktu Mulai</label>
                                        <input type="time" class="form-control" name="start_time" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Waktu Selesai</label>
                                        <input type="time" class="form-control" name="end_time" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Tambah Jadwal</button>
                            </form>

                            <hr>

                            <h6>Jadwal Aktif:</h6>
                            <?php if (empty($schedules)): ?>
                                <p class="text-muted small">Belum ada jadwal.</p>
                            <?php else: ?>
                                <ul class="list-group list-group-flush">
                                    <?php
                                    $days = [1 => 'Sen', 2 => 'Sel', 3 => 'Rab', 4 => 'Kam', 5 => 'Jum', 6 => 'Sab', 7 => 'Min'];
                                    foreach ($schedules as $sch):
                                        ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>
                                                <strong><?= $days[$sch['day_of_week']] ?></strong>
                                                <br>
                                                <small><?= date('H:i', strtotime($sch['start_time'])) ?> -
                                                    <?= date('H:i', strtotime($sch['end_time'])) ?></small>
                                            </span>
                                            <a href="<?= base_url('guru/attendance/schedule/delete/' . $sch['id']) ?>"
                                                class="btn btn-sm btn-icon btn-light-danger"
                                                onclick="return confirm('Hapus jadwal ini?')">
                                                <i class="ph ph-trash"></i>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Daily Report -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5>Log Absensi: <?= date('d M Y', strtotime($selected_date)) ?></h5>
                            <form action="" method="GET" class="d-flex gap-2">
                                <input type="date" name="date" class="form-control form-control-sm"
                                    value="<?= $selected_date ?>">
                                <button type="submit" class="btn btn-sm btn-primary">Lihat</button>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="row text-center mb-4">
                                <div class="col-4">
                                    <h4 class="text-primary"><?= $students_count ?></h4>
                                    <small class="text-muted">Total Siswa</small>
                                </div>
                                <div class="col-4">
                                    <h4 class="text-success"><?= count($attendance_today) ?></h4>
                                    <small class="text-muted">Hadir</small>
                                </div>
                                <div class="col-4">
                                    <h4 class="text-danger"><?= $students_count - count($attendance_today) ?></h4>
                                    <small class="text-muted">Tidak Hadir</small>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Waktu</th>
                                            <th>Check-in Siswa</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($attendance_today)): ?>
                                            <tr>
                                                <td colspan="3" class="text-center text-muted">Tidak ada data untuk tanggal
                                                    ini</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($attendance_today as $log): ?>
                                                <tr>
                                                    <td><?= date('H:i:s', strtotime($log['check_in_time'])) ?></td>
                                                    <td>
                                                        <strong><?= esc($log['full_name']) ?></strong>
                                                        <br><small class="text-muted"><?= esc($log['nis']) ?></small>
                                                    </td>
                                                    <td><span class="badge bg-light-success text-success">Hadir</span></td>
                                                </tr>
                                            <?php endforeach; ?>
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
    <?= view('layouts/footer_js', ['includeCharts' => false]) ?>
</body>

</html>