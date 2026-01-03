<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', [
        'pageTitle' => 'Dashboard Siswa',
        'metaDescription' => 'Dashboard Siswa - Sistem Manajemen Sekolah'
    ]) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">

    <?= view('layouts/loader') ?>

    <?php
    // Define siswa menu items
    $menuItems = [
        [
            'caption' => 'Navigasi',
            'items' => [
                [
                    'label' => 'Dashboard',
                    'url' => 'siswa/dashboard',
                    'icon' => 'ph ph-house-line',
                    'active' => true
                ]
            ]
        ],
        [
            'caption' => 'Akademik',
            'icon' => 'ph ph-book-open',
            'items' => [
                [
                    'label' => 'Kelas Saya',
                    'url' => 'siswa/classes',
                    'icon' => 'ph ph-chalkboard'
                ],
                [
                    'label' => 'Ujian CBT',
                    'url' => 'siswa/cbt',
                    'icon' => 'ph ph-laptop'
                ],
                [
                    'label' => 'Materi Pelajaran',
                    'url' => 'siswa/materials',
                    'icon' => 'ph ph-book-open-text'
                ],

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

    <?= view('layouts/sidebar', [
        'menuItems' => $menuItems,
        'homeUrl' => 'siswa/dashboard'
    ]) ?>

    <?= view('layouts/topbar', [
        'notificationCount' => 0,
        'notifications' => [],
        'profileUrl' => 'siswa/profile'
    ]) ?>

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">

            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Dashboard Siswa',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'siswa/dashboard'],
                    ['label' => 'Dashboard']
                ]
            ]) ?>

            <!-- Welcome Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-gradient-primary text-white"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="card-body p-4">
                            <h2 class="text-white mb-2">Selamat datang kembali, <?= session()->get('username') ?>! 👋
                            </h2>
                            <p class="text-white-50 mb-0">Berikut adalah progres belajar Anda hari ini</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- Classes Card -->
                <div class="col-md-6 col-xl-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="text-white-50 mb-2">Kelas Saya</h6>
                                    <h3 class="text-white mb-0"><?= $totalClasses ?? 0 ?></h3>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="ph ph-chalkboard" style="font-size: 3rem; opacity: 0.5;"></i>
                                </div>
                            </div>
                            <div class="mt-3">
                                <a href="<?= base_url('siswa/classes') ?>" class="btn btn-sm btn-light">
                                    <i class="ph ph-arrow-right me-1"></i> Lihat Kelas
                                </a>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Active Exams Card -->
                <div class="col-md-6 col-xl-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="text-white-50 mb-2">Ujian Aktif</h6>
                                    <h3 class="text-white mb-0"><?= count($activeExams ?? []) ?></h3>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="ph ph-laptop" style="font-size: 3rem; opacity: 0.5;"></i>
                                </div>
                            </div>
                            <div class="mt-3">
                                <a href="<?= base_url('siswa/cbt') ?>" class="btn btn-sm btn-light">
                                    <i class="ph ph-arrow-right me-1"></i> Lihat Ujian
                                </a>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- My QR Code -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Kode QR Saya</h5>
                        </div>
                        <div class="card-body text-center">
                            <div id="qrcode" class="d-flex justify-content-center mb-3"></div>
                            <p class="text-muted small mb-2">Tunjukkan QR code ini kepada admin untuk absensi.</p>
                            <button onclick="downloadQR()" class="btn btn-sm btn-primary mb-3">
                                <i class="ph ph-download me-1"></i>Download QR
                            </button>
                            <div class="fw-bold fs-5"><?= session()->get('full_name') ?></div>
                            <div class="text-muted small"><?= session()->get('username') ?></div>
                        </div>
                    </div>
                </div>

                <!-- My Stats -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Statistik Saya</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">

                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <i class="ph ph-laptop text-primary me-2"></i>
                                        <span>Ujian Selesai</span>
                                    </div>
                                    <span class="badge bg-primary rounded-pill"><?= count($examHistory ?? []) ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <i class="ph ph-chalkboard text-warning me-2"></i>
                                        <span>Kelas Diikuti</span>
                                    </div>
                                    <span class="badge bg-warning rounded-pill"><?= $totalClasses ?? 0 ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Recent Materials -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Materi Pelajaran Terbaru</h5>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($recentMaterials)): ?>
                                <div class="list-group list-group-flush">
                                    <?php foreach (array_slice($recentMaterials, 0, 3) as $material): ?>
                                        <div class="list-group-item px-0">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1"><?= esc($material['title']) ?></h6>
                                                    <p class="text-muted small mb-0">
                                                        <?= esc(substr($material['description'] ?? '', 0, 60)) ?>...
                                                    </p>
                                                </div>
                                                <div class="flex-shrink-0 ms-3">
                                                    <a href="<?= base_url('siswa/materials/download/' . $material['id']) ?>"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="ph ph-download"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="text-center mt-3">
                                    <a href="<?= base_url('siswa/materials') ?>" class="btn btn-sm btn-link">
                                        Lihat Semua Materi <i class="ph ph-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-4">
                                    <i class="ph ph-book-open text-muted" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-2 mb-0">Belum ada materi tersedia.</p>
                                </div>
                            <?php endif; ?>
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
            width: 150,
            height: 150,
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