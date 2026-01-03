<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Pengaturan Kartu Rapor']) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>
    <?= view('layouts/sidebar') ?>
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Pengaturan Kartu Rapor',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'admin/dashboard'],
                    ['label' => 'Laporan', 'url' => 'admin/reports'],
                    ['label' => 'Pengaturan']
                ]
            ]) ?>

            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Sesuaikan Tata Letak Laporan</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('admin/reports/settings') ?>" method="post">
                                <?= csrf_field() ?>

                                <div class="mb-4">
                                    <label class="form-label">Konten Header (HTML)</label>
                                    <small class="d-block text-muted mb-2">Biasanya mencakup Nama Sekolah, Alamat,
                                        Logo, dll.</small>
                                    <textarea name="header_content" class="form-control"
                                        rows="5"><?= esc($settings['header_content']) ?></textarea>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Konten Footer (HTML)</label>
                                    <small class="d-block text-muted mb-2">Biasanya mencakup tanda tangan, tanggal,
                                        nama kepala sekolah.</small>
                                    <textarea name="footer_content" class="form-control"
                                        rows="5"><?= esc($settings['footer_content']) ?></textarea>
                                </div>

                                <div class="mb-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="watermark_enabled"
                                            id="watermark" <?= $settings['watermark_enabled'] ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="watermark">Aktifkan Tanda Air</label>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="<?= base_url('admin/reports') ?>" class="btn btn-light-secondary">Batal</a>
                                    <button type="submit" class="btn btn-primary"><i class="ph ph-check me-2"></i>Simpan
                                        Pengaturan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= view('layouts/footer_js') ?>
</body>

</html>