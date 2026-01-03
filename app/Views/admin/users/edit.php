<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Edit Pengguna']) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>
    <?= view('layouts/sidebar') ?>
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Edit Pengguna',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'admin/dashboard'],
                    ['label' => 'Pengguna', 'url' => 'admin/users'],
                    ['label' => 'Edit']
                ]
            ]) ?>

            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Edit Profil Pengguna</h5>
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

                            <form action="<?= base_url('admin/users/update/' . $user['id']) ?>" method="post">
                                <?= csrf_field() ?>

                                <h6 class="mb-3 text-primary text-uppercase small fw-bold">Kredensial Akun</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Username <span class="text-danger">*</span></label>
                                        <input type="text" name="username" class="form-control"
                                            value="<?= esc($user['username']) ?>" required minlength="3">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control"
                                            value="<?= esc($user['email']) ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Kata Sandi Baru</label>
                                        <input type="password" name="password" id="password" class="form-control"
                                            minlength="6">
                                        <small class="text-muted">Biarkan kosong untuk menyimpan kata sandi saat
                                            ini</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Konfirmasi Kata Sandi Baru</label>
                                        <input type="password" name="password_confirm" id="password_confirm"
                                            class="form-control" minlength="6">
                                    </div>
                                </div>

                                <hr class="my-4">
                                <h6 class="mb-3 text-primary text-uppercase small fw-bold">Informasi Pribadi</h6>

                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="full_name" class="form-control"
                                        value="<?= esc($user['full_name']) ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Peran <span class="text-danger">*</span></label>
                                    <select name="role" class="form-select" id="roleSelect" required>
                                        <option value="">-- Pilih Peran --</option>
                                        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin
                                        </option>
                                        <option value="guru" <?= $user['role'] == 'guru' ? 'selected' : '' ?>>Guru</option>
                                        <option value="siswa" <?= $user['role'] == 'siswa' ? 'selected' : '' ?>>Siswa
                                        </option>
                                    </select>
                                </div>

                                <!-- Student Specific Fields -->
                                <div id="studentFields"
                                    style="display: <?= $user['role'] == 'siswa' ? 'block' : 'none' ?>;">
                                    <h6 class="mb-3 mt-4 text-primary text-uppercase small fw-bold">Detail Siswa</h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">NIS</label>
                                            <input type="text" name="nis" class="form-control"
                                                value="<?= esc($user['nis'] ?? '') ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Kelas</label>
                                            <input type="text" name="kelas" class="form-control"
                                                value="<?= esc($user['kelas'] ?? '') ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nomor Telepon</label>
                                        <input type="text" name="phone" class="form-control"
                                            value="<?= esc($user['phone'] ?? '') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Alamat</label>
                                        <textarea name="address" class="form-control"
                                            rows="2"><?= esc($user['address'] ?? '') ?></textarea>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                    <a href="<?= base_url('admin/users') ?>" class="btn btn-light-secondary">Batal</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ph ph-floppy-disk me-2"></i>Perbarui Pengguna
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
            const password = document.getElementById('password');
            const passwordConfirm = document.getElementById('password_confirm');
            const form = document.querySelector('form');

            function toggleStudentFields() {
                if (roleSelect.value === 'siswa') {
                    studentFields.style.display = 'block';
                } else {
                    studentFields.style.display = 'none';
                }
            }

            roleSelect.addEventListener('change', toggleStudentFields);

            form.addEventListener('submit', function (e) {
                if (password.value && password.value !== passwordConfirm.value) {
                    e.preventDefault();
                    alert('Kata Sandi dan Konfirmasi Kata Sandi tidak cocok!');
                }
            });
        });
    </script>
</body>

</html>