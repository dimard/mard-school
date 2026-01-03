<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', [
        'pageTitle' => ($action === 'create' ? 'Tambah Slider Baru' : 'Edit Slider'),
        'metaDescription' => 'Kelola Slider Bagian Hero'
    ]) ?>
    <?= view('layouts/head_css') ?>
    <style>
        .image-preview {
            width: 100%;
            max-width: 600px;
            height: 300px;
            border: 2px dashed #ddd;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background-color: #f8f9fa;
            position: relative;
            cursor: pointer;
        }

        .image-preview img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }

        .image-preview-placeholder {
            text-align: center;
            color: #6c757d;
        }

        .image-preview-placeholder i {
            font-size: 48px;
            margin-bottom: 10px;
        }

        .image-preview:hover {
            border-color: #0d6efd;
            background-color: #e7f1ff;
        }
    </style>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">

    <?= view('layouts/loader') ?>

    <?php
    $menuItems = [
        [
            'caption' => 'Navigasi',
            'items' => [
                ['label' => 'Dasbor', 'url' => 'admin/dashboard', 'icon' => 'ph ph-house-line']
            ]
        ],
        [
            'caption' => 'Manajemen',
            'items' => [
                ['label' => 'Beranda', 'url' => 'admin/homepage', 'icon' => 'ph ph-house'],
                ['label' => 'Slider', 'url' => 'admin/sliders', 'icon' => 'ph ph-images', 'active' => true],
                ['label' => 'Pengguna', 'url' => 'admin/users', 'icon' => 'ph ph-users'],
                ['label' => 'Kelas', 'url' => 'admin/classes', 'icon' => 'ph ph-chalkboard']
            ]
        ]
    ];
    ?>

    <?= view('layouts/sidebar', ['menuItems' => $menuItems, 'homeUrl' => 'admin/dashboard']) ?>
    <?= view('layouts/topbar', ['notificationCount' => 0, 'notifications' => [], 'profileUrl' => 'admin/profile']) ?>

    <div class="pc-container">
        <div class="pc-content">

            <?= view('layouts/breadcrumb', [
                'pageTitle' => ($action === 'create' ? 'Tambah Slider Baru' : 'Edit Slider'),
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'admin/dashboard'],
                    ['label' => 'Slider', 'url' => 'admin/sliders'],
                    ['label' => ($action === 'create' ? 'Tambah Baru' : 'Edit')]
                ]
            ]) ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="ph ph-x-circle me-2"></i>
                    <strong>Kesalahan Validasi:</strong>
                    <ul class="mb-0 mt-2">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Form Card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><?= $action === 'create' ? 'Buat Slider Baru' : 'Edit Slider' ?></h5>
                </div>
                <div class="card-body">
                    <form
                        action="<?= base_url($action === 'create' ? 'admin/sliders/store' : 'admin/sliders/update/' . $slider['id']) ?>"
                        method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <!-- Background Image -->
                        <div class="mb-4">
                            <label class="form-label">
                                Gambar Latar Belakang <span class="text-danger">*</span>
                                <small class="text-muted">(Disarankan: 1920x1080px, Maks: 5MB)</small>
                            </label>

                            <div class="image-preview" id="imagePreview"
                                onclick="document.getElementById('sliderImage').click()">
                                <?php if ($slider && $slider['image_url']): ?>
                                    <img src="<?= base_url('uploads/sliders/' . esc($slider['image_url'])) ?>" alt="Preview"
                                        id="previewImg">
                                <?php else: ?>
                                    <div class="image-preview-placeholder" id="placeholder">
                                        <i class="ph ph-image"></i>
                                        <p class="mb-0">Klik untuk mengunggah gambar latar belakang</p>
                                        <small class="text-muted">atau seret dan lepas di sini</small>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <input type="file" name="slider_image" id="sliderImage" class="form-control mt-2"
                                accept="image/*" style="display: none;" <?= $action === 'create' ? 'required' : '' ?>>

                            <small class="text-muted form-text">
                                <?= $action === 'edit' ? 'Biarkan kosong untuk menyimpan gambar saat ini. ' : '' ?>
                                Format yang didukung: JPEG, PNG, WebP
                            </small>
                        </div>

                        <div class="row">
                            <!-- Title -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Judul <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control"
                                    value="<?= old('title', isset($slider['title']) ? $slider['title'] : 'Education is the Mother of Leadership') ?>"
                                    placeholder="cth., Education is the Mother of Leadership" maxlength="255" required>
                                <small class="text-muted">Teks judul utama untuk bagian hero</small>
                            </div>

                            <!-- Description -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="description" class="form-control" rows="3"
                                    placeholder="Subjudul atau deskripsi opsional"
                                    maxlength="1000"><?= old('description', isset($slider['description']) ? $slider['description'] : '') ?></textarea>
                                <small class="text-muted">Teks subjudul opsional di bawah judul utama</small>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Button Text -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Teks Tombol</label>
                                <input type="text" name="button_text" class="form-control"
                                    value="<?= old('button_text', isset($slider['button_text']) ? $slider['button_text'] : 'Get Started') ?>"
                                    placeholder="cth., Get Started" maxlength="100">
                            </div>

                            <!-- Button URL -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">URL Tombol</label>
                                <input type="text" name="button_url" class="form-control"
                                    value="<?= old('button_url', isset($slider['button_url']) ? $slider['button_url'] : 'auth/login') ?>"
                                    placeholder="cth., auth/login atau http://..." maxlength="255">
                            </div>
                        </div>

                        <div class="row">
                            <!-- Sort Order -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Urutan</label>
                                <input type="number" name="sort_order" class="form-control"
                                    value="<?= old('sort_order', isset($slider['sort_order']) ? $slider['sort_order'] : 0) ?>"
                                    min="0">
                                <small class="text-muted">Angka yang lebih rendah muncul lebih dulu</small>
                            </div>

                            <!-- Active Status -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label d-block">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input type="checkbox" name="is_active" class="form-check-input" id="isActive"
                                        <?= old('is_active', isset($slider['is_active']) ? $slider['is_active'] : 0) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="isActive">
                                        Atur sebagai Slider Aktif
                                    </label>
                                </div>
                                <small class="text-muted">Slider aktif akan ditampilkan di beranda</small>
                            </div>
                        </div>

                        <!-- Info Alert -->
                        <div class="alert alert-info">
                            <i class="ph ph-info me-2"></i>
                            <strong>Tip:</strong> Untuk hasil terbaik, gunakan gambar berkualitas tinggi dengan dimensi
                            1920x1080 piksel.
                            Teks akan diletakkan di atas gambar, jadi pilih gambar dengan kontras yang baik.
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="<?= base_url('admin/sliders') ?>" class="btn btn-secondary">
                                <i class="ph ph-arrow-left me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i
                                    class="ph ph-check me-2"></i><?= $action === 'create' ? 'Buat Slider' : 'Perbarui Slider' ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <?= view('layouts/footer_js', ['includeCharts' => false]) ?>

    <script>
        // Image preview
        document.getElementById('sliderImage').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const preview = document.getElementById('imagePreview');
                    const placeholder = document.getElementById('placeholder');
                    const previewImg = document.getElementById('previewImg');

                    if (placeholder) {
                        placeholder.remove();
                    }

                    if (previewImg) {
                        previewImg.src = e.target.result;
                    } else {
                        preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview" id="previewImg">';
                    }
                };
                reader.readAsDataURL(file);
            }
        });

        // Drag and drop
        const dropZone = document.getElementById('imagePreview');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.style.borderColor = '#0d6efd';
                dropZone.style.backgroundColor = '#e7f1ff';
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.style.borderColor = '#ddd';
                dropZone.style.backgroundColor = '#f8f9fa';
            });
        });

        dropZone.addEventListener('drop', function (e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            document.getElementById('sliderImage').files = files;

            // Trigger change event
            const event = new Event('change');
            document.getElementById('sliderImage').dispatchEvent(event);
        });
    </script>

</body>

</html>