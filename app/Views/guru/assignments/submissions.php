<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Pengumpulan - ' . esc($assignment['title'])]) ?>
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
        'homeUrl' => 'guru/dashboard'
    ]) ?>
    <?= view('layouts/topbar', ['notificationCount' => 0, 'notifications' => [], 'profileUrl' => 'guru/profile']) ?>
    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Pengumpulan',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'guru/dashboard'],
                    ['label' => esc($class['name']), 'url' => 'guru/classes/view/' . $class['id']],
                    ['label' => 'Tugas', 'url' => 'guru/classes/assignments/' . $class['id']],
                    ['label' => 'Pengumpulan']
                ]
            ]) ?>

            <?php if (session()->getFlashdata('message')): ?>
                <div class="alert alert-success alert-dismissible fade show"><i
                        class="ph ph-check-circle me-2"></i><?= session()->getFlashdata('message') ?><button type="button"
                        class="btn-close" data-bs-dismiss="alert"></button></div>
            <?php endif; ?>

            <div class="card mb-3">
                <div class="card-header bg-primary">
                    <h5 class="text-white mb-1"><?= esc($assignment['title']) ?></h5>
                    <small class="text-white-50">Tenggat: <?= date('d M Y, H:i', strtotime($assignment['deadline'])) ?>
                        | Nilai Maks: <?= $assignment['max_score'] ?></small>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>Pengumpulan Siswa (<?= count($submissions) ?>)</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($submissions)): ?>
                        <div class="text-center py-4">
                            <p class="text-muted">Belum ada pengumpulan</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Siswa</th>
                                        <th>Dikumpulkan</th>
                                        <th>Berkas</th>
                                        <th>Nilai</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($submissions as $sub): ?>
                                        <tr>
                                            <td><strong><?= esc($sub['full_name']) ?></strong><br><small
                                                    class="text-muted"><?= esc($sub['nis']) ?></small></td>
                                            <td><?= date('d M Y, H:i', strtotime($sub['submitted_at'])) ?></td>
                                            <td>
                                                <?php if ($sub['file_path']): ?>
                                                    <a href="<?= base_url($sub['file_path']) ?>" target="_blank"
                                                        class="btn btn-sm btn-outline-primary"><i class="ph ph-download"></i>
                                                        Unduh</a>
                                                <?php else: ?>
                                                    <span class="text-muted">Tidak ada berkas</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($sub['score'] !== null): ?>
                                                    <span
                                                        class="badge bg-success"><?= $sub['score'] ?>/<?= $assignment['max_score'] ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Belum dinilai</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#gradeModal<?= $sub['id'] ?>"><i
                                                        class="ph ph-clipboard-text"></i> Nilai</button>
                                            </td>
                                        </tr>

                                        <!-- Grade Modal -->
                                        <div class="modal fade" id="gradeModal<?= $sub['id'] ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Beri Nilai: <?= esc($sub['full_name']) ?></h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form
                                                        action="<?= base_url('guru/assignments/submissions/' . $sub['id'] . '/grade') ?>"
                                                        method="POST">
                                                        <?= csrf_field() ?>
                                                        <div class="modal-body">
                                                            <?php if ($sub['submission_text']): ?>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Teks Pengumpulan:</label>
                                                                    <div class="p-3 bg-light rounded">
                                                                        <?= nl2br(esc($sub['submission_text'])) ?>
                                                                    </div>
                                                                </div>
                                                            <?php endif; ?>
                                                            <div class="mb-3">
                                                                <label class="form-label">Nilai (Maks:
                                                                    <?= $assignment['max_score'] ?>)</label>
                                                                <input type="number" class="form-control" name="score"
                                                                    value="<?= $sub['score'] ?>" min="0"
                                                                    max="<?= $assignment['max_score'] ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Umpan Balik (Opsional)</label>
                                                                <textarea class="form-control" name="feedback"
                                                                    rows="3"><?= esc($sub['feedback']) ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan Nilai</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?= view('layouts/footer_js', ['includeCharts' => false]) ?>
</body>

</html>