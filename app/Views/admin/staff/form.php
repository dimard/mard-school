<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', [
        'pageTitle' => ($action === 'create' ? 'Tambah Staf Baru' : 'Edit Staf'),
        'metaDescription' => 'Kelola Anggota Staf'
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

        .char-counter {
            font-size: 0.875rem;
            color: #6c757d;
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
                'pageTitle' => ($action === 'create' ? 'Tambah Staf Baru' : 'Edit Staf'),
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'admin/dashboard'],
                    ['label' => 'Staf', 'url' => 'admin/staff'],
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
                    <h5 class="mb-0"><?= $action === 'create' ? 'Tambah Anggota Staf Baru' : 'Edit Anggota Staf' ?></h5>
                </div>
                <div class="card-body">
                    <form
                        action="<?= base_url($action === 'create' ? 'admin/staff/store' : 'admin/staff/update/' . $staff['id']) ?>"
                        method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="row">
                            <!-- Photo Upload -->
                            <div class="col-md-4 mb-4">
                                <label class="form-label">
                                    Foto Staf <span class="text-danger">*</span>
                                    <small class="text-muted">(Maks: 2MB)</small>
                                </label>

                                <div class="photo-preview" id="photoPreview"
                                    onclick="document.getElementById('staffPhoto').click()">
                                    <?php if ($staff && isset($staff['photo']) && $staff['photo']): ?>
                                        <img src="<?= base_url('uploads/staff/' . esc($staff['photo'])) ?>" alt="Preview"
                                            id="previewImg">
                                    <?php else: ?>
                                        <div class="photo-preview-placeholder" id="placeholder">
                                            <i class="ph ph-user-circle"></i>
                                            <p class="mb-0">Klik untuk mengunggah foto</p>
                                            <small class="text-muted">atau seret dan lepas</small>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <input type="file" name="photo" id="staffPhoto" class="form-control mt-2"
                                    accept="image/*" style="display: none;" <?= $action === 'create' ? 'required' : '' ?>>

                                <small class="text-muted form-text">
                                    <?= $action === 'edit' ? 'Biarkan kosong untuk menyimpan foto saat ini. ' : '' ?>
                                    Didukung: JPEG, PNG, WebP
                                </small>
                            </div>

                            <div class="col-md-8">
                                <!-- Name -->
                                <div class="mb-3">
                                    <label class="form-label">Nama <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control"
                                        value="<?= old('name', isset($staff['name']) ? $staff['name'] : '') ?>"
                                        placeholder="cth., Mina Collins" maxlength="255" required>
                                </div>

                                <!-- Position -->
                                <div class="mb-3">
                                    <label class="form-label">Posisi <span class="text-danger">*</span></label>
                                    <input type="text" name="position" class="form-control"
                                        value="<?= old('position', isset($staff['position']) ? $staff['position'] : '') ?>"
                                        placeholder="cth., Guru Matematika" maxlength="255" required>
                                </div>

                                <!-- Bio -->
                                <div class="mb-3">
                                    <label class="form-label">Bio</label>
                                    <textarea name="bio" class="form-control" rows="3" id="bioText"
                                        placeholder="Deskripsi singkat tentang anggota staf (opsional)"
                                        maxlength="500"><?= old('bio', isset($staff['bio']) ? $staff['bio'] : '') ?></textarea>
                                    <div class="d-flex justify-content-between">
                                        <small class="text-muted">Biografi singkat opsional</small>
                                        <small class="char-counter">
                                            <span id="charCount">0</span>/500
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Social Links -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <h6 class="border-bottom pb-2 mb-3">
                                    <i class="ph ph-share-network me-2"></i>Tautan Sosial (Opsional)
                                </h6>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">
                                    <i class="ph ph-facebook-logo me-1"></i>URL Facebook
                                </label>
                                <input type="url" name="facebook_url" class="form-control"
                                    value="<?= old('facebook_url', isset($staff['facebook_url']) ? $staff['facebook_url'] : '') ?>"
                                    placeholder="https: //facebook.com/username">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">
                                    <i class="ph ph-twitter-logo me-1"></i>URL Twitter
                                </label>
                                <input type="url" name="twitter_url" class="form-control"
                                    value="<?= old('twitter_url', isset($staff['twitter_url']) ? $staff['twitter_url'] : '') ?>"
                                    placeholder="https://twitter.com/username">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">
                                    <i class="ph ph-linkedin-logo me-1"></i>URL LinkedIn
                                </label>
                                <input type="url" name="linkedin_url" class="form-control"
                                    value="<?= old('linkedin_url', isset($staff['linkedin_url']) ? $staff['linkedin_url'] : '') ?>"
                                    placeholder="https://linkedin.com/in/username">
                            </div>
                        </div>

                        <!-- Settings -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Urutan</label>
                                <input type="number" name="sort_order" class="form-control"
                                    value="<?= old('sort_order', isset($staff['sort_order']) ? $staff['sort_order'] : 0) ?>"
                                    min="0">
                                <small class="text-muted">Angka yang lebih rendah muncul lebih dulu di beranda</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label d-block">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input type="checkbox" name="is_active" class="form-check-input" id="isActive"
                                        <?= old('is_active', isset($staff['is_active']) ? $staff['is_active'] : 1) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="isActive">
                                        Tampilkan di beranda
                                    </label>
                                </div>
                                <small class="text-muted">Hanya staf aktif yang akan ditampilkan di beranda</small>
                            </div>
                        </div>

                        <!-- Info Alert -->
                        <div class="alert alert-info">
                            <i class="ph ph-info me-2"></i>
                            <strong>Tip:</strong> Untuk hasil terbaik, gunakan foto persegi (cth., 500x500px). Gambar
                            akan ditampilkan dalam format lingkaran atau persegi di beranda.
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="<?= base_url('admin/staff') ?>" class="btn btn-secondary">
                                <i class="ph ph-arrow-left me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i
                                    class="ph ph-check me-2"></i><?= $action === 'create' ? 'Buat Anggota Staf' : 'Perbarui Anggota Staf' ?>
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
        document.getElementById('staffPhoto').addEventListener('change', function (e) {
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

        // Drag and drop
        const dropZone = document.getElementById('photoPreview');

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
            document.getElementById('staffPhoto').files = files;

            // Trigger change event
            const event = new Event('change');
            document.getElementById('staffPhoto').dispatchEvent(event);
        });

        // Character counter for bio
        const bioText = document.getElementById('bioText');
        const charCount = document.getElementById('charCount');

        function updateCharCount() {
            charCount.textContent = bioText.value.length;
        }

        bioText.addEventListener('input', updateCharCount);
        updateCharCount(); // Initialize on page load
    </script>

</body>

</html>