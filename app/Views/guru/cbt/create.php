<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Buat Ujian']) ?>
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
                ['label' => 'Kelas Saya', 'url' => 'guru/classes', 'icon' => 'ph ph-chalkboard'],
                ['label' => 'Materi', 'url' => 'guru/materials', 'icon' => 'ph ph-book-open-text'],
                ['label' => 'Ujian CBT', 'url' => 'guru/cbt', 'icon' => 'ph ph-laptop', 'active' => true],
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
    <?= view('layouts/topbar', ['notificationCount' => 0, 'notifications' => [], 'profileUrl' => 'guru/profile']) ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Buat Ujian',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'guru/dashboard'],
                    ['label' => 'Ujian CBT', 'url' => 'guru/cbt'],
                    ['label' => 'Buat']
                ]
            ]) ?>

            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Buat Ujian Baru</h5>
                        </div>
                        <div class="card-body">
                            <?php if (session()->getFlashdata('errors')): ?>
                                <div class="alert alert-danger">
                                    <ul>
                                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                            <li><?= esc($error) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <form action="<?= base_url('guru/cbt/store') ?>" method="post">
                                <?= csrf_field() ?>

                                <div class="mb-3">
                                    <label class="form-label">Pilih Kelas <span class="text-danger">*</span></label>
                                    <select name="class_id" class="form-select" required>
                                        <option value="">-- Pilih Kelas --</option>
                                        <?php foreach ($classes as $class): ?>
                                            <option value="<?= $class['id'] ?>"><?= esc($class['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="text-muted">Ujian ini hanya akan tersedia untuk siswa di kelas
                                        ini.</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nama Ujian <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="exam_name"
                                        value="<?= old('exam_name') ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea class="form-control" name="description"
                                        rows="3"><?= old('description') ?></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Waktu Mulai <span class="text-danger">*</span></label>
                                        <input type="datetime-local" class="form-control" name="start_time"
                                            value="<?= old('start_time') ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Waktu Selesai <span
                                                class="text-danger">*</span></label>
                                        <input type="datetime-local" class="form-control" name="end_time"
                                            value="<?= old('end_time') ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Durasi (Menit) <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="duration_minutes"
                                            value="<?= old('duration_minutes', 60) ?>" min="1" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nilai KKM <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="passing_score"
                                            value="<?= old('passing_score', 75) ?>" min="0" max="100" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                            value="1" <?= old('is_active') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="is_active">Langsung Aktif?</label>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="<?= base_url('guru/cbt') ?>" class="btn btn-light me-md-2">Batal</a>
                                    <button type="submit" class="btn btn-primary">Buat Ujian</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= view('layouts/footer_js', ['includeCharts' => false]) ?>
</body>

</html>