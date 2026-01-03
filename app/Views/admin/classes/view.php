<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => esc($class['name'])]) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>
    <?= view('layouts/sidebar') ?>
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => esc($class['name']),
                'breadcrumbs' => [
                    ['label' => 'Dashboard', 'url' => 'admin/dashboard'],
                    ['label' => 'Kelas', 'url' => 'admin/classes'],
                    ['label' => esc($class['name'])]
                ]
            ]) ?>

            <div class="row">
                <!-- Left Sidebar - Class Actions -->
                <div class="col-lg-3 col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="text-white mb-2"><?= esc($class['name']) ?></h5>
                            <p class="text-white-50 small mb-3"><?= esc($class['description']) ?></p>
                            <span class="badge bg-white text-primary">
                                Kode: <span class="user-select-all fw-bold"><?= esc($class['code']) ?></span>
                            </span>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Aksi Kelas</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="#" class="btn btn-light-primary text-start disabled">
                                    <i class="ph ph-megaphone me-2"></i>Pengumuman
                                </a>
                                <a href="#" class="btn btn-light-warning text-start disabled">
                                    <i class="ph ph-file-text me-2"></i>Tugas
                                </a>
                                <a href="#" class="btn btn-light-success text-start disabled">
                                    <i class="ph ph-book-open me-2"></i>Materi
                                </a>
                            </div>
                            <div class="mt-3">
                                <small class="text-muted fst-italic">Login sebagai Admin. Fitur manajemen lengkap
                                    tersedia di tampilan Guru.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content - Students List -->
                <div class="col-lg-9 col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Siswa Terdaftar (<?= count($members) ?>)</h5>
                        </div>
                        <div class="card-body">
                            <?php if (empty($members)): ?>
                                <div class="text-center py-5 text-muted">
                                    <i class="ph ph-users opacity-25" style="font-size: 3rem;"></i>
                                    <p class="mt-2">Belum ada siswa terdaftar.</p>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Siswa</th>
                                                <th>NIS</th>
                                                <th>Email</th>
                                                <th>Bergabung</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($members as $member): ?>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avtar avtar-xs btn-light-primary me-2">
                                                                <i class="ph ph-user"></i>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0"><?= esc($member['full_name']) ?></h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><span class="badge bg-light-secondary"><?= esc($member['nis']) ?></span>
                                                    </td>
                                                    <td><?= esc($member['email']) ?></td>
                                                    <td><?= isset($member['joined_at']) ? date('d M Y', strtotime($member['joined_at'])) : '-' ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= view('layouts/footer_js') ?>
</body>

</html>