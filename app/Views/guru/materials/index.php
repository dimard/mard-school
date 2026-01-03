<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Materi Saya']) ?>
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
                ['label' => 'Kelas Saya', 'url' => 'guru/classes', 'icon' => 'ph ph-chalkboard'],
                ['label' => 'Materi', 'url' => 'guru/materials', 'icon' => 'ph ph-book-open-text', 'active' => true],
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
        'homeUrl' => 'guru/dashboard'
    ]) ?>
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Materi Saya',
                'breadcrumbs' => [
                    ['label' => 'Dashboard', 'url' => 'guru/dashboard'],
                    ['label' => 'Materi']
                ]
            ]) ?>

            <div class="row mb-3">
                <div class="col-12 text-end">
                    <a href="<?= base_url('guru/materials/upload') ?>" class="btn btn-primary">
                        <i class="ph ph-upload-simple me-2"></i>Unggah Materi Baru
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Materi Pembelajaran</h5>
                        </div>
                        <div class="card-body">
                            <?php if (session()->getFlashdata('message')): ?>
                                <div class="alert alert-success alert-dismissible fade show">
                                    <i class="ph ph-check-circle me-2"></i><?= session()->getFlashdata('message') ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <?php if (session()->getFlashdata('error')): ?>
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <i class="ph ph-warning-circle me-2"></i><?= session()->getFlashdata('error') ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>Detail Materi</th>
                                            <th>Kategori</th>
                                            <th>Tipe & Ukuran</th>
                                            <th>Statistik</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($materials)): ?>
                                            <tr>
                                                <td colspan="5" class="text-center py-5 text-muted">
                                                    <i class="ph ph-books opacity-25" style="font-size: 3rem;"></i>
                                                    <p class="mt-2">Belum ada materi pembelajaran yang diunggah.</p>
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($materials as $item): ?>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <?php
                                                            $icon = 'ph-file';
                                                            $color = 'text-primary';
                                                            $ext = strtolower($item['file_type']);
                                                            if (in_array($ext, ['pdf'])) {
                                                                $icon = 'ph-file-pdf';
                                                                $color = 'text-danger';
                                                            } elseif (in_array($ext, ['doc', 'docx'])) {
                                                                $icon = 'ph-file-doc';
                                                                $color = 'text-primary';
                                                            } elseif (in_array($ext, ['xls', 'xlsx'])) {
                                                                $icon = 'ph-file-xls';
                                                                $color = 'text-success';
                                                            } elseif (in_array($ext, ['ppt', 'pptx'])) {
                                                                $icon = 'ph-presentation';
                                                                $color = 'text-warning';
                                                            }
                                                            ?>
                                                            <div class="fs-3 me-3 <?= $color ?>"><i class="ph <?= $icon ?>"></i>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0 fw-bold"><?= esc($item['title']) ?></h6>
                                                                <small class="text-muted d-block text-truncate"
                                                                    style="max-width: 250px;">
                                                                    <?= esc($item['description'] ?: 'Tidak ada deskripsi') ?>
                                                                </small>
                                                                <small class="text-muted"><i
                                                                        class="ph ph-calendar-blank me-1"></i>
                                                                    <?= date('d M Y', strtotime($item['created_at'])) ?></small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><span
                                                            class="badge bg-light-primary text-primary"><?= esc($item['category']) ?></span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="text-uppercase fw-bold fs-7"><?= esc($item['file_type']) ?></span>
                                                        <span
                                                            class="text-muted ms-1 fs-7">(<?= number_format($item['file_size'] / 1024, 1) ?>
                                                            KB)</span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center text-muted">
                                                            <i class="ph ph-download-simple me-1"></i>
                                                            <?= $item['download_count'] ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="<?= base_url('guru/materials/delete/' . $item['id']) ?>"
                                                            class="btn btn-sm btn-light-danger"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus materi ini?')"
                                                            data-bs-toggle="tooltip" title="Hapus">
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
            </div>
        </div>
    </div>

    <?= view('layouts/footer_js') ?>
</body>

</html>