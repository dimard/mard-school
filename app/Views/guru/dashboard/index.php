<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', [
        'pageTitle' => 'Dashboard Guru',
        'metaDescription' => 'Dashboard Guru - Sistem Manajemen Sekolah'
    ]) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">

    <?= view('layouts/loader') ?>

    <?php
    $menuItems = [
        [
            'caption' => 'Navigasi',
            'items' => [
                ['label' => 'Dashboard', 'url' => 'guru/dashboard', 'icon' => 'ph ph-house-line', 'active' => true]
            ]
        ],
        [
            'caption' => 'Akademik',
            'items' => [
                ['label' => 'Kelas Saya', 'url' => 'guru/classes', 'icon' => 'ph ph-chalkboard'],
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
    <?= view('layouts/sidebar', [
        'menuItems' => $menuItems,
        'homeUrl' => 'guru/dashboard'
    ]) ?>

    <?= view('layouts/topbar', [
        'notificationCount' => 0,
        'notifications' => [],
        'profileUrl' => 'guru/profile',
        'settingsUrl' => 'guru/settings'
    ]) ?>

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">

            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Dashboard Guru',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'guru/dashboard'],
                    ['label' => 'Dashboard']
                ]
            ]) ?>

            <!-- Welcome Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-primary text-white">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h2 class="text-white mb-2">Selamat Datang,
                                        <?= esc($user['full_name'] ?? 'Guru') ?>! 🎓
                                    </h2>
                                    <p class="text-white-50 mb-0">Selamat datang di dashboard guru Anda. Kelola kelas
                                        dan siswa Anda dari sini.</p>
                                </div>
                                <div class="flex-shrink-0 d-none d-md-block">
                                    <i class="ph ph-graduation-cap" style="font-size: 5rem; opacity: 0.3;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- Statistics Cards -->
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-4">Total Siswa</h6>
                            <div class="row d-flex align-items-center">
                                <div class="col-9">
                                    <h3 class="f-w-300 d-flex align-items-center m-b-0">
                                        <i class="ph ph-users text-primary f-30 m-r-10"></i>
                                        <?= $totalStudents ?? 0 ?>
                                    </h3>
                                </div>
                                <div class="col-3 text-end">
                                    <i class="ph ph-user-list text-primary f-40"></i>
                                </div>
                            </div>
                            <div class="progress m-t-30" style="height: 7px">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 65%"
                                    aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-4">Kelas</h6>
                            <div class="row d-flex align-items-center">
                                <div class="col-9">
                                    <h3 class="f-w-300 d-flex align-items-center m-b-0">
                                        <i class="ph ph-chalkboard text-success f-30 m-r-10"></i>
                                        <?= $totalClasses ?? 0 ?>
                                    </h3>
                                </div>
                                <div class="col-3 text-end">
                                    <i class="ph ph-chalkboard-teacher text-success f-40"></i>
                                </div>
                            </div>
                            <div class="progress m-t-30" style="height: 7px">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 80%"
                                    aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-4">Materi</h6>
                            <div class="row d-flex align-items-center">
                                <div class="col-9">
                                    <h3 class="f-w-300 d-flex align-items-center m-b-0">
                                        <i class="ph ph-book text-info f-30 m-r-10"></i>
                                        <?= $totalMaterials ?? 0 ?>
                                    </h3>
                                </div>
                                <div class="col-3 text-end">
                                    <i class="ph ph-books text-info f-40"></i>
                                </div>
                            </div>
                            <div class="progress m-t-30" style="height: 7px">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 55%"
                                    aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- My QR Code -->
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h6 class="mb-4">Kode QR Saya</h6>
                            <div id="qrcode" class="d-flex justify-content-center mb-3"></div>
                            <p class="text-muted small mb-2">Untuk Absensi</p>
                            <button onclick="downloadQR()" class="btn btn-sm btn-outline-primary">
                                <i class="ph ph-download me-1"></i>Download QR
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Aksi Cepat</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <div class="d-grid">
                                        <a href="<?= base_url('guru/students') ?>" class="btn btn-outline-primary">
                                            <i class="ph ph-users me-2"></i>Kelola Siswa
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="d-grid">
                                        <a href="<?= base_url('guru/materials/upload') ?>"
                                            class="btn btn-outline-success">
                                            <i class="ph ph-upload me-2"></i>Unggah Materi
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="d-grid">
                                        <a href="<?= base_url('guru/reports') ?>" class="btn btn-outline-info">
                                            <i class="ph ph-chart-line me-2"></i>Lihat Laporan
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="d-grid">
                                        <a href="<?= base_url('guru/classes') ?>" class="btn btn-outline-warning">
                                            <i class="ph ph-chalkboard me-2"></i>Kelas Saya
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->

        </div>
    </div>
    <!-- [ Main Content ] end -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        new QRCode(document.getElementById("qrcode"), {
            text: "<?= session()->get('username') ?>",
            width: 128,
            height: 128,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });

        function downloadQR() {
            const qrDiv = document.getElementById('qrcode');
            const img = qrDiv.querySelector('img');
            if (img) {
                const link = document.createElement('a');
                link.href = img.src;
                link.download = 'qrcode_<?= session()->get('username') ?>.jpg';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } else {
                // Fallback for canvas
                const canvas = qrDiv.querySelector('canvas');
                if (canvas) {
                    const link = document.createElement('a');
                    link.href = canvas.toDataURL('image/jpeg');
                    link.download = 'qrcode_<?= session()->get('username') ?>.jpg';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }
            }
        }
    </script>
    <?= view('layouts/footer_js', ['includeCharts' => false]) ?>

</body>

</html>