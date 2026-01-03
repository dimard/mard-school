<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Detail Pendaftar']) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>
    <?= view('layouts/sidebar') ?>
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Detail Pendaftar',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'admin/dashboard'],
                    ['label' => 'PPDB', 'url' => 'admin/ppdb'],
                    ['label' => 'Detail']
                ]
            ]) ?>

            <div class="row">
                <!-- Personal Info -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5>Data Pribadi</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="200">No. Registrasi</th>
                                    <td><strong><?= esc($registration['registration_number']) ?></strong></td>
                                </tr>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td><?= esc($registration['full_name']) ?></td>
                                </tr>
                                <tr>
                                    <th>NIK</th>
                                    <td><?= esc($registration['nik']) ?></td>
                                </tr>
                                <tr>
                                    <th>Tempat, Tanggal Lahir</th>
                                    <td><?= esc($registration['birth_place']) ?>,
                                        <?= date('d F Y', strtotime($registration['birth_date'])) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td><?= $registration['gender'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?= esc($registration['email']) ?></td>
                                </tr>
                                <tr>
                                    <th>No. HP</th>
                                    <td><?= esc($registration['phone']) ?></td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td><?= nl2br(esc($registration['address'])) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5>Data Orang Tua/Wali</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="200">Nama Orang Tua/Wali</th>
                                    <td><?= esc($registration['parent_name']) ?></td>
                                </tr>
                                <tr>
                                    <th>No. HP Orang Tua</th>
                                    <td><?= esc($registration['parent_phone']) ?></td>
                                </tr>
                                <tr>
                                    <th>Pekerjaan</th>
                                    <td><?= esc($registration['parent_occupation'] ?? '-') ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5>Data Pendidikan</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="200">Asal Sekolah</th>
                                    <td><?= esc($registration['previous_school']) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Documents & Status -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Status</h5>
                        </div>
                        <div class="card-body">
                            <?php
                            $badgeClass = [
                                'pending' => 'bg-warning',
                                'verified' => 'bg-info',
                                'approved' => 'bg-success',
                                'rejected' => 'bg-danger',
                            ];
                            $statusLabel = [
                                'pending' => 'Menunggu',
                                'verified' => 'Terverifikasi',
                                'approved' => 'Diterima',
                                'rejected' => 'Ditolak',
                            ];
                            ?>
                            <h4><span class="badge <?= $badgeClass[$registration['status']] ?? 'bg-secondary' ?>">
                                    <?= $statusLabel[$registration['status']] ?? ucfirst($registration['status']) ?>
                                </span></h4>

                            <p class="text-muted small mb-3">Tanggal Daftar:
                                <?= date('d M Y H:i', strtotime($registration['created_at'])) ?>
                            </p>

                            <form action="<?= base_url('admin/ppdb/update-status/' . $registration['id']) ?>"
                                method="POST">
                                <?= csrf_field() ?>
                                <div class="mb-3">
                                    <label class="form-label">Perbarui Status</label>
                                    <select name="status" class="form-select" required>
                                        <option value="pending" <?= $registration['status'] == 'pending' ? 'selected' : '' ?>>Menunggu</option>
                                        <option value="verified" <?= $registration['status'] == 'verified' ? 'selected' : '' ?>>Terverifikasi</option>
                                        <option value="approved" <?= $registration['status'] == 'approved' ? 'selected' : '' ?>>Diterima</option>
                                        <option value="rejected" <?= $registration['status'] == 'rejected' ? 'selected' : '' ?>>Ditolak</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Catatan Admin</label>
                                    <textarea name="admin_notes" class="form-control"
                                        rows="3"><?= esc($registration['admin_notes'] ?? '') ?></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm w-100">Simpan Status</button>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5>Dokumen</h5>
                        </div>
                        <div class="card-body">
                            <?php if ($registration['photo']): ?>
                                <div class="mb-3">
                                    <strong>Pas Foto:</strong><br>
                                    <img src="<?= base_url('uploads/ppdb/' . $registration['photo']) ?>"
                                        class="img-thumbnail mt-2" style="max-width: 200px;">
                                </div>
                            <?php endif; ?>

                            <?php if ($registration['document_ijazah']): ?>
                                <div class="mb-3">
                                    <strong>Ijazah:</strong><br>
                                    <a href="<?= base_url('uploads/ppdb/' . $registration['document_ijazah']) ?>"
                                        target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                        <i class="ph ph-file-pdf"></i> Lihat Dokumen
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if ($registration['document_kk']): ?>
                                <div class="mb-3">
                                    <strong>Kartu Keluarga:</strong><br>
                                    <a href="<?= base_url('uploads/ppdb/' . $registration['document_kk']) ?>"
                                        target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                        <i class="ph ph-file-pdf"></i> Lihat Dokumen
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if ($registration['document_akta']): ?>
                                <div class="mb-3">
                                    <strong>Akta Kelahiran:</strong><br>
                                    <a href="<?= base_url('uploads/ppdb/' . $registration['document_akta']) ?>"
                                        target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                        <i class="ph ph-file-pdf"></i> Lihat Dokumen
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <a href="<?= base_url('admin/ppdb') ?>" class="btn btn-secondary btn-sm w-100">
                                <i class="ph ph-arrow-left me-1"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= view('layouts/footer_js') ?>
</body>

</html>