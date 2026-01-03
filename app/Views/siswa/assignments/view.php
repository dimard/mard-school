<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => esc($assignment['title'])]) ?>
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
            <?= view('layouts/breadcrumb', ['pageTitle' => 'Detail Tugas', 'breadcrumbs' => [['label' => 'Beranda', 'url' => 'siswa/dashboard'], ['label' => 'Kelas', 'url' => 'siswa/classes'], ['label' => esc($class['name']), 'url' => 'siswa/classes/view/' . $class['id']], ['label' => 'Tugas', 'url' => 'siswa/classes/' . $class['id'] . '/assignments'], ['label' => 'Detail']]]) ?>

            <?php if (session()->getFlashdata('message')): ?>
                <div class="alert alert-success alert-dismissible fade show"><i
                        class="ph ph-check-circle me-2"></i><?= session()->getFlashdata('message') ?><button type="button"
                        class="btn-close" data-bs-dismiss="alert"></button></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show"><i
                        class="ph ph-warning me-2"></i><?= session()->getFlashdata('error') ?><button type="button"
                        class="btn-close" data-bs-dismiss="alert"></button></div>
            <?php endif; ?>

            <div class="row">
                <!-- Assignment Details -->
                <div class="col-lg-8">
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                            <h5 class="text-white mb-0"><?= esc($assignment['title']) ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3 text-muted">
                                <span><i class="ph ph-user me-1"></i> <?= esc($assignment['teacher_name']) ?></span>
                                <span><i class="ph ph-calendar me-1"></i> Tenggat:
                                    <?= date('d M Y, H:i', strtotime($assignment['deadline'])) ?></span>
                            </div>
                            <hr>
                            <div class="assignment-description">
                                <?= nl2br(esc($assignment['description'])) ?>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-light-primary text-primary fs-6">Nilai Maks:
                                    <?= $assignment['max_score'] ?></span>
                                <?php if ($is_late): ?>
                                    <span class="badge bg-danger">Batas Waktu Terlewat</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submission Form/Status -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Tugas Anda</h5>
                        </div>
                        <div class="card-body">
                            <?php if ($submission): ?>
                                <!-- Already Submitted -->
                                <div class="text-center mb-3">
                                    <i class="ph ph-check-circle text-success" style="font-size: 3rem;"></i>
                                    <h5 class="mt-2">Dikumpulkan</h5>
                                    <p class="text-muted small">
                                        <?= date('d M Y, H:i', strtotime($submission['submitted_at'])) ?>
                                    </p>
                                </div>

                                <ul class="list-group list-group-flush mb-3">
                                    <?php if ($submission['file_path']): ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><i class="ph ph-file me-2"></i>File</span>
                                            <a href="<?= base_url($submission['file_path']) ?>" target="_blank"
                                                class="btn btn-sm btn-outline-primary">Unduh</a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if ($submission['submission_text']): ?>
                                        <li class="list-group-item">
                                            <strong>Catatan:</strong><br>
                                            <small class="text-muted"><?= nl2br(esc($submission['submission_text'])) ?></small>
                                        </li>
                                    <?php endif; ?>

                                    <?php if ($submission['score'] !== null): ?>
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <strong>Nilai</strong>
                                                <span
                                                    class="badge bg-success fs-6"><?= $submission['score'] ?>/<?= $assignment['max_score'] ?></span>
                                            </div>
                                            <?php if ($submission['feedback']): ?>
                                                <div class="p-2 bg-light rounded mt-2">
                                                    <small class="d-block text-muted fw-bold">Umpan Balik:</small>
                                                    <small><?= nl2br(esc($submission['feedback'])) ?></small>
                                                </div>
                                            <?php endif; ?>
                                        </li>
                                    <?php else: ?>
                                        <li class="list-group-item text-center text-muted fst-italic">
                                            Belum dinilai
                                        </li>
                                    <?php endif; ?>
                                </ul>

                            <?php else: ?>
                                <!-- Submission Form -->
                                <form action="<?= base_url('siswa/assignments/' . $assignment['id'] . '/submit') ?>"
                                    method="POST" enctype="multipart/form-data">
                                    <?= csrf_field() ?>
                                    <div class="mb-3">
                                        <label class="form-label">Unggah File (Opsional)</label>
                                        <input type="file" class="form-control" name="file">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Catatan / Jawaban Teks</label>
                                        <textarea class="form-control" name="submission_text" rows="4"
                                            placeholder="Ketik jawaban atau catatan Anda di sini..."></textarea>
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary" <?= $is_late ? 'onclick="return confirm(\'Batas waktu telah lewat. Tetap kumpulkan?\')"' : '' ?>>
                                            <i
                                                class="ph ph-paper-plane-right me-2"></i><?= $is_late ? 'Kumpulkan Terlambat' : 'Serahkan' ?>
                                        </button>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= view('layouts/footer_js', ['includeCharts' => false]) ?>
</body>

</html>