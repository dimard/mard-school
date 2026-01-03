<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Profil Saya']) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>

    <?php
    $menuItems = [
        [
            'caption' => 'Navigasi',
            'items' => [
                [
                    'label' => 'Dashboard',
                    'url' => 'siswa/dashboard',
                    'icon' => 'ph ph-house-line'
                ]
            ]
        ],
        [
            'caption' => 'Akademik',
            'icon' => 'ph ph-book-open',
            'items' => [
                [
                    'label' => 'Kelas Saya',
                    'url' => 'siswa/classes',
                    'icon' => 'ph ph-chalkboard'
                ],
                [
                    'label' => 'Ujian CBT',
                    'url' => 'siswa/cbt',
                    'icon' => 'ph ph-laptop'
                ],
                [
                    'label' => 'Materi Pelajaran',
                    'url' => 'siswa/materials',
                    'icon' => 'ph ph-book-open-text'
                ],
            ]
        ],
        [
            'caption' => 'Akun',
            'icon' => 'ph ph-user',
            'items' => [
                [
                    'label' => 'Profil Saya',
                    'url' => 'siswa/profile',
                    'icon' => 'ph ph-user-circle',
                    'active' => true
                ]
            ]
        ]
    ];
    ?>
    <?= view('layouts/sidebar', ['menuItems' => $menuItems]) ?>
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Profil Saya',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'siswa/dashboard'],
                    ['label' => 'Profil', 'active' => true]
                ]
            ]) ?>

            <?php if (session()->getFlashdata('message')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('message') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body text-center py-4">
                            <div class="mb-3">
                                <?php if (!empty($user['avatar'])): ?>
                                    <img src="<?= base_url('uploads/avatars/' . $user['avatar']) ?>" alt="Avatar"
                                        class="img-fluid rounded-circle"
                                        style="width: 120px; height: 120px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="avtar avtar-xl btn-light-primary rounded-circle mx-auto"
                                        style="width: 100px; height: 100px;">
                                        <i class="ph ph-user-circle" style="font-size: 50px;"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <h4 class="card-title mb-1"><?= esc($user['full_name']) ?></h4>
                            <p class="text-muted mb-2">@<?= esc($user['username']) ?></p>
                            <p class="text-muted mb-2"><?= esc($user['email']) ?></p>
                            <span class="badge bg-light-primary text-primary">Siswa</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5>Edit Profil</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('siswa/profile/update') ?>" method="post"
                                enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ph ph-user"></i></span>
                                        <input type="text" class="form-control"
                                            value="<?= esc($user['full_name']) ?>" disabled>
                                    </div>
                                    <small class="text-muted mt-1 d-block">Nama lengkap tidak dapat diubah. Hubungi admin.</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Alamat Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ph ph-envelope"></i></span>
                                        <input type="email" class="form-control" value="<?= esc($user['email']) ?>"
                                            disabled>
                                    </div>
                                    <small class="text-muted mt-1 d-block">Email tidak dapat diubah. Hubungi admin.</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Info Kelas</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ph ph-student"></i></span>
                                        <textarea name="kelas" class="form-control"
                                            rows="2"><?= esc($user['kelas']) ?></textarea>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Foto Profil</label>
                                    <input type="file" name="avatar" class="form-control">
                                    <small class="text-muted">Format yang diperbolehkan: jpg, jpeg, png</small>
                                </div>

                                <hr class="my-4">
                                <h6 class="mb-3">Ubah Password</h6>

                                <div class="mb-3">
                                    <label class="form-label">Password Baru</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ph ph-lock"></i></span>
                                        <input type="password" name="password" class="form-control"
                                            placeholder="Kosongkan jika tidak ingin mengubah password">
                                    </div>
                                </div>

                                <div class="text-end mt-4">
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

    <?= view('layouts/footer_js') ?>
</body>

</html>