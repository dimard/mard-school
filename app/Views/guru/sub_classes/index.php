<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', [
        'pageTitle' => 'My Sub Classes',
        'metaDescription' => 'Sub classes I teach'
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
                ['label' => 'Dashboard', 'url' => 'guru/dashboard', 'icon' => 'ph ph-house-line']
            ]
        ],
        [
            'caption' => 'Academic',
            'icon' => 'ph ph-book-open',
            'items' => [
                ['label' => 'My Classes', 'url' => 'guru/classes', 'icon' => 'ph ph-chalkboard'],
                ['label' => 'My Sub Classes', 'url' => 'guru/sub-classes', 'icon' => 'ph ph-books', 'active' => true]
            ]
        ]
    ];
    ?>

    <?= view('layouts/sidebar', ['menuItems' => $menuItems, 'homeUrl' => 'guru/dashboard']) ?>
    <?= view('layouts/topbar', ['notificationCount' => 0, 'notifications' => [], 'profileUrl' => 'guru/profile', 'settingsUrl' => 'guru/settings']) ?>

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">

            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'My Sub Classes',
                'breadcrumbs' => [
                    ['label' => 'Home', 'url' => 'guru/dashboard'],
                    ['label' => 'My Sub Classes']
                ]
            ]) ?>

            <div class="row">
                <div class="col-12">
                    <?php if (session()->has('message')): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <?= session('message') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-header">
                            <h5>Sub Classes Yang Saya Ampu</h5>
                        </div>
                        <div class="card-body">
                            <?php if (empty($subClasses)): ?>
                                <div class="text-center py-5">
                                    <i class="ph ph-books text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                                    <h5 class="mt-3 text-muted">Belum Ada Sub Kelas</h5>
                                    <p class="text-muted">
                                        Anda belum di-assign sebagai guru pengampu untuk sub kelas manapun.<br>
                                        Hubungi wali kelas untuk menambahkan Anda sebagai guru pengampu.
                                    </p>
                                </div>
                            <?php else: ?>
                                <div class="row">
                                    <?php foreach ($subClasses as $subClass): ?>
                                        <div class="col-md-6 col-lg-4 mb-3">
                                            <div class="card border h-100">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <h5 class="mb-1"><?= esc($subClass['subject_name']) ?></h5>
                                                        <span class="badge bg-primary"><?= esc($subClass['code']) ?></span>
                                                    </div>

                                                    <p class="text-muted small mb-2">
                                                        <i class="ph ph-chalkboard me-1"></i><?= esc($subClass['class_name']) ?>
                                                    </p>

                                                    <p class="text-muted small mb-3">
                                                        <i class="ph ph-key me-1"></i>Kelas Code:
                                                        <code><?= esc($subClass['class_code']) ?></code>
                                                    </p>

                                                    <div class="d-grid">
                                                        <a href="<?= base_url('guru/sub-classes/view/' . $subClass['id']) ?>"
                                                            class="btn btn-primary">
                                                            <i class="ph ph-arrow-right me-2"></i>Open Sub Class
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- [ Main Content ] end -->

    <?= view('layouts/footer_js', ['includeCharts' => false]) ?>

</body>

</html>