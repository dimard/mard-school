<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="mb-0"><?= esc($pageTitle ?? 'Page') ?></h5>
                </div>
            </div>
            <?php if (isset($breadcrumbs) && is_array($breadcrumbs)): ?>
                <div class="col-md-12">
                    <ul class="breadcrumb mb-0">
                        <?php foreach ($breadcrumbs as $index => $breadcrumb): ?>
                            <?php if ($index === array_key_last($breadcrumbs)): ?>
                                <li class="breadcrumb-item" aria-current="page"><?= esc($breadcrumb['label']) ?></li>
                            <?php else: ?>
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url($breadcrumb['url'] ?? '#') ?>"><?= esc($breadcrumb['label']) ?></a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->