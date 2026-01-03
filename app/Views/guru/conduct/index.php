<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Input Perilaku Siswa']) ?>
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
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Perilaku Siswa',
                'breadcrumbs' => [
                    ['label' => 'Dashboard', 'url' => 'guru/dashboard'],
                    ['label' => 'Input Perilaku']
                ]
            ]) ?>

            <div class="card mb-4">
                <div class="card-body">
                    <form method="get" action="" class="row align-items-center">
                        <div class="col-md-4">
                            <label class="form-label">Pilih Kelas untuk Dikelola</label>
                            <select name="class_id" class="form-select" onchange="this.form.submit()">
                                <option value="">-- Pilih Kelas --</option>
                                <?php foreach ($classes as $cls): ?>
                                    <option value="<?= $cls['id'] ?>" <?= ($selectedClassId == $cls['id']) ? 'selected' : '' ?>>
                                        <?= esc($cls['name']) ?> (<?= esc($cls['code']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <?php if ($selectedClassId && !empty($students)): ?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Daftar Siswa</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Nama Siswa</th>
                                        <th width="150">Nilai (Predikat)</th>
                                        <th>Deskripsi (Catatan Wali Kelas)</th>
                                        <th width="100">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students as $student): ?>
                                        <?php 
                                            $grade = $student['conduct']['grade'] ?? '';
                                            $desc = $student['conduct']['description'] ?? '';
                                        ?>
                                        <tr>
                                            <td>
                                                <div class="fw-bold"><?= esc($student['full_name']) ?></div>
                                                <small class="text-muted"><?= esc($student['email']) ?></small>
                                            </td>
                                            <td>
                                                <select class="form-select status-grade" id="grade-<?= $student['id'] ?>">
                                                    <option value="">-</option>
                                                    <option value="A" <?= $grade == 'A' ? 'selected' : '' ?>>A (Sangat Baik)</option>
                                                    <option value="B" <?= $grade == 'B' ? 'selected' : '' ?>>B (Baik)</option>
                                                    <option value="C" <?= $grade == 'C' ? 'selected' : '' ?>>C (Cukup)</option>
                                                    <option value="D" <?= $grade == 'D' ? 'selected' : '' ?>>D (Kurang)</option>
                                                </select>
                                            </td>
                                            <td>
                                                <textarea class="form-control" rows="2" id="desc-<?= $student['id'] ?>" placeholder="Masukkan deskripsi perilaku..."><?= esc($desc) ?></textarea>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm save-conduct" data-id="<?= $student['id'] ?>">
                                                    <i class="ph ph-floppy-disk me-1"></i> Simpan
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php elseif ($selectedClassId): ?>
                <div class="alert alert-info">Tidak ditemukan siswa di kelas ini.</div>
            <?php endif; ?>
        </div>
    </div>

    <?= view('layouts/footer_js') ?>

    <script>
        $(document).ready(function() {
            $('.save-conduct').click(function() {
                const btn = $(this);
                const studentId = btn.data('id');
                const classId = '<?= $selectedClassId ?>';
                const grade = $('#grade-' + studentId).val();
                const desc = $('#desc-' + studentId).val();

                if(!grade || !desc) {
                    alert('Mohon isi Nilai dan Deskripsi');
                    return;
                }

                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

                $.post('<?= base_url('guru/conduct/save') ?>', {
                    student_id: studentId,
                    class_id: classId,
                    grade: grade,
                    description: desc
                }, function(response) {
                    btn.prop('disabled', false).html('<i class="ph ph-check me-1"></i> Tersimpan');
                    setTimeout(() => {
                        btn.html('<i class="ph ph-floppy-disk me-1"></i> Simpan');
                    }, 2000);
                    
                    if(response.success) {
                        // Optional toast here
                    } else {
                        alert('Gagal: ' + response.message);
                    }
                });
            });
        });
    </script>
</body>
</html>
