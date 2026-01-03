<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', [
        'pageTitle' => 'Pengaturan - Guru',
        'metaDescription' => 'Pengaturan Guru'
    ]) ?>
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
                ['label' => 'Kelas Saya', 'url' => 'guru/classes', 'icon' => 'ph ph-chalkboard', 'active' => true],
                ['label' => 'Materi', 'url' => 'guru/materials', 'icon' => 'ph ph-book-open-text'],
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
        'homeUrl' => 'guru/dashboard',
        'settingsUrl' => 'guru/settings'
    ]) ?>
    <?= view('layouts/topbar', ['notificationCount' => 0, 'notifications' => [], 'profileUrl' => 'guru/settings']) ?>

    <div class="pc-container">
        <div class="pc-content">

            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Pengaturan',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'guru/dashboard'],
                    ['label' => 'Pengaturan']
                ]
            ]) ?>

            <?php if (session()->getFlashdata('message')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="ph ph-check-circle me-2"></i><?= session()->getFlashdata('message') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="ph ph-x-circle me-2"></i>
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <?php if (!empty($user['avatar'])): ?>
                                    <img src="<?= base_url('uploads/avatars/' . esc($user['avatar'])) ?>" alt="Avatar"
                                        class="img-fluid rounded-circle"
                                        style="width: 120px; height: 120px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="avatar avatar-xl bg-light-primary text-primary rounded-circle mx-auto"
                                        style="width: 120px; height: 120px; font-size: 3rem; display: flex; align-items: center; justify-content: center;">
                                        <?= substr(esc($user['full_name']), 0, 1) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <h4><?= esc($user['full_name']) ?></h4>
                            <p class="text-muted"><?= esc($user['email']) ?></p>
                            <span class="badge bg-success">Guru</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="ph ph-gear me-2"></i>Pengaturan Profil</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('guru/settings/update') ?>" method="post"
                                enctype="multipart/form-data">

                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="full_name" class="form-control"
                                        value="<?= esc($user['full_name']) ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Alamat Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="<?= esc($user['email']) ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nomor Telepon</label>
                                    <input type="text" name="phone" class="form-control"
                                        value="<?= esc($user['phone'] ?? '') ?>" placeholder="Opsional">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Alamat</label>
                                    <textarea name="address" class="form-control" rows="3"
                                        placeholder="Opsional"><?= esc($user['address'] ?? '') ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Foto Profil</label>
                                    <input type="file" name="avatar" class="form-control" accept="image/*">
                                    <small class="text-muted">Ukuran maks: 2MB. Format: JPG, PNG, GIF</small>
                                </div>

                                <hr class="my-4">

                                <h6 class="mb-3">Ubah Password</h6>
                                <div class="mb-3">
                                    <label class="form-label">Password Baru</label>
                                    <input type="password" name="password" class="form-control"
                                        placeholder="Kosongkan jika tidak ingin mengubah password">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Konfirmasi Password</label>
                                    <input type="password" name="password_confirm" class="form-control"
                                        placeholder="Konfirmasi password baru">
                                </div>

                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ph ph-floppy-disk me-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?= view('layouts/footer_js', ['includeCharts' => false]) ?>

</body>

</html>