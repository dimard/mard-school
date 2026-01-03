<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', [
        'pageTitle' => 'Manajemen Slider',
        'metaDescription' => 'Kelola Slider Bagian Hero'
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
                'pageTitle' => 'Manajemen Slider',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'admin/dashboard'],
                    ['label' => 'Manajemen Slider']
                ]
            ]) ?>

            <?php if (session()->getFlashdata('message')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="ph ph-check-circle me-2"></i>
                    <?= session()->getFlashdata('message') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="ph ph-x-circle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Sliders Card -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">Slider Bagian Hero</h5>
                            <small class="text-muted">Kelola gambar latar belakang dan teks untuk bagian hero
                                beranda</small>
                        </div>
                        <a href="<?= base_url('admin/sliders/create') ?>" class="btn btn-primary">
                            <i class="ph ph-plus me-2"></i>Tambah Slider Baru
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (empty($sliders)): ?>
                        <div class="text-center py-5">
                            <i class="ph ph-images" style="font-size: 64px; color: #ccc;"></i>
                            <p class="text-muted mt-3">Belum ada slider yang dibuat. Klik "Tambah Slider Baru" untuk membuat
                                satu.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 150px">Pratinjau</th>
                                        <th>Judul & Deskripsi</th>
                                        <th>Tombol</th>
                                        <th style="width: 100px" class="text-center">Urutan</th>
                                        <th style="width: 100px" class="text-center">Status</th>
                                        <th style="width: 150px" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($sliders as $slider): ?>
                                        <tr>
                                            <td>
                                                <?php if ($slider['image_url']): ?>
                                                    <img src="<?= base_url('uploads/sliders/' . esc($slider['image_url'])) ?>"
                                                        alt="<?= esc($slider['title']) ?>" class="img-thumbnail"
                                                        style="max-width: 120px; max-height: 80px; object-fit: cover;">
                                                <?php else: ?>
                                                    <div class="bg-light d-flex align-items-center justify-content-center"
                                                        style="width: 120px; height: 80px;">
                                                        <i class="ph ph-image text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <strong><?= esc($slider['title']) ?></strong>
                                                <?php if (isset($slider['description']) && $slider['description']): ?>
                                                    <br><small
                                                        class="text-muted"><?= esc(substr($slider['description'], 0, 80)) ?><?= strlen($slider['description']) > 80 ? '...' : '' ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (isset($slider['button_text']) && $slider['button_text']): ?>
                                                    <code><?= esc($slider['button_text']) ?></code>
                                                    <br><small
                                                        class="text-muted"><?= esc(isset($slider['button_url']) ? $slider['button_url'] : '') ?></small>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="badge bg-light-secondary"><?= esc(isset($slider['sort_order']) ? $slider['sort_order'] : 0) ?></span>
                                            </td>
                                            <td class="text-center">
                                                <?php if (isset($slider['is_active']) && $slider['is_active']): ?>
                                                    <span class="badge bg-success">
                                                        <i class="ph ph-check me-1"></i>Aktif
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="<?= base_url('admin/sliders/edit/' . $slider['id']) ?>"
                                                        class="btn btn-sm btn-light-warning" title="Edit">
                                                        <i class="ph ph-pencil"></i>
                                                    </a>
                                                    <?php if (!isset($slider['is_active']) || !$slider['is_active']): ?>
                                                        <a href="<?= base_url('admin/sliders/set-active/' . $slider['id']) ?>"
                                                            class="btn btn-sm btn-light-success" title="Atur sebagai Aktif"
                                                            onclick="return confirm('Atur slider ini sebagai aktif? Ini akan menonaktifkan slider lainnya.')">
                                                            <i class="ph ph-check-circle"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                    <a href="<?= base_url('admin/sliders/delete/' . $slider['id']) ?>"
                                                        class="btn btn-sm btn-light-danger" title="Hapus"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus slider ini?')">
                                                        <i class="ph ph-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Info Box -->
                        <div class="alert alert-info mt-3">
                            <i class="ph ph-info me-2"></i>
                            <strong>Tip:</strong> Slider aktif pertama akan ditampilkan sebagai bagian hero di beranda.
                            Anda dapat mengatur slider apa pun sebagai aktif dengan mengklik ikon centang.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

    <?= view('layouts/footer_js', ['includeCharts' => false]) ?>

</body>

</html>