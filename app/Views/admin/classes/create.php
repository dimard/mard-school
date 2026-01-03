<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Create Class']) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>
    <?= view('layouts/sidebar') ?>
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Buat Kelas',
                'breadcrumbs' => [
                    ['label' => 'Dashboard', 'url' => 'admin/dashboard'],
                    ['label' => 'Kelas', 'url' => 'admin/classes'],
                    ['label' => 'Buat']
                ]
            ]) ?>

            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Detail Kelas</h5>
                        </div>
                        <div class="card-body">
                            <?php if (session()->getFlashdata('errors')): ?>
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                            <li><?= esc($error) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <form action="<?= base_url('admin/classes/store') ?>" method="post">
                                <?= csrf_field() ?>
                                <div class="mb-3">
                                    <label class="form-label">Pilih Guru <span class="text-danger">*</span></label>
                                    <select name="teacher_id" class="form-select" required>
                                        <option value="">-- Pilih Guru --</option>
                                        <?php if (isset($teachers)): ?>
                                            <?php foreach ($teachers as $teacher): ?>
                                                <option value="<?= $teacher['id'] ?>" <?= old('teacher_id') == $teacher['id'] ? 'selected' : '' ?>>
                                                    <?= esc($teacher['full_name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="misal: Matematika X IPA 1" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="description" class="form-control" rows="3"
                                        placeholder="Deskripsi mata pelajaran..."></textarea>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="<?= base_url('admin/classes') ?>" class="btn btn-light-secondary">Batal</a>
                                    <button type="submit" class="btn btn-primary"><i class="ph ph-check me-2"></i>Buat
                                        Kelas</button>
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