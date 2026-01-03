<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Unggah Materi']) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>
    <?= view('layouts/sidebar') ?>
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Unggah Materi',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'admin/dashboard'],
                    ['label' => 'Materi', 'url' => 'admin/materials'],
                    ['label' => 'Unggah']
                ]
            ]) ?>

            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Unggah Materi Baru</h5>
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

                            <form action="<?= base_url('admin/materials/store') ?>" method="post"
                                enctype="multipart/form-data">
                                <?= csrf_field() ?>

                                <div class="mb-3">
                                    <label class="form-label">Judul Materi <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" value="<?= old('title') ?>"
                                        placeholder="misal: Bab 1: Dasar Aljabar" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="description" class="form-control" rows="3"
                                        placeholder="Gambaran singkat materi..."><?= old('description') ?></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Kategori</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ph ph-tag"></i></span>
                                            <input type="text" name="category" class="form-control"
                                                value="<?= old('category') ?>" placeholder="misal: Matematika">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Berkas <span class="text-danger">*</span></label>
                                        <input type="file" name="file" class="form-control" required>
                                        <small class="text-muted d-block mt-1">PDF, DOCX, PPTX, JPG, PNG (Maks
                                            10MB)</small>
                                    </div>
                                </div>

                                <div class="alert alert-light-primary border-primary mt-2">
                                    <div class="d-flex align-items-center">
                                        <i class="ph ph-info f-20 me-2 text-primary"></i>
                                        <div>
                                            Pastikan nama berkas deskriptif dan tidak mengandung karakter khusus.
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                    <a href="<?= base_url('admin/materials') ?>"
                                        class="btn btn-light-secondary">Batal</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ph ph-upload-simple me-2"></i>Unggah Sekarang
                                    </button>
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