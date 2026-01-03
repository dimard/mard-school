<!doctype html>
<html lang="en">
<head>
    <?= view('layouts/head_meta', [
        'pageTitle' => 'Edit Pengumuman',
        'metaDescription' => 'Edit Pengumuman'
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
    
    <?= view('layouts/sidebar', ['menuItems' => $menuItems, 'homeUrl' => 'guru/dashboard']) ?>
    <?= view('layouts/topbar', ['notificationCount' => 0, 'notifications' => [], 'profileUrl' => 'guru/profile']) ?>

    <div class="pc-container">
        <div class="pc-content">
            
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Edit Pengumuman',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'guru/dashboard'],
                    ['label' => 'Kelas', 'url' => 'guru/classes'],
                    ['label' => esc($class['name']), 'url' => 'guru/classes/view/' . $class['id']],
                    ['label' => 'Pengumuman', 'url' => 'guru/classes/announcements/' . $class['id']],
                    ['label' => 'Edit']
                ]
            ]) ?>

            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Edit Pengumuman</h5>
                        </div>
                        <div class="card-body">
                            <?php if (session()->has('errors')): ?>
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        <?php foreach (session('errors') as $error): ?>
                                            <li><?= esc($error) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <form action="<?= base_url('guru/announcements/update/' . $announcement['id']) ?>" method="POST">
                                <?= csrf_field() ?>
                                
                                <div class="mb-3">
                                    <label for="title" class="form-label">Judul <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="title" 
                                           name="title"
                                           value="<?= old('title', $announcement['title']) ?>"
                                           required>
                                </div>

                                <div class="mb-3">
                                    <label for="content" class="form-label">Konten <span class="text-danger">*</span></label>
                                    <textarea class="form-control" 
                                              id="content" 
                                              name="content" 
                                              rows="8"
                                              required><?= old('content', $announcement['content']) ?></textarea>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ph ph-check me-2"></i>Perbarui Pengumuman
                                    </button>
                                    <a href="<?= base_url('guru/classes/announcements/' . $class['id']) ?>" class="btn btn-secondary">
                                        Batal
                                    </a>
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
