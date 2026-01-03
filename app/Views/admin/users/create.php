<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Buat Pengguna']) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>
    <?= view('layouts/sidebar') ?>
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Buat Pengguna',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'admin/dashboard'],
                    ['label' => 'Pengguna', 'url' => 'admin/users'],
                    ['label' => 'Buat']
                ]
            ]) ?>

            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Registrasi Pengguna</h5>
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

                            <form action="<?= base_url('admin/users/store') ?>" method="post">
                                <?= csrf_field() ?>

                                <h6 class="mb-3 text-primary text-uppercase small fw-bold">Kredensial Akun</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Username <span class="text-danger">*</span></label>
                                        <input type="text" name="username" class="form-control"
                                            value="<?= old('username') ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control"
                                            value="<?= old('email') ?>" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kata Sandi <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control" required>
                                    <small class="text-muted">Minimal 6 karakter</small>
                                </div>

                                <hr class="my-4">
                                <h6 class="mb-3 text-primary text-uppercase small fw-bold">Informasi Pribadi</h6>

                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="full_name" class="form-control"
                                        value="<?= old('full_name') ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Peran <span class="text-danger">*</span></label>
                                    <select name="role" class="form-select" id="roleSelect" required>
                                        <option value="">-- Pilih Peran --</option>
                                        <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Admin
                                        </option>
                                        <option value="guru" <?= old('role') == 'guru' ? 'selected' : '' ?>>Guru</option>
                                        <option value="siswa" <?= old('role') == 'siswa' ? 'selected' : '' ?>>Siswa
                                        </option>
                                    </select>
                                </div>

                                <!-- Student Specific Fields -->
                                <div id="studentFields" style="display: none;">
                                    <h6 class="mb-3 mt-4 text-primary text-uppercase small fw-bold">Detail Siswa</h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">NIS</label>
                                            <input type="text" name="nis" class="form-control"
                                                value="<?= old('nis') ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Kelas</label>
                                            <input type="text" name="kelas" class="form-control"
                                                value="<?= old('kelas') ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nomor Telepon</label>
                                        <input type="text" name="phone" class="form-control"
                                            value="<?= old('phone') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Alamat</label>
                                        <textarea name="address" class="form-control"
                                            rows="2"><?= old('address') ?></textarea>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                    <a href="<?= base_url('admin/users') ?>" class="btn btn-light-secondary">Batal</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ph ph-check me-2"></i>Buat Pengguna
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.getElementById('roleSelect');
            const studentFields = document.getElementById('studentFields');

            function toggleStudentFields() {
                if (roleSelect.value === 'siswa') {
                    studentFields.style.display = 'block';
                } else {
                    studentFields.style.display = 'none';
                }
            }

            roleSelect.addEventListener('change', toggleStudentFields);
            toggleStudentFields(); // Run on load in case of old input
        });
    </script>
</body>

</html>