<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', [
        'pageTitle' => 'Homepage Management',
        'metaDescription' => 'Manage Homepage Content'
    ]) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">

    <?= view('layouts/loader') ?>

    <?php
    $menuItems = [
        [
            'caption' => 'Navigation',
            'items' => [
                ['label' => 'Dashboard', 'url' => 'admin/dashboard', 'icon' => 'ph ph-house-line']
            ]
        ],
        [
            'caption' => 'Management',
            'items' => [
                ['label' => 'Homepage', 'url' => 'admin/homepage', 'icon' => 'ph ph-house', 'active' => true],
                ['label' => 'Sliders', 'url' => 'admin/sliders', 'icon' => 'ph ph-images'],
                ['label' => 'Staff', 'url' => 'admin/staff', 'icon' => 'ph ph-users-three'],
                ['label' => 'Users', 'url' => 'admin/users', 'icon' => 'ph ph-users'],
                ['label' => 'Classes', 'url' => 'admin/classes', 'icon' => 'ph ph-chalkboard']
            ]
        ]
    ];
    ?>

    <?= view('layouts/sidebar', ['menuItems' => $menuItems, 'homeUrl' => 'admin/dashboard']) ?>
    <?= view('layouts/topbar', ['notificationCount' => 0, 'notifications' => [], 'profileUrl' => 'admin/profile']) ?>

    <div class="pc-container">
        <div class="pc-content">

            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Manajemen Beranda',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'admin/dashboard'],
                    ['label' => 'Manajemen Beranda']
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

            <!-- Tabs -->
            <ul class="nav nav-tabs mb-3" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#navbar" role="tab">
                        <i class="ph ph-navigation-arrow me-1"></i>Link Navigasi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#sliders" role="tab">
                        <i class="ph ph-images me-1"></i>Slider
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#features" role="tab">
                        <i class="ph ph-squares-four me-1"></i>Fitur Kami
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#about" role="tab">
                        <i class="ph ph-info me-1"></i>Bagian Tentang
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#footer" role="tab">
                        <i class="ph ph-copyright me-1"></i>Pengaturan Footer
                    </a>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content">
                <!-- Navbar Links Tab -->
                <div class="tab-pane active" id="navbar" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Link Navigasi</h5>
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addNavLinkModal">
                                    <i class="ph ph-plus me-2"></i>Tambah Link
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Label</th>
                                            <th>URL</th>
                                            <th>Urutan</th>
                                            <th>Target</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($nav_links)): ?>
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">Belum ada link navigasi yang
                                                    ditambahkan
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($nav_links as $link): ?>
                                                <tr>
                                                    <td><strong><?= esc($link['label']) ?></strong></td>
                                                    <td><code><?= esc($link['url']) ?></code></td>
                                                    <td><?= esc($link['sort_order']) ?></td>
                                                    <td><?= esc($link['target']) ?></td>
                                                    <td>
                                                        <?php if ($link['is_active']): ?>
                                                            <span class="badge bg-success">Aktif</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary">Tidak Aktif</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-light-warning edit-nav-link"
                                                            data-id="<?= $link['id'] ?>" data-label="<?= esc($link['label']) ?>"
                                                            data-url="<?= esc($link['url']) ?>"
                                                            data-order="<?= esc($link['sort_order']) ?>"
                                                            data-target="<?= esc($link['target']) ?>"
                                                            data-active="<?= $link['is_active'] ?>">
                                                            <i class="ph ph-pencil"></i>
                                                        </button>
                                                        <a href="<?= base_url('admin/homepage/delete-nav-link/' . $link['id']) ?>"
                                                            class="btn btn-sm btn-light-danger"
                                                            onclick="return confirm('Hapus link ini?')">
                                                            <i class="ph ph-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sliders Tab -->
                <div class="tab-pane" id="sliders" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Manajemen Slider</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">
                                <i class="ph ph-info me-2"></i>
                                Manajemen slider tersedia di <a href="<?= base_url('admin/sliders') ?>">Bagian
                                    Slider</a>
                            </p>
                            <a href="<?= base_url('admin/sliders') ?>" class="btn btn-primary">
                                <i class="ph ph-images me-2"></i>Kelola Slider
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Features Tab -->
                <div class="tab-pane" id="features" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Fitur Beranda</h5>
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addFeatureModal">
                                    <i class="ph ph-plus me-2"></i>Tambah Fitur
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Ikon</th>
                                            <th>Judul</th>
                                            <th>Deskripsi</th>
                                            <th>Urutan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($features)): ?>
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">Belum ada fitur yang
                                                    ditambahkan
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($features as $feature): ?>
                                                <tr>
                                                    <td>
                                                        <span class="<?= esc($feature['icon_class']) ?>"
                                                            style="font-size: 24px;"></span>
                                                        <br>
                                                        <small class="text-muted"><?= esc($feature['icon_class']) ?></small>
                                                    </td>
                                                    <td><strong><?= esc($feature['title']) ?></strong></td>
                                                    <td><?= esc(substr($feature['description'], 0, 80)) ?>...</td>
                                                    <td><?= esc($feature['sort_order']) ?></td>
                                                    <td>
                                                        <?php if ($feature['is_active']): ?>
                                                            <span class="badge bg-success">Aktif</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary">Tidak Aktif</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-light-warning edit-feature"
                                                            data-id="<?= $feature['id'] ?>"
                                                            data-icon="<?= esc($feature['icon_class']) ?>"
                                                            data-title="<?= esc($feature['title']) ?>"
                                                            data-description="<?= esc($feature['description']) ?>"
                                                            data-order="<?= esc($feature['sort_order']) ?>"
                                                            data-active="<?= $feature['is_active'] ?>">
                                                            <i class="ph ph-pencil"></i>
                                                        </button>
                                                        <a href="<?= base_url('admin/homepage/delete-feature/' . $feature['id']) ?>"
                                                            class="btn btn-sm btn-light-danger"
                                                            onclick="return confirm('Hapus fitur ini?')">
                                                            <i class="ph ph-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- About Section Tab -->
                <div class="tab-pane" id="about" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Bagian Tentang</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('admin/homepage/update-about') ?>" method="post"
                                enctype="multipart/form-data">
                                <?= csrf_field() ?>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Sub-judul <span class="text-danger">*</span></label>
                                        <input type="text" name="subtitle" class="form-control"
                                            value="<?= esc($about_section['subtitle'] ?? 'Tentang Kami') ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Judul <span class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control"
                                            value="<?= esc($about_section['title'] ?? 'Platform Manajemen Sekolah Terdepan') ?>"
                                            required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Konten <span class="text-danger">*</span></label>
                                    <textarea name="content" class="form-control" rows="4"
                                        required><?= esc($about_section['content'] ?? '') ?></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Fitur 1</label>
                                        <input type="text" name="feature1" class="form-control"
                                            value="<?= esc($about_section['extra_data']['feature1'] ?? 'Dashboard Modern') ?>">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Fitur 2</label>
                                        <input type="text" name="feature2" class="form-control"
                                            value="<?= esc($about_section['extra_data']['feature2'] ?? 'Kelas Online') ?>">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Fitur 3</label>
                                        <input type="text" name="feature3" class="form-control"
                                            value="<?= esc($about_section['extra_data']['feature3'] ?? 'Dukungan 24/7') ?>">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Fitur 4</label>
                                        <input type="text" name="feature4" class="form-control"
                                            value="<?= esc($about_section['extra_data']['feature4'] ?? 'Platform Aman') ?>">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Teks Tombol</label>
                                        <input type="text" name="button_text" class="form-control"
                                            value="<?= esc($about_section['button_text'] ?? 'Akses Platform') ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">URL Tombol</label>
                                        <input type="text" name="button_url" class="form-control"
                                            value="<?= esc($about_section['button_url'] ?? 'auth/login') ?>">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Gambar Tentang Kami</label>
                                    <?php if (!empty($about_section['image_path'])): ?>
                                        <div class="mb-2">
                                            <img src="<?= base_url('uploads/homepage/' . $about_section['image_path']) ?>"
                                                class="img-thumbnail" style="max-height: 200px;">
                                        </div>
                                    <?php endif; ?>
                                    <input type="file" name="about_image" class="form-control" accept="image/*">
                                    <small class="text-muted">Maks 2MB. Kosongkan untuk menyimpan gambar saat
                                        ini.</small>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="ph ph-check me-2"></i>Perbarui Bagian Tentang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Footer Settings Tab -->
                <div class="tab-pane" id="footer" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Pengaturan Footer</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('admin/homepage/update-footer') ?>" method="post">
                                <?= csrf_field() ?>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nama Situs <span class="text-danger">*</span></label>
                                        <input type="text" name="site_name" class="form-control"
                                            value="<?= esc($footer_settings['site_name'] ?? 'EduSystem') ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tagline Situs <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="site_tagline" class="form-control"
                                            value="<?= esc($footer_settings['site_tagline'] ?? 'Sistem Manajemen Sekolah Modern') ?>"
                                            required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Alamat Sekolah <span class="text-danger">*</span></label>
                                    <textarea name="school_address" class="form-control" rows="2"
                                        required><?= esc($footer_settings['school_address'] ?? 'Indonesia') ?></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email Kontak <span
                                                class="text-danger">*</span></label>
                                        <input type="email" name="contact_email" class="form-control"
                                            value="<?= esc($footer_settings['contact_email'] ?? 'info@school.com') ?>"
                                            required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Telepon Kontak <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="contact_phone" class="form-control"
                                            value="<?= esc($footer_settings['contact_phone'] ?? '+62 123 456 789') ?>"
                                            required>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="ph ph-check me-2"></i>Perbarui Pengaturan Footer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Add Nav Link Modal -->
    <div class="modal fade" id="addNavLinkModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?= base_url('admin/homepage/add-nav-link') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Link Navigasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Label <span class="text-danger">*</span></label>
                            <input type="text" name="label" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">URL <span class="text-danger">*</span></label>
                            <input type="text" name="url" class="form-control" placeholder="/halaman atau http://..."
                                required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Urutan</label>
                                <input type="number" name="sort_order" class="form-control" value="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Target</label>
                                <select name="target" class="form-select">
                                    <option value="_self">Jendela Sama</option>
                                    <option value="_blank">Jendela Baru</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="add_is_active" checked>
                            <label class="form-check-label" for="add_is_active">Aktif</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah Link</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Nav Link Modal -->
    <div class="modal fade" id="editNavLinkModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post" id="editNavLinkForm">
                    <?= csrf_field() ?>
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Link Navigasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Label <span class="text-danger">*</span></label>
                            <input type="text" name="label" class="form-control" id="edit_label" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">URL <span class="text-danger">*</span></label>
                            <input type="text" name="url" class="form-control" id="edit_url" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Urutan</label>
                                <input type="number" name="sort_order" class="form-control" id="edit_order">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Target</label>
                                <select name="target" class="form-select" id="edit_target">
                                    <option value="_self">Jendela Sama</option>
                                    <option value="_blank">Jendela Baru</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="edit_is_active">
                            <label class="form-check-label" for="edit_is_active">Aktif</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Perbarui Link</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Feature Modal -->
    <div class="modal fade" id="addFeatureModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?= base_url('admin/homepage/add-feature') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Fitur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Kelas Ikon <span class="text-danger">*</span></label>
                            <input type="text" name="icon_class" class="form-control"
                                placeholder="misal, uil uil-book-open" required>
                            <small class="text-muted">
                                Gunakan kelas Unicons dari <a href="https://iconscout.com/unicons"
                                    target="_blank">iconscout.com/unicons</a>
                            </small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Judul <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Urutan</label>
                            <input type="number" name="sort_order" class="form-control" value="0">
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="add_feature_active"
                                checked>
                            <label class="form-check-label" for="add_feature_active">Aktif</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah Fitur</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Feature Modal -->
    <div class="modal fade" id="editFeatureModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post" id="editFeatureForm">
                    <?= csrf_field() ?>
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Fitur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Kelas Ikon <span class="text-danger">*</span></label>
                            <input type="text" name="icon_class" class="form-control" id="edit_feature_icon" required>
                            <small class="text-muted">
                                Gunakan kelas Unicons dari <a href="https://iconscout.com/unicons"
                                    target="_blank">iconscout.com/unicons</a>
                            </small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Judul <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" id="edit_feature_title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control" rows="3" id="edit_feature_description"
                                required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Urutan</label>
                            <input type="number" name="sort_order" class="form-control" id="edit_feature_order">
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="edit_feature_active">
                            <label class="form-check-label" for="edit_feature_active">Aktif</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Perbarui Fitur</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?= view('layouts/footer_js', ['includeCharts' => false]) ?>

    <script>
        // Edit nav link modal
        document.querySelectorAll('.edit-nav-link').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;
                const label = this.dataset.label;
                const url = this.dataset.url;
                const order = this.dataset.order;
                const target = this.dataset.target;
                const active = this.dataset.active === '1';

                document.getElementById('edit_label').value = label;
                document.getElementById('edit_url').value = url;
                document.getElementById('edit_order').value = order;
                document.getElementById('edit_target').value = target;
                document.getElementById('edit_is_active').checked = active;
                document.getElementById('editNavLinkForm').action = '<?= base_url('admin/homepage/update-nav-link') ?>/' + id;

                new bootstrap.Modal(document.getElementById('editNavLinkModal')).show();
            });
        });

        // Edit feature modal
        document.querySelectorAll('.edit-feature').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;
                const icon = this.dataset.icon;
                const title = this.dataset.title;
                const description = this.dataset.description;
                const order = this.dataset.order;
                const active = this.dataset.active === '1';

                document.getElementById('edit_feature_icon').value = icon;
                document.getElementById('edit_feature_title').value = title;
                document.getElementById('edit_feature_description').value = description;
                document.getElementById('edit_feature_order').value = order;
                document.getElementById('edit_feature_active').checked = active;
                document.getElementById('editFeatureForm').action = '<?= base_url('admin/homepage/update-feature') ?>/' + id;

                new bootstrap.Modal(document.getElementById('editFeatureModal')).show();
            });
        });
    </script>

</body>

</html>