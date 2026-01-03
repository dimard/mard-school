<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Manage Questions']) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>
    <?= view('layouts/sidebar') ?>
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Manage Questions',
                'breadcrumbs' => [
                    ['label' => 'Dashboard', 'url' => 'admin/dashboard'],
                    ['label' => 'CBT Exams', 'url' => 'admin/cbt'],
                    ['label' => esc($exam['exam_name']), 'url' => 'admin/cbt'],
                    ['label' => 'Questions']
                ]
            ]) ?>

            <div class="row mb-3">
                <div class="col-12 text-end">
                    <a href="<?= base_url('admin/cbt/' . $exam['id'] . '/questions/create') ?>" class="btn btn-primary">
                        <i class="ph ph-plus me-2"></i>Add Question
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h5 class="mb-0">Questions for: <?= esc($exam['exam_name']) ?></h5>
                            <small class="text-muted"><?= esc($exam['description']) ?></small>
                        </div>
                        <div class="card-body">
                            <?php if (session()->getFlashdata('message')): ?>
                                <div class="alert alert-success alert-dismissible fade show">
                                    <i class="ph ph-check-circle me-2"></i><?= session()->getFlashdata('message') ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th style="width: 50%;">Question</th>
                                            <th>Answer</th>
                                            <th>Points</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($questions) && !empty($questions)): ?>
                                            <?php foreach ($questions as $q): ?>
                                                <tr>
                                                    <td><?= $q['question_order'] ?></td>
                                                    <td>
                                                        <div class="mb-2 fw-medium"><?= esc($q['question_text']) ?></div>
                                                        <div class="d-flex flex-wrap gap-2">
                                                            <?php
                                                            $opts = [
                                                                'A' => $q['option_a'],
                                                                'B' => $q['option_b'],
                                                                'C' => $q['option_c'],
                                                                'D' => $q['option_d'],
                                                                'E' => $q['option_e']
                                                            ];
                                                            foreach ($opts as $key => $val):
                                                                if (!$val)
                                                                    continue;
                                                                ?>
                                                                <span
                                                                    class="badge bg-light-secondary text-dark border <?= $q['correct_answer'] === $key ? 'border-success bg-light-success text-success' : '' ?>">
                                                                    <?= $key ?>: <?= esc($val) ?>
                                                                </span>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </td>
                                                    <td><span class="badge bg-success"><?= $q['correct_answer'] ?></span></td>
                                                    <td>
                                                        <span class="badge bg-light-info text-info"><?= $q['points'] ?>
                                                            pts</span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="<?= base_url('admin/cbt/questions/edit/' . $q['id']) ?>"
                                                                class="btn btn-sm btn-light-info" data-bs-toggle="tooltip"
                                                                title="Edit">
                                                                <i class="ph ph-pencil-simple"></i>
                                                            </a>
                                                            <a href="<?= base_url('admin/cbt/questions/delete/' . $q['id']) ?>"
                                                                class="btn btn-sm btn-light-danger"
                                                                onclick="return confirm('Delete this question?')"
                                                                data-bs-toggle="tooltip" title="Delete">
                                                                <i class="ph ph-trash"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center py-5 text-muted">
                                                    <i class="ph ph-question opacity-25" style="font-size: 3rem;"></i>
                                                    <p class="mt-2">No questions added yet.</p>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= view('layouts/footer_js') ?>
</body>

</html>