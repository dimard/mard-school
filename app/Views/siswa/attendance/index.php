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
                ['label' => 'Dashboard', 'url' => 'siswa/dashboard', 'icon' => 'ph ph-house-line']
            ]
        ],
        [
            'caption' => 'Akademik',
            'items' => [
                ['label' => 'Kelas Saya', 'url' => 'siswa/classes', 'icon' => 'ph ph-chalkboard', 'active' => true],
                ['label' => 'Ujian CBT', 'url' => 'siswa/cbt', 'icon' => 'ph ph-laptop'],
                ['label' => 'Materi Pelajaran', 'url' => 'siswa/materials', 'icon' => 'ph ph-book-open-text']
            ]
        ],
        [
            'caption' => 'Akun',
            'icon' => 'ph ph-user',
            'items' => [
                [
                    'label' => 'Profil Saya',
                    'url' => 'siswa/profile',
                    'icon' => 'ph ph-user-circle'
                ]
            ]
        ]
    ];
    ?>
    <?= view('layouts/sidebar', ['menuItems' => $menuItems, 'homeUrl' => 'siswa/dashboard']) ?>
    <?= view('layouts/topbar', ['notificationCount' => 0, 'notifications' => [], 'profileUrl' => 'siswa/profile']) ?>
    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', ['pageTitle' => 'Absensi Kelas', 'breadcrumbs' => [['label' => 'Beranda', 'url' => 'siswa/dashboard'], ['label' => esc($class['name']), 'url' => 'siswa/classes/view/' . $class['id']], ['label' => 'Absensi']]]) ?>

            <?php if (session()->getFlashdata('message')): ?>
                <div class="alert alert-success alert-dismissible fade show"><i class="ph ph-check-circle me-2"></i><?= session()->getFlashdata('message') ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show"><i class="ph ph-warning me-2"></i><?= session()->getFlashdata('error') ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            <?php endif; ?>

            <div class="row">
                <!-- Check-in Section -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                            <h5 class="mb-4">Absensi Langsung</h5>

                            <?php if ($active_schedule): ?>
                                <?php if ($has_checked_in): ?>
                                    <div class="check-in-status">
                                        <i class="ph ph-check-circle-fill text-success" style="font-size: 5rem;"></i>
                                        <h4 class="mt-3 text-success">Telah Hadir</h4>
                                        <p class="text-muted">Anda tercatat hadir untuk kelas hari ini.</p>
                                        <div class="badge bg-light-success text-success p-2 fs-6">
                                            Waktu: <?= date('H:i:s', strtotime($has_checked_in['check_in_time'])) ?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="check-in-active">
                                        <div class="alert alert-success mb-4">
                                            <i class="ph ph-broadcast me-2"></i> Kelas sedang <strong>BERLANGSUNG</strong>
                                            <div class="small">Sampai <?= date('H:i', strtotime($active_schedule['end_time'])) ?></div>
                                        </div>
                                        <form action="<?= base_url('siswa/classes/' . $class['id'] . '/checkin') ?>" method="POST">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-lg btn-primary rounded-pill px-5 py-3 pulse-animation">
                                                <i class="ph ph-hand-pointing me-2"></i> KETUK UNTUK ABSEN
                                            </button>
                                        </form>
                                        <p class="text-muted mt-3 small">Silakan klik tombol untuk menandai kehadiran Anda.</p>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="check-in-inactive">
                                    <i class="ph ph-clock-slash text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                                    <h5 class="mt-3 text-muted">Kelas Tidak Aktif</h5>
                                    <p class="text-muted small">Anda hanya dapat absen selama jam kelas yang dijadwalkan.</p>
                                    
                                    <div class="mt-4 p-3 bg-light rounded text-start">
                                        <small class="fw-bold d-block mb-2 text-center text-uppercase">Waktu Server Saat Ini</small>
                                        <h3 class="text-center font-monospace" id="clock">Memuat...</h3>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- History Section -->
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header"><h5>Riwayat Saya</h5></div>
                        <div class="card-body p-0">
                            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light sticky-top">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Waktu</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($history)): ?>
                                            <tr><td colspan="3" class="text-center py-4 text-muted">Tidak ada catatan kehadiran</td></tr>
                                        <?php else: ?>
                                            <?php foreach ($history as $log): ?>
                                                <tr>
                                                    <td><?= date('d M Y', strtotime($log['date'])) ?></td>
                                                    <td><?= date('H:i', strtotime($log['check_in_time'])) ?></td>
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
    <script>
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-GB', { hour12: false });
            const clockElement = document.getElementById('clock');
            if(clockElement) clockElement.innerText = timeString;
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
    <style>
        .pulse-animation {
            animation: pulse-animation 2s infinite;
        }
        @keyframes pulse-animation {
            0% { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(13, 110, 253, 0); }
            100% { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0); }
        }
    </style>
</body>
</html>