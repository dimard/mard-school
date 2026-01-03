<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Edit Soal']) ?>
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
                'pageTitle' => 'Edit Soal',
                'breadcrumbs' => [
                    ['label' => 'Soal', 'url' => 'guru/cbt/' . $exam['id'] . '/questions'],
                    ['label' => 'Edit']
                ]
            ]) ?>

            <div class="row">
                <div class="col-md-10 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Edit Soal untuk: <?= esc($exam['exam_name']) ?></h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('guru/cbt/questions/update/' . $question['id']) ?>"
                                method="post">
                                <?= csrf_field() ?>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Urutan</label>
                                        <input type="number" class="form-control" name="question_order"
                                            value="<?= old('question_order', $question['question_order']) ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Poin</label>
                                        <input type="number" class="form-control" name="points"
                                            value="<?= old('points', $question['points']) ?>" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Teks Pertanyaan <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="question_text" rows="4"
                                        required><?= old('question_text', $question['question_text']) ?></textarea>
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label">Opsi A <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="option_a"
                                            value="<?= old('option_a', $question['option_a']) ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Opsi B <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="option_b"
                                            value="<?= old('option_b', $question['option_b']) ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Opsi C <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="option_c"
                                            value="<?= old('option_c', $question['option_c']) ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Opsi D <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="option_d"
                                            value="<?= old('option_d', $question['option_d']) ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Opsi E <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="option_e"
                                            value="<?= old('option_e', $question['option_e']) ?>" required>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Jawaban Benar <span class="text-danger">*</span></label>
                                    <select name="correct_answer" class="form-select" required>
                                        <option value="">-- Pilih Jawaban Benar --</option>
                                        <option value="A" <?= old('correct_answer', $question['correct_answer']) == 'A' ? 'selected' : '' ?>>Opsi A</option>
                                        <option value="B" <?= old('correct_answer', $question['correct_answer']) == 'B' ? 'selected' : '' ?>>Opsi B</option>
                                        <option value="C" <?= old('correct_answer', $question['correct_answer']) == 'C' ? 'selected' : '' ?>>Opsi C</option>
                                        <option value="D" <?= old('correct_answer', $question['correct_answer']) == 'D' ? 'selected' : '' ?>>Opsi D</option>
                                        <option value="E" <?= old('correct_answer', $question['correct_answer']) == 'E' ? 'selected' : '' ?>>Opsi E</option>
                                    </select>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="<?= base_url('guru/cbt/' . $exam['id'] . '/questions') ?>"
                                        class="btn btn-light me-md-2">Batal</a>
                                    <button type="submit" class="btn btn-primary">Perbarui Soal</button>
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