<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Kelola Soal']) ?>
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
                'pageTitle' => 'Kelola Soal',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'guru/dashboard'],
                    ['label' => 'Ujian CBT', 'url' => 'guru/cbt'],
                    ['label' => 'Soal']
                ]
            ]) ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">Soal untuk: <?= esc($exam['exam_name']) ?></h5>
                                <small class="text-muted">Total Soal: <?= count($questions) ?></small>
                            </div>
                            <a href="<?= base_url('guru/cbt/' . $exam['id'] . '/questions/create') ?>"
                                class="btn btn-primary">
                                <i class="ph ph-plus me-1"></i> Tambah Soal
                            </a>
                        </div>
                        <div class="card-body">
                            <?php if (session()->getFlashdata('message')): ?>
                                <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
                            <?php endif; ?>

                            <?php if (empty($questions)): ?>
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="ph ph-question text-muted" style="font-size: 3rem; opacity: 0.3;"></i>
                                    </div>
                                    <p class="text-muted">Belum ada soal.</p>
                                    <a href="<?= base_url('guru/cbt/' . $exam['id'] . '/questions/create') ?>"
                                        class="btn btn-primary mt-2">Tambah Soal Pertama</a>
                                </div>
                            <?php else: ?>
                                <div class="accordion" id="accordionQuestions">
                                    <?php foreach ($questions as $index => $q): ?>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading<?= $q['id'] ?>">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapse<?= $q['id'] ?>"
                                                    aria-expanded="false" aria-controls="collapse<?= $q['id'] ?>">
                                                    <span
                                                        class="badge bg-light-primary text-primary me-2">#<?= $q['question_order'] ?></span>
                                                    <?= esc(substr(strip_tags($q['question_text']), 0, 80)) . (strlen(strip_tags($q['question_text'])) > 80 ? '...' : '') ?>
                                                </button>
                                            </h2>
                                            <div id="collapse<?= $q['id'] ?>" class="accordion-collapse collapse"
                                                aria-labelledby="heading<?= $q['id'] ?>" data-bs-parent="#accordionQuestions">
                                                <div class="accordion-body">
                                                    <div class="mb-3">
                                                        <strong>Pertanyaan:</strong>
                                                        <div class="my-2 p-2 bg-light rounded">
                                                            <?= nl2br(esc($q['question_text'])) ?>
                                                        </div>
                                                    </div>

                                                    <div class="row g-3 mb-3">
                                                        <div class="col-md-6">
                                                            <div
                                                                class="p-2 border rounded <?= $q['correct_answer'] == 'A' ? 'bg-light-success border-success' : '' ?>">
                                                                <span class="fw-bold me-2">A.</span> <?= esc($q['option_a']) ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div
                                                                class="p-2 border rounded <?= $q['correct_answer'] == 'B' ? 'bg-light-success border-success' : '' ?>">
                                                                <span class="fw-bold me-2">B.</span> <?= esc($q['option_b']) ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div
                                                                class="p-2 border rounded <?= $q['correct_answer'] == 'C' ? 'bg-light-success border-success' : '' ?>">
                                                                <span class="fw-bold me-2">C.</span> <?= esc($q['option_c']) ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div
                                                                class="p-2 border rounded <?= $q['correct_answer'] == 'D' ? 'bg-light-success border-success' : '' ?>">
                                                                <span class="fw-bold me-2">D.</span> <?= esc($q['option_d']) ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div
                                                                class="p-2 border rounded <?= $q['correct_answer'] == 'E' ? 'bg-light-success border-success' : '' ?>">
                                                                <span class="fw-bold me-2">E.</span> <?= esc($q['option_e']) ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex justify-content-end gap-2 mt-3 border-top pt-3">
                                                        <a href="<?= base_url('guru/cbt/questions/edit/' . $q['id']) ?>"
                                                            class="btn btn-sm btn-warning">
                                                            <i class="ph ph-pencil me-1"></i> Edit
                                                        </a>
                                                        <a href="<?= base_url('guru/cbt/questions/delete/' . $q['id']) ?>"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Hapus soal ini?')">
                                                            <i class="ph ph-trash me-1"></i> Hapus
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <div class="mt-4 border-top pt-3">
                                <a href="<?= base_url('guru/cbt') ?>" class="btn btn-light">
                                    <i class="ph ph-arrow-left me-1"></i> Kembali ke Ujian
                                </a>
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