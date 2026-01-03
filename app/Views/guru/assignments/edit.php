<?php
// Simplified edit - same as create but with data pre-filled
$editMode = true;
$formAction = base_url('guru/assignments/update/' . $assignment['id']);
$buttonText = 'Perbarui Tugas';
$pageTitle = 'Edit Tugas';
?>
<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => $pageTitle]) ?>
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
    <?= view('layouts/sidebar', [
        'menuItems' => $menuItems,
        'homeUrl' => 'guru/dashboard'
    ]) ?>
    <?= view('layouts/topbar', ['notificationCount' => 0, 'notifications' => [], 'profileUrl' => 'guru/profile']) ?>
    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => $pageTitle,
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'guru/dashboard'],
                    ['label' => esc($class['name']), 'url' => 'guru/classes/view/' . $class['id']],
                    ['label' => 'Tugas', 'url' => 'guru/classes/assignments/' . $class['id']],
                    ['label' => 'Edit']
                ]
            ]) ?>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h5><?= $pageTitle ?></h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= $formAction ?>" method="POST">
                                <?= csrf_field() ?>
                                <div class="mb-3">
                                    <label class="form-label">Judul *</label>
                                    <input type="text" class="form-control" name="title"
                                        value="<?= old('title', $assignment['title']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Deskripsi *</label>
                                    <textarea class="form-control" name="description" rows="5"
                                        required><?= old('description', $assignment['description']) ?></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tenggat *</label>
                                        <input type="datetime-local" class="form-control" name="deadline"
                                            value="<?= old('deadline', date('Y-m-d\TH:i', strtotime($assignment['deadline']))) ?>"
                                            required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nilai Maksimal *</label>
                                        <input type="number" class="form-control" name="max_score"
                                            value="<?= old('max_score', $assignment['max_score']) ?>" required>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary"><i
                                            class="ph ph-check me-2"></i><?= $buttonText ?></button>
                                    <a href="<?= base_url('guru/classes/assignments/' . $class['id']) ?>"
                                        class="btn btn-secondary">Batal</a>
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