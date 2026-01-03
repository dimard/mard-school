<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Edit Berita']) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>
    <?= view('layouts/sidebar') ?>
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Edit Berita',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'admin/dashboard'],
                    ['label' => 'Berita', 'url' => 'admin/news'],
                    ['label' => 'Edit']
                ]
            ]) ?>

            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Edit Artikel</h5>
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

                            <form action="<?= base_url('admin/news/update/' . $news['id']) ?>" method="post"
                                enctype="multipart/form-data">
                                <?= csrf_field() ?>

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label class="form-label">Judul Artikel <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="title" class="form-control form-control-lg"
                                                value="<?= esc($news['title']) ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Konten <span class="text-danger">*</span></label>
                                            <textarea name="content" class="form-control" rows="12"
                                                required><?= esc($news['content']) ?></textarea>
                                            <small class="text-muted">Tag HTML didukung.</small>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="card bg-light border-0">
                                            <div class="card-body">
                                                <h6 class="mb-3 text-primary">Pengaturan Penerbitan</h6>

                                                <div class="mb-3">
                                                    <label class="form-label">Status <span
                                                            class="text-danger">*</span></label>
                                                    <select name="status" class="form-select" required>
                                                        <option value="published" <?= $news['is_published'] ? 'selected' : '' ?>>Diterbitkan</option>
                                                        <option value="draft" <?= !$news['is_published'] ? 'selected' : '' ?>>Draf</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Gambar Unggulan</label>
                                                    <?php if ($news['thumbnail']): ?>
                                                        <div class="mb-2">
                                                            <img src="<?= base_url('uploads/news/' . $news['thumbnail']) ?>"
                                                                class="img-fluid rounded" alt="Current Image">
                                                        </div>
                                                    <?php endif; ?>
                                                    <input type="file" name="image" class="form-control"
                                                        accept="image/*">
                                                    <small class="text-muted d-block mt-1">Biarkan kosong untuk
                                                        menyimpan gambar saat ini.</small>
                                                </div>

                                                <hr>
                                                <div class="d-grid gap-2">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="ph ph-floppy-disk me-2"></i>Perbarui Berita
                                                    </button>
                                                    <a href="<?= base_url('admin/news') ?>"
                                                        class="btn btn-outline-secondary">
                                                        Batal
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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