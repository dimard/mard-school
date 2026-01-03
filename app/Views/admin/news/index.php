<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Manajemen Berita']) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>
    <?= view('layouts/sidebar') ?>
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Manajemen Berita',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'admin/dashboard'],
                    ['label' => 'Berita']
                ]
            ]) ?>

            <div class="row mb-3">
                <div class="col-12 text-end">
                    <a href="<?= base_url('admin/news/create') ?>" class="btn btn-primary">
                        <i class="ph ph-newspaper me-2"></i>Posting Berita
                    </a>
                </div>
            </div>

            <div class="row g-4">
                <?php if (isset($news) && !empty($news)): ?>
                    <?php foreach ($news as $item): ?>
                        <div class="col-md-4 col-sm-6">
                            <div class="card h-100 shadow-none border">
                                <div class="position-relative">
                                    <img src="<?= $item['thumbnail'] ? base_url('uploads/news/' . $item['thumbnail']) : 'https://placehold.co/600x400?text=No+Image' ?>"
                                        class="card-img-top" alt="News Image" style="height: 200px; object-fit: cover;">
                                    <?php if (isset($item['is_published'])): ?>
                                        <div class="position-absolute top-0 end-0 p-2">
                                            <span class="badge bg-<?= $item['is_published'] ? 'success' : 'warning' ?>">
                                                <?= $item['is_published'] ? 'Diterbitkan' : 'Draf' ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <small class="text-muted"><i class="ph ph-calendar-blank me-1"></i>
                                            <?= date('d M Y', strtotime($item['created_at'])) ?></small>
                                        <small class="text-muted"><i class="ph ph-eye me-1"></i>
                                            <?= $item['views'] ?? 0 ?></small>
                                    </div>
                                    <h5 class="card-title text-truncate" title="<?= esc($item['title']) ?>">
                                        <?= esc($item['title']) ?>
                                    </h5>
                                    <p class="card-text text-muted small"
                                        style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                        <?= esc(strip_tags($item['content'])) ?>
                                    </p>
                                </div>
                                <div class="card-footer bg-light-primary border-0 d-flex justify-content-between">
                                    <a href="<?= base_url('admin/news/edit/' . $item['id']) ?>"
                                        class="btn btn-sm btn-link-primary font-weight-bold">
                                        <i class="ph ph-pencil-simple me-1"></i> Edit
                                    </a>
                                    <a href="<?= base_url('admin/news/delete/' . $item['id']) ?>"
                                        class="btn btn-sm btn-link-danger font-weight-bold"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                        <i class="ph ph-trash me-1"></i> Hapus
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <i class="ph ph-newspaper opacity-25" style="font-size: 3rem;"></i>
                                <p class="mt-2 text-muted">Tidak ada artikel berita ditemukan.</p>
                                <a href="<?= base_url('admin/news/create') ?>" class="btn btn-sm btn-primary mt-2">Buat
                                    Posting Pertama</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?= view('layouts/footer_js') ?>
</body>

</html>