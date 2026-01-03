<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Add Question']) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>
    <?= view('layouts/sidebar') ?>
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Add Question',
                'breadcrumbs' => [
                    ['label' => 'Dashboard', 'url' => 'admin/dashboard'],
                    ['label' => 'CBT Exams', 'url' => 'admin/cbt'],
                    ['label' => esc($exam['exam_name']), 'url' => 'admin/cbt'],
                    ['label' => 'Questions', 'url' => 'admin/cbt/' . $exam['id'] . '/questions'],
                    ['label' => 'Add']
                ]
            ]) ?>

            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">New Question Details</h5>
                        </div>
                        <div class="card-body">
                            <?php if (session()->getFlashdata('errors')): ?>
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                            <li><?= $error ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <form action="<?= base_url('admin/cbt/' . $exam['id'] . '/questions/store') ?>"
                                method="post">
                                <?= csrf_field() ?>
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Question Text <span
                                            class="text-danger">*</span></label>
                                    <textarea name="question_text" class="form-control" rows="4"
                                        placeholder="Enter the question here..." required></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted">Option A <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">A</span>
                                            <input type="text" name="option_a" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted">Option B <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">B</span>
                                            <input type="text" name="option_b" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted">Option C <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">C</span>
                                            <input type="text" name="option_c" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted">Option D <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">D</span>
                                            <input type="text" name="option_d" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted">Option E (Optional)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">E</span>
                                            <input type="text" name="option_e" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row align-items-end">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">Correct Answer <span
                                                class="text-danger">*</span></label>
                                        <select name="correct_answer" class="form-select" required>
                                            <option value="" selected disabled>Select...</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="E">E</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">Points</label>
                                        <input type="number" name="points" class="form-control" value="5.00" step="0.5"
                                            required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">Order</label>
                                        <input type="number" name="question_order" class="form-control"
                                            value="<?= $nextOrder ?>" required>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                                    <a href="<?= base_url('admin/cbt/' . $exam['id'] . '/questions') ?>"
                                        class="btn btn-light-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary"><i class="ph ph-check me-2"></i>Save
                                        Question</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= view('layouts/footer_js') ?>
</body>

</html>