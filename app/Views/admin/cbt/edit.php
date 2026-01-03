<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Edit Exam']) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>
    <?= view('layouts/sidebar') ?>
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Edit Ujian',
                'breadcrumbs' => [
                    ['label' => 'Dashboard', 'url' => 'admin/dashboard'],
                    ['label' => 'Ujian CBT', 'url' => 'admin/cbt'],
                    ['label' => esc($exam['exam_name']), 'url' => 'admin/cbt'],
                    ['label' => 'Edit']
                ]
            ]) ?>

            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Edit Detail Ujian</h5>
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

                            <form action="<?= base_url('admin/cbt/update/' . $exam['id']) ?>" method="post">
                                <?= csrf_field() ?>
                                <div class="mb-3">
                                    <label class="form-label">Judul Ujian <span class="text-danger">*</span></label>
                                    <input type="text" name="exam_name" class="form-control"
                                        value="<?= esc($exam['exam_name']) ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="description" class="form-control"
                                        rows="3"><?= esc($exam['description']) ?></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Durasi (Menit) <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ph ph-clock"></i></span>
                                            <input type="number" name="duration_minutes" class="form-control"
                                                value="<?= esc($exam['duration_minutes']) ?>" min="1" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nilai KKM <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ph ph-percent"></i></span>
                                            <input type="number" name="passing_score" class="form-control"
                                                value="<?= esc($exam['passing_score']) ?>" min="0" max="100" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Waktu Mulai <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="start_time" class="form-control"
                                            value="<?= date('Y-m-d\TH:i', strtotime($exam['start_time'])) ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Waktu Selesai <span
                                                class="text-danger">*</span></label>
                                        <input type="datetime-local" name="end_time" class="form-control"
                                            value="<?= date('Y-m-d\TH:i', strtotime($exam['end_time'])) ?>" required>
                                    </div>
                                </div>

                                <!-- Public Exam Settings -->
                                <div class="mb-4 border-top pt-4">
                                    <h6 class="mb-3">Pengaturan Ujian Publik</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" name="is_public" id="isPublic"
                                            <?= $exam['is_public'] ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="isPublic">Jadikan Ujian Publik</label>
                                    </div>
                                    <small class="text-muted d-block mb-3">Ujian publik dapat diakses tanpa login
                                        menggunakan kode akses.</small>

                                    <div id="publicSettings" class="p-3 bg-light rounded"
                                        style="<?= $exam['is_public'] ? '' : 'display: none;' ?>">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Kode Akses</label>
                                                <div class="input-group">
                                                    <input type="text" name="access_code" class="form-control"
                                                        value="<?= esc($exam['access_code'] ?? '') ?>"
                                                        placeholder="Otomatis jika kosong">
                                                    <button class="btn btn-outline-secondary" type="button"
                                                        id="generateCode">Generate</button>
                                                </div>
                                                <small class="text-muted">Min 4 karakter. Kosongkan untuk
                                                    generate otomatis.</small>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Maks Peserta</label>
                                                <input type="number" name="max_participants" class="form-control"
                                                    value="<?= esc($exam['max_participants'] ?? '') ?>"
                                                    placeholder="Tak Terbatas">
                                                <small class="text-muted">Kosongkan untuk peserta tak
                                                    terbatas.</small>
                                            </div>
                                            <?php if (isset($exam['current_participants']) && $exam['current_participants'] > 0): ?>
                                                <div class="col-12">
                                                    <div class="alert alert-info py-2">
                                                        <small><i class="ph ph-users me-2"></i> Peserta Saat Ini:
                                                            <strong><?= $exam['current_participants'] ?></strong></small>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4 border-top pt-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive"
                                            <?= $exam['is_active'] ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="isActive">Ujian Aktif</label>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="<?= base_url('admin/cbt') ?>" class="btn btn-light-secondary">Batal</a>
                                    <button type="submit" class="btn btn-primary"><i class="ph ph-check me-2"></i>Simpan
                                        Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= view('layouts/footer_js') ?>
    <script>
        $(document).ready(function () {
            // Toggle public settings
            $('#isPublic').change(function () {
                if ($(this).is(':checked')) {
                    $('#publicSettings').slideDown();
                } else {
                    $('#publicSettings').slideUp();
                }
            });

            // Random code generator
            $('#generateCode').click(function () {
                const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
                let result = '';
                for (let i = 0; i < 8; i++) {
                    result += chars.charAt(Math.floor(Math.random() * chars.length));
                }
                $('input[name="access_code"]').val(result);
            });
        });
    </script>
</body>

</html>