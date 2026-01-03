<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="<?= esc($settings['site_name'] ?? 'School System') ?>">
    <link rel="shortcut icon" href="<?= base_url('learner/favicon.png') ?>">

    <meta name="description" content="Public CBT Portal" />

    <link
        href="https://fonts.googleapis.com/css2?family=Display+Playfair:wght@400;700&family=Inter:wght@400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <link rel="stylesheet" href="<?= base_url('learner/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('learner/css/animate.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('learner/css/owl.carousel.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('learner/css/owl.theme.default.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('learner/fonts/icomoon/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('learner/fonts/flaticon/font/flaticon.css') ?>">
    <link rel="stylesheet" href="<?= base_url('learner/css/aos.css') ?>">
    <link rel="stylesheet" href="<?= base_url('learner/css/style.css') ?>">

    <!-- Dynamic Theme CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/theme-dynamic.css') ?>?v=<?= time() ?>">

    <title>
        <?= $title ?? 'Public Exam' ?> -
        <?= esc($settings['site_name'] ?? 'School System') ?>
    </title>

    <style>
        /* Specific overrides for focus mode */
        body {
            background-color: #f8f9fa;
        }

        .text-white-opacity {
            color: rgba(255, 255, 255, 0.8);
        }
    </style>
    <?= $this->renderSection('styles') ?>
</head>

<body>

    <!-- Minimal Header / No Navbar -->

    <?= $this->renderSection('content') ?>

    <div class="site-footer mt-5 py-4">
        <div class="container text-center">
            <p class="small text-muted mb-0">
                &copy;
                <?= date('Y') ?>
                <?= esc($settings['site_name'] ?? 'School System') ?>. Hak Cipta Dilindungi Undang-Undang.
            </p>
        </div>
    </div>

    <div id="overlayer"></div>
    <div class="loader">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <script src="<?= base_url('learner/js/jquery-3.4.1.min.js') ?>"></script>
    <script src="<?= base_url('learner/js/popper.min.js') ?>"></script>
    <script src="<?= base_url('learner/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('learner/js/jquery.animateNumber.min.js') ?>"></script>
    <script src="<?= base_url('learner/js/jquery.waypoints.min.js') ?>"></script>
    <script src="<?= base_url('learner/js/jquery.fancybox.min.js') ?>"></script>
    <script src="<?= base_url('learner/js/jquery.sticky.js') ?>"></script>
    <script src="<?= base_url('learner/js/aos.js') ?>"></script>
    <script src="<?= base_url('learner/js/custom.js') ?>"></script>
    <?= $this->renderSection('scripts') ?>

</body>

</html>