<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Pengaturan Sistem']) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>
    <?= view('layouts/sidebar') ?>
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Pengaturan Sistem',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'admin/dashboard'],
                    ['label' => 'Pengaturan']
                ]
            ]) ?>

            <div class="row">
                <!-- System Configuration -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Konfigurasi Umum</h5>
                        </div>
                        <div class="card-body">
                            <?php if (session()->getFlashdata('message')): ?>
                                <div class="alert alert-success alert-dismissible fade show">
                                    <i class="ph ph-check-circle me-2"></i><?= session()->getFlashdata('message') ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <form action="<?= base_url('admin/settings/update') ?>" method="post">
                                <?= csrf_field() ?>
                                <h6 class="mb-3 text-muted text-uppercase small fw-bold">Informasi Situs</h6>

                                <div class="mb-3">
                                    <label class="form-label">Nama Situs</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ph ph-globe"></i></span>
                                        <input type="text" name="site_name" class="form-control"
                                            value="<?= $settings['site_name'] ?? '' ?>"
                                            placeholder="cth., SMA Negeri 1 Indonesia">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tagline Situs</label>
                                    <input type="text" name="site_tagline" class="form-control"
                                        value="<?= $settings['site_tagline'] ?? '' ?>"
                                        placeholder="cth., Pusat Pendidikan Berkualitas">
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Telepon Kontak</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ph ph-phone"></i></span>
                                        </div>
                                        <input type="text" name="contact_phone" class="form-control"
                                            value="<?= $settings['contact_phone'] ?? '' ?>"
                                            placeholder="cth., 021-12345678">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email Kontak</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ph ph-envelope"></i></span>
                                            <input type="email" name="contact_email" class="form-control"
                                                value="<?= $settings['contact_email'] ?? '' ?>"
                                                placeholder="cth., info@school.com">
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">
                                <h6 class="mb-3 text-muted text-uppercase small fw-bold">Pengaturan Lanjutan</h6>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="maintenance_mode"
                                            value="1" id="maintenanceMode" <?= (isset($settings['maintenance_mode']) && $settings['maintenance_mode'] == '1') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="maintenanceMode">Aktifkan Mode
                                            Pemeliharaan</label>
                                    </div>
                                    <small class="text-muted">Jika diaktifkan, hanya admin yang dapat mengakses
                                        situs.</small>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Kata Sandi Siswa Default</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ph ph-lock-key"></i></span>
                                        <input type="text" name="default_password" class="form-control"
                                            value="<?= $settings['default_password'] ?? '123456' ?>">
                                    </div>
                                    <small class="text-muted">Digunakan saat mengatur ulang kata sandi siswa.</small>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ph ph-floppy-disk me-2"></i>Simpan Konfigurasi
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Slider Management -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Slider Hero</h5>
                        </div>
                        <div class="card-body">
                            <!-- Add New Slider -->
                            <div class="card bg-light-primary mb-4 border-0">
                                <div class="card-body">
                                    <h6 class="mb-3 text-primary"><i class="ph ph-plus-circle me-1"></i> Unggah Slider
                                        Baru</h6>
                                    <form action="<?= base_url('admin/settings/uploadSlider') ?>" method="post"
                                        enctype="multipart/form-data">
                                        <?= csrf_field() ?>
                                        <div class="mb-3">
                                            <input type="file" name="slider_image" class="form-control" accept="image/*"
                                                required>
                                            <small class="text-muted">Rek. 1920x600px. Maks 2MB (JPG, PNG)</small>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-sm btn-primary">Unggah</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Slider List -->
                            <h6 class="mb-3 text-muted text-uppercase small fw-bold">Slider Aktif</h6>
                            <div class="row g-3">
                                <?php
                                $sliderModel = new \App\Models\SliderModel();
                                $existingSliders = $sliderModel->orderBy('sort_order', 'ASC')->findAll();
                                if (!empty($existingSliders)):
                                    ?>
                                    <?php foreach ($existingSliders as $slider): ?>
                                        <div class="col-sm-6">
                                            <div class="card mb-0 shadow-sm">
                                                <div class="position-relative">
                                                    <img src="<?= base_url('uploads/sliders/' . $slider['image_url']) ?>"
                                                        class="card-img-top" alt="Slider"
                                                        style="height: 120px; object-fit: cover;">
                                                    <div class="position-absolute top-0 end-0 p-2">
                                                        <span
                                                            class="badge bg-<?= $slider['is_active'] ? 'success' : 'danger' ?>">
                                                            <?= $slider['is_active'] ? 'Aktif' : 'Tidak Aktif' ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="card-body p-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <small class="text-muted">Urutan: <?= $slider['sort_order'] ?></small>
                                                        <form
                                                            action="<?= base_url('admin/settings/deleteSlider/' . $slider['id']) ?>"
                                                            method="post"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus slider ini?')"
                                                            style="display: inline;">
                                                            <?= csrf_field() ?>
                                                            <button type="submit" class="btn btn-sm btn-light-danger p-1 px-2"
                                                                data-bs-toggle="tooltip" title="Hapus">
                                                                <i class="ph ph-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="col-12">
                                        <div class="text-center py-4 text-muted border rounded border-dashed">
                                            <i class="ph ph-images opacity-25" style="font-size: 2rem;"></i>
                                            <p class="mb-0 mt-2">Belum ada slider yang diunggah</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
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