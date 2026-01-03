<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', [
        'pageTitle' => 'Buat Sub Kelas',
        'metaDescription' => 'Buat sub kelas baru'
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

    <?= view('layouts/sidebar', ['menuItems' => $menuItems, 'homeUrl' => 'guru/dashboard']) ?>
    <?= view('layouts/topbar', ['notificationCount' => 0, 'notifications' => [], 'profileUrl' => 'guru/profile', 'settingsUrl' => 'guru/settings']) ?>

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">

            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Buat Sub Kelas',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'guru/dashboard'],
                    ['label' => 'Kelas Saya', 'url' => 'guru/classes'],
                    ['label' => esc($class['name']), 'url' => 'guru/classes/view/' . $class['id']],
                    ['label' => 'Buat Sub Kelas']
                ]
            ]) ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Buat Sub Kelas untuk <?= esc($class['name']) ?></h5>
                        </div>
                        <div class="card-body">
                            <?php if (session()->has('errors')): ?>
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <ul class="mb-0">
                                        <?php foreach (session('errors') as $error): ?>
                                            <li><?= esc($error) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <form action="<?= base_url('guru/classes/' . $class['id'] . '/sub-classes/store') ?>"
                                method="POST">
                                <?= csrf_field() ?>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Mata Pelajaran <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="subject_name"
                                                placeholder="Contoh: Matematika, Bahasa Indonesia"
                                                value="<?= old('subject_name') ?>" required>
                                            <small class="text-muted">Nama mata pelajaran untuk sub kelas ini</small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Guru Pengampu <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" name="teacher_id" required>
                                                <option value="">-- Pilih Guru --</option>
                                                <?php foreach ($teachers as $teacher): ?>
                                                    <option value="<?= $teacher['id'] ?>"
                                                        <?= old('teacher_id') == $teacher['id'] ? 'selected' : '' ?>>
                                                        <?= esc($teacher['full_name']) ?> (<?= esc($teacher['email']) ?>)
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <small class="text-muted">Guru yang akan mengelola sub kelas ini</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea class="form-control" name="description" rows="3"
                                        placeholder="Deskripsi sub kelas (optional)"><?= old('description') ?></textarea>
                                </div>

                                <div class="alert alert-info">
                                    <i class="ph ph-info me-2"></i>
                                    <strong>Informasi:</strong>
                                    <ul class="mb-0">
                                        <li>Kode unik akan di-generate otomatis</li>
                                        <li>Semua siswa dari kelas utama akan otomatis ditambahkan ke sub kelas</li>
                                        <li>Guru pengampu dapat mengelola announcements, assignments, dan materials
                                            untuk sub kelas ini</li>
                                    </ul>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="<?= base_url('guru/classes/view/' . $class['id'] . '?tab=subclasses') ?>"
                                        class="btn btn-secondary">
                                        <i class="ph ph-arrow-left me-2"></i>Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ph ph-check me-2"></i>Buat Sub Kelas
                                    </button>
                                </div>
                            </form>
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