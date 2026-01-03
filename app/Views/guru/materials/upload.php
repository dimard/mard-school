<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Unggah Materi']) ?>
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
                ['label' => 'Materi', 'url' => 'guru/materials', 'icon' => 'ph ph-book-open-text', 'active' => true],
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
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Unggah Materi',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'guru/dashboard'],
                    ['label' => 'Materi', 'url' => 'guru/materials'],
                    ['label' => 'Unggah']
                ]
            ]) ?>

            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Bagikan Sumber Belajar</h5>
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

                            <form action="<?= base_url('guru/materials/store') ?>" method="post"
                                enctype="multipart/form-data">
                                <?= csrf_field() ?>

                                <h6 class="mb-3 text-primary text-uppercase small fw-bold">Informasi Materi</h6>
                                <div class="mb-3">
                                    <label class="form-label">Judul <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" value="<?= old('title') ?>"
                                        required placeholder="Contoh: Bab 3: Fotosintesis">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="description" class="form-control" rows="3"
                                        placeholder="Deskripsi singkat materi..."><?= old('description') ?></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Kategori / Mata Pelajaran <span
                                                class="text-danger">*</span></label>
                                        <select name="category" class="form-select" required>
                                            <option value="">-- Pilih Mata Pelajaran --</option>
                                            <option value="Mathematics" <?= old('category') == 'Mathematics' ? 'selected' : '' ?>>Matematika</option>
                                            <option value="Physics" <?= old('category') == 'Physics' ? 'selected' : '' ?>>
                                                Fisika</option>
                                            <option value="Biology" <?= old('category') == 'Biology' ? 'selected' : '' ?>>
                                                Biologi</option>
                                            <option value="Chemistry" <?= old('category') == 'Chemistry' ? 'selected' : '' ?>>Kimia</option>
                                            <option value="English" <?= old('category') == 'English' ? 'selected' : '' ?>>
                                                Bahasa Inggris</option>
                                            <option value="History" <?= old('category') == 'History' ? 'selected' : '' ?>>
                                                Sejarah</option>
                                            <option value="Computer Science" <?= old('category') == 'Computer Science' ? 'selected' : '' ?>>Ilmu Komputer</option>
                                            <option value="General" <?= old('category') == 'General' ? 'selected' : '' ?>>
                                                Umum</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Unggah Berkas <span
                                                class="text-danger">*</span></label>
                                        <input type="file" name="material_file" class="form-control" required>
                                        <small class="text-muted">Maks 10MB. Format: PDF, DOC, PPT, ZIP</small>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                    <a href="<?= base_url('guru/materials') ?>"
                                        class="btn btn-light-secondary">Batal</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ph ph-upload-simple me-2"></i>Unggah Materi
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