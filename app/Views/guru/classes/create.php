<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', [
        'pageTitle' => 'Buat Kelas Baru',
        'metaDescription' => 'Buat kelas baru - Dashboard Guru'
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
                'pageTitle' => 'Buat Kelas Baru',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'guru/dashboard'],
                    ['label' => 'Kelas Saya', 'url' => 'guru/classes'],
                    ['label' => 'Buat']
                ]
            ]) ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="ph ph-x-circle me-2"></i>
                    <strong>Kesalahan Validasi:</strong>
                    <ul class="mb-0 mt-2">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="ph ph-plus-circle me-2"></i>Buat Kelas Baru
                            </h5>
                        </div>
                        <div class="card-body">
                            <form
                                action="<?= base_url(session()->get('role') == 'admin' ? 'admin/classes/store' : 'guru/classes/store') ?>"
                                method="post">
                                <?= csrf_field() ?>

                                <div class="mb-3">
                                    <label class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="contoh: Matematika X IPA 1" value="<?= old('name') ?>" required>
                                    <small class="text-muted">Berikan nama yang deskriptif untuk kelas Anda</small>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="description" class="form-control" rows="4"
                                        placeholder="Masukkan deskripsi kelas, tujuan pembelajaran, atau informasi penting lainnya untuk siswa..."><?= old('description') ?></textarea>
                                    <small class="text-muted">Opsional: Tambahkan deskripsi untuk membantu siswa
                                        memahami tentang kelas ini</small>
                                </div>

                                <div class="alert alert-info">
                                    <i class="ph ph-info me-2"></i>
                                    <strong>Catatan:</strong> Kode kelas unik akan dibuat secara otomatis. Bagikan kode
                                    ini kepada siswa Anda agar mereka dapat bergabung dengan kelas.
                                </div>

                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ph ph-check-circle me-2"></i>Buat Kelas
                                    </button>
                                    <a href="<?= base_url(session()->get('role') == 'admin' ? 'admin/classes' : 'guru/classes') ?>"
                                        class="btn btn-light">
                                        <i class="ph ph-x me-2"></i>Batal
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Help Card -->
                    <div class="card mt-3">
                        <div class="card-body">
                            <h6 class="mb-3">
                                <i class="ph ph-lightbulb me-2"></i>Tips Cepat
                            </h6>
                            <ul class="mb-0 ps-3">
                                <li class="mb-2">Gunakan nama yang jelas dan deskriptif untuk kelas Anda</li>
                                <li class="mb-2">Sertakan tingkat kelas atau mata pelajaran dalam nama kelas</li>
                                <li class="mb-2">Tambahkan deskripsi terperinci untuk menetapkan ekspektasi</li>
                                <li>Bagikan kode kelas kepada siswa setelah pembuatan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- [ Main Content ] end -->

    <?= view('layouts/footer_js', ['includeCharts' => false]) ?>

</body>

</html>