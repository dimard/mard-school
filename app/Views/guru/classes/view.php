<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', [
        'pageTitle' => esc($class['name']),
        'metaDescription' => 'Detail Kelas - ' . esc($class['name'])
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
    ?>

    <?= view('layouts/sidebar', [
        'menuItems' => $menuItems,
        'homeUrl' => 'guru/dashboard'
    ]) ?>

    <?= view('layouts/topbar', [
        'notificationCount' => 0,
        'notifications' => [],
        'profileUrl' => 'guru/profile',
        'settingsUrl' => 'guru/settings'
    ]) ?>

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">

            <?= view('layouts/breadcrumb', [
                'pageTitle' => esc($class['name']),
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'guru/dashboard'],
                    ['label' => 'Kelas Saya', 'url' => 'guru/classes'],
                    ['label' => esc($class['name'])]
                ]
            ]) ?>

            <!-- Class Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-primary text-white">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h2 class="text-white mb-2"><?= esc($class['name']) ?></h2>
                                    <p class="text-white-50 mb-3"><?= esc($class['description']) ?></p>
                                    <span class="badge bg-white text-primary fs-6 px-3 py-2">
                                        <i class="ph ph-key me-2"></i>Kode Kelas:
                                        <span class="fw-bold user-select-all"><?= esc($class['code']) ?></span>
                                    </span>
                                </div>
                                <div class="d-none d-md-block">
                                    <i class="ph ph-chalkboard-teacher" style="font-size: 5rem; opacity: 0.2;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Left Sidebar - Class Actions -->
                <div class="col-lg-3 col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Aksi Kelas</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <!-- Available Features -->
                                <a href="<?= base_url('guru/classes/announcements/' . $class['id']) ?>"
                                    class="btn btn-primary text-start">
                                    <i class="ph ph-megaphone me-2"></i>Pengumuman
                                    <i class="ph ph-check-circle float-end mt-1"></i>
                                </a>
                                <a href="<?= base_url('guru/classes/assignments/' . $class['id']) ?>"
                                    class="btn btn-warning text-start">
                                    <i class="ph ph-file-text me-2"></i>Tugas
                                    <i class="ph ph-check-circle float-end mt-1"></i>
                                </a>
                                <a href="<?= base_url('guru/materials?class_id=' . $class['id']) ?>"
                                    class="btn btn-success text-start">
                                    <i class="ph ph-book-open me-2"></i>Materi Kelas
                                    <i class="ph ph-check-circle float-end mt-1"></i>
                                </a>

                                <!-- Coming Soon Features -->
                                <a href="<?= base_url('guru/classes/attendance/' . $class['id']) ?>"
                                    class="btn btn-info text-start">
                                    <i class="ph ph-clock me-2"></i>Absensi
                                    <i class="ph ph-check-circle float-end mt-1"></i>
                                </a>
                                <a href="<?= base_url('guru/classes/' . $class['id'] . '/reports') ?>"
                                    class="btn btn-secondary text-start">
                                    <i class="ph ph-chart-bar me-2"></i>Laporan
                                    <i class="ph ph-check-circle float-end mt-1"></i>
                                </a>
                            </div>

                            <div class="alert alert-info mt-3 mb-0" role="alert">
                                <small>
                                    <i class="ph ph-info me-1"></i>
                                    Fitur lainnya sedang dikembangkan
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Class Info Card -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="mb-0">Info Kelas</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0 d-flex justify-content-between">
                                    <span class="text-muted">Siswa</span>
                                    <span class="badge bg-primary rounded-pill"><?= count($members) ?></span>
                                </li>
                                <li class="list-group-item px-0 d-flex justify-content-between">
                                    <span class="text-muted">Dibuat</span>
                                    <span class="small"><?= date('d M Y', strtotime($class['created_at'])) ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Main Content - Students List -->
                <div class="col-lg-9 col-md-8">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link <?= ($tab == 'students') ? 'active' : '' ?>" data-bs-toggle="tab"
                                href="#students" role="tab">
                                <i class="ph ph-users me-1"></i>Siswa (<?= count($members) ?>)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($tab == 'stream') ? 'active' : '' ?>" data-bs-toggle="tab"
                                href="#stream" role="tab">
                                <i class="ph ph-chats-circle me-1"></i>Forum
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($tab == 'subclasses') ? 'active' : '' ?>" data-bs-toggle="tab"
                                href="#subclasses" role="tab">
                                <i class="ph ph-books me-1"></i>Sub Kelas
                                <span class="badge bg-primary ms-1">BARU</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($tab == 'conduct') ? 'active' : '' ?>" data-bs-toggle="tab"
                                href="#conduct" role="tab">
                                <i class="ph ph-star me-1"></i>Perilaku
                                <span class="badge bg-primary ms-1">BARU</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($tab == 'assignments') ? 'active' : '' ?>" data-bs-toggle="tab"
                                href="#assignments" role="tab">
                                <i class="ph ph-file-text me-1"></i>Tugas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($tab == 'reports') ? 'active' : '' ?>" data-bs-toggle="tab"
                                href="#reports" role="tab">
                                <i class="ph ph-chart-bar me-1"></i>Laporan
                            </a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Students Tab -->
                        <div class="tab-pane active" id="students" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Anggota Kelas</h5>
                                </div>
                                <div class="card-body">
                                    <?php if (empty($members)): ?>
                                        <div class="text-center py-5">
                                            <i class="ph ph-users text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                                            <h5 class="mt-3 text-muted">Belum Ada Siswa</h5>
                                            <p class="text-muted">
                                                Bagikan kode kelas <strong><?= esc($class['code']) ?></strong> kepada siswa
                                                Anda
                                            </p>
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
                                                            <td>
                                                                <span
                                                                    class="badge bg-light-secondary"><?= esc($member['nis']) ?></span>
                                                            </td>
                                                            <td><?= esc($member['email']) ?></td>
                                                            <td class="text-muted small">
                                                                <?= isset($member['joined_at']) ? date('d M Y', strtotime($member['joined_at'])) : '-' ?>
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

                        <!-- Stream Tab -->
                        <div class="tab-pane" id="stream" role="tabpanel">
                            <?php if (empty($announcements)): ?>
                                <div class="card">
                                    <div class="card-body text-center py-5">
                                        <i class="ph ph-chats-circle text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                                        <h5 class="mt-3 text-muted">Belum Ada Pengumuman</h5>
                                        <p class="text-muted">
                                            Buat pengumuman untuk berkomunikasi dengan siswa Anda
                                        </p>
                                        <a href="<?= base_url('guru/classes/announcements/' . $class['id']) ?>"
                                            class="btn btn-primary">
                                            <i class="ph ph-megaphone me-2"></i>Buat Pengumuman
                                        </a>
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php foreach ($announcements as $announcement): ?>
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h5 class="mb-1"><?= esc($announcement['title']) ?></h5>
                                                <small
                                                    class="text-muted"><?= date('M d, Y', strtotime($announcement['created_at'])) ?></small>
                                            </div>
                                            <p class="text-muted small mb-2">
                                                <i class="ph ph-user me-1"></i><?= esc($announcement['author_name']) ?>
                                            </p>
                                            <p class="mb-3"><?= nl2br(esc($announcement['content'])) ?></p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-muted small">
                                                    <i class="ph ph-chat-circle me-1"></i><?= $announcement['comment_count'] ?>
                                                    komentar
                                                </span>
                                                <a href="<?= base_url('guru/announcements/view/' . $announcement['id']) ?>"
                                                    class="btn btn-sm btn-light-primary">
                                                    Lihat & Kelola
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <!-- Assignments Tab -->
                        <div class="tab-pane" id="assignments" role="tabpanel">
                            <?php if (empty($assignments)): ?>
                                <div class="card">
                                    <div class="card-body text-center py-5">
                                        <i class="ph ph-file-text text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                                        <h5 class="mt-3 text-muted">Belum Ada Tugas</h5>
                                        <p class="text-muted">
                                            Buat tugas untuk siswa Anda
                                        </p>
                                        <a href="<?= base_url('guru/classes/assignments/' . $class['id']) ?>"
                                            class="btn btn-warning">
                                            <i class="ph ph-file-text me-2"></i>Buat Tugas
                                        </a>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="row">
                                    <?php foreach ($assignments as $assignment): ?>
                                        <div class="col-md-6 mb-3">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <h5 class="mb-1"><?= esc($assignment['title']) ?></h5>
                                                        <?php if (strtotime($assignment['deadline']) < time()): ?>
                                                            <span class="badge bg-danger">Tutup</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-success">Buka</span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <p class="text-muted small mb-2"><?= esc($assignment['description']) ?></p>
                                                    <div
                                                        class="d-flex justify-content-between align-items-center text-muted small mb-3">
                                                        <span><i
                                                                class="ph ph-clock me-1"></i><?= date('M d, Y', strtotime($assignment['deadline'])) ?></span>
                                                        <span><i class="ph ph-trophy me-1"></i><?= $assignment['max_score'] ?>
                                                            pts</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="text-muted small">
                                                            <i
                                                                class="ph ph-check-circle me-1"></i><?= $assignment['submission_count'] ?? 0 ?>
                                                            pengumpulan
                                                        </span>
                                                        <a href="<?= base_url('guru/assignments/submissions/' . $assignment['id']) ?>"
                                                            class="btn btn-sm btn-light-warning">
                                                            Lihat Pengumpulan
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Sub Classes Tab -->
                        <div class="tab-pane <?= ($tab == 'subclasses') ? 'active' : '' ?>" id="subclasses"
                            role="tabpanel">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Sub Kelas (Manajemen Mata Pelajaran)</h5>
                                    <a href="<?= base_url('guru/classes/' . $class['id'] . '/sub-classes/create') ?>"
                                        class="btn btn-primary btn-sm">
                                        <i class="ph ph-plus me-1"></i>Buat Sub Kelas
                                    </a>
                                </div>
                                <div class="card-body">
                                    <?php
                                    $subClassModel = new \App\Models\SubClassModel();
                                    $subClasses = $subClassModel->getByClassWithMemberCount($class['id']);
                                    ?>

                                    <?php if (empty($subClasses)): ?>
                                        <div class="text-center py-5">
                                            <i class="ph ph-books text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                                            <h5 class="mt-3 text-muted">Belum Ada Sub Kelas</h5>
                                            <p class="text-muted">
                                                Buat sub kelas untuk membagi mata pelajaran.<br>
                                                Setiap sub kelas dapat dikelola oleh guru pengampu masing-masing.
                                            </p>
                                            <a href="<?= base_url('guru/classes/' . $class['id'] . '/sub-classes/create') ?>"
                                                class="btn btn-primary">
                                                <i class="ph ph-plus me-2"></i>Buat Sub Kelas Pertama
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <div class="row">
                                            <?php foreach ($subClasses as $subClass): ?>
                                                <div class="col-md-6 mb-3">
                                                    <div class="card border">
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                                <h5 class="mb-1"><?= esc($subClass['subject_name']) ?></h5>
                                                                <span
                                                                    class="badge bg-light-primary"><?= esc($subClass['code']) ?></span>
                                                            </div>

                                                            <p class="text-muted small mb-2">
                                                                <i
                                                                    class="ph ph-user me-1"></i><?= esc($subClass['teacher_name']) ?>
                                                            </p>

                                                            <?php if (!empty($subClass['description'])): ?>
                                                                <p class="text-muted small"><?= esc($subClass['description']) ?></p>
                                                            <?php endif; ?>

                                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                                <span class="text-muted small">
                                                                    <i
                                                                        class="ph ph-users me-1"></i><?= $subClass['member_count'] ?? 0 ?>
                                                                    students
                                                                </span>
                                                                <div class="btn-group btn-group-sm">
                                                                    <a href="<?= base_url('guru/sub-classes/edit/' . $subClass['id']) ?>"
                                                                        class="btn btn-light-primary">
                                                                        <i class="ph ph-pencil"></i>
                                                                    </a>
                                                                    <a href="<?= base_url('guru/sub-classes/delete/' . $subClass['id']) ?>"
                                                                        class="btn btn-light-danger"
                                                                        onclick="return confirm('Hapus sub kelas ini?')">
                                                                        <i class="ph ph-trash"></i>
                                                                    </a>
                                                                </div>
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

                        <!-- Conduct Tab -->
                        <div class="tab-pane <?= ($tab == 'conduct') ? 'active' : '' ?>" id="conduct" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Input Perilaku (Kelakuan Siswa)</h5>
                                </div>
                                <div class="card-body">
                                    <?php if (empty($members)): ?>
                                        <div class="text-center py-5">
                                            <i class="ph ph-star text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                                            <h5 class="mt-3 text-muted">Belum Ada Siswa</h5>
                                            <p class="text-muted">Tambahkan siswa ke kelas ini terlebih dahulu</p>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-info">
                                            <i class="ph ph-info me-2"></i>
                                            <strong>Petunjuk:</strong> Gunakan form ini untuk input kelakuan siswa secara
                                            batch.
                                        </div>
                                        <a href="<?= base_url('guru/classes/' . $class['id'] . '/conduct') ?>"
                                            class="btn btn-primary">
                                            <i class="ph ph-pencil me-2"></i>Buka Formulir Perilaku
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
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