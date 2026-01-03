<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', [
        'pageTitle' => ($title ?? 'Kelola Testimoni'),
        'metaDescription' => 'Kelola Testimoni'
    ]) ?>
    <?= view('layouts/head_css') ?>
    <style>
        .photo-preview {
            width: 100%;
            max-width: 300px;
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

        .photo-preview img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }

        .photo-preview-placeholder {
            text-align: center;
            color: #6c757d;
        }

        .photo-preview-placeholder i {
            font-size: 48px;
            margin-bottom: 10px;
        }

        .photo-preview:hover {
            border-color: #0d6efd;
            background-color: #e7f1ff;
        }
    </style>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">

    <?= view('layouts/loader') ?>

    <?php
    // Menu items are handled centrally in layouts/sidebar.php
    ?>

    <?= view('layouts/sidebar', ['homeUrl' => 'admin/dashboard']) ?>
    <?= view('layouts/topbar', ['notificationCount' => 0, 'notifications' => [], 'profileUrl' => 'admin/profile']) ?>

    <div class="pc-container">
        <div class="pc-content">

            <?= view('layouts/breadcrumb', [
                'pageTitle' => ($title ?? 'Kelola Testimoni'),
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'admin/dashboard'],
                    ['label' => 'Testimoni', 'url' => 'admin/testimonials'],
                    ['label' => isset($testimonial) ? 'Edit' : 'Tambah Baru']
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
                    <h5 class="mb-0"><?= isset($testimonial) ? 'Edit Testimoni' : 'Tambah Testimoni Baru' ?></h5>
                </div>
                <div class="card-body">
                    <form
                        action="<?= base_url(isset($testimonial) ? 'admin/testimonials/update/' . $testimonial['id'] : 'admin/testimonials/store') ?>"
                        method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="row">
                            <!-- Photo Upload -->
                            <div class="col-md-4 mb-4">
                                <label class="form-label">
                                    Foto <small class="text-muted">(Opsional)</small>
                                </label>

                                <div class="photo-preview" id="photoPreview"
                                    onclick="document.getElementById('photoField').click()">
                                    <?php if (isset($testimonial) && isset($testimonial['photo']) && $testimonial['photo']): ?>
                                        <img src="<?= base_url('uploads/testimonials/' . esc($testimonial['photo'])) ?>"
                                            alt="Preview" id="previewImg">
                                    <?php else: ?>
                                        <div class="photo-preview-placeholder" id="placeholder">
                                            <i class="ph ph-user-circle"></i>
                                            <p class="mb-0">Klik untuk mengunggah foto</p>
                                            <small class="text-muted">atau seret dan lepas</small>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <input type="file" name="photo" id="photoField" class="form-control mt-2"
                                    accept="image/*" style="display: none;" <?= !isset($testimonial) ? '' : '' // Optional on both create and edit ?>>

                                <small class="text-muted form-text">
                                    Didukung: JPEG, PNG, WebP
                                </small>
                            </div>

                            <div class="col-md-8">
                                <!-- Name -->
                                <div class="mb-3">
                                    <label class="form-label">Nama <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control"
                                        value="<?= old('name', isset($testimonial['name']) ? $testimonial['name'] : '') ?>"
                                        placeholder="cth., Budi Santoso" maxlength="255" required>
                                </div>

                                <!-- Role -->
                                <div class="mb-3">
                                    <label class="form-label">Peran / Posisi <span class="text-danger">*</span></label>
                                    <input type="text" name="role" class="form-control"
                                        value="<?= old('role', isset($testimonial['role']) ? $testimonial['role'] : '') ?>"
                                        placeholder="cth., Alumni 2020, CEO di TechCorp" maxlength="255" required>
                                </div>

                                <!-- Content -->
                                <div class="mb-3">
                                    <label class="form-label">Kutipan / Testimoni <span
                                            class="text-danger">*</span></label>
                                    <textarea name="content" class="form-control" rows="5"
                                        placeholder="Masukkan isi testimoni di sini..."
                                        required><?= old('content', isset($testimonial['content']) ? $testimonial['content'] : '') ?></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="<?= base_url('admin/testimonials') ?>" class="btn btn-secondary">
                                <i class="ph ph-arrow-left me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i
                                    class="ph ph-check me-2"></i><?= isset($testimonial) ? 'Perbarui Testimoni' : 'Buat Testimoni' ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <?= view('layouts/footer_js', ['includeCharts' => false]) ?>

    <script>
        // Photo preview
        document.getElementById('photoField').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const preview = document.getElementById('photoPreview');
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

        // Drag and drop logic same as staff form
        const dropZone = document.getElementById('photoPreview');
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, (e) => { e.preventDefault(); e.stopPropagation(); }, false);
        });
        dropZone.addEventListener('drop', function (e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            document.getElementById('photoField').files = files;
            const event = new Event('change');
            document.getElementById('photoField').dispatchEvent(event);
        });
    </script>

</body>

</html>