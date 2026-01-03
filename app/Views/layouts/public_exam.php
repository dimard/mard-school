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
        .page-header {
            padding: 8rem 0 4rem 0;
            background-color: var(--primary-color, #1a374d);
            margin-bottom: 2rem;
        }

        .page-header h1 {
            color: #fff;
            font-weight: 700;
        }

        .text-white-opacity {
            color: rgba(255, 255, 255, 0.8);
        }
    </style>
    <?= $this->renderSection('styles') ?>
</head>

<body>

    <div class="site-mobile-menu">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close">
                <span class="icofont-close js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div>

    <nav class="site-nav mb-5">
        <div class="pb-2 top-bar mb-3">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-6 col-lg-9">
                        <a href="#" class="small mr-3"><span class="icon-question-circle-o mr-2"></span> <span
                                class="d-none d-lg-inline-block">Ada pertanyaan?</span></a>
                        <a href="tel:<?= esc($settings['contact_phone'] ?? '') ?>" class="small mr-3"><span
                                class="icon-phone mr-2"></span> <span class="d-none d-lg-inline-block">
                                <?= esc($settings['contact_phone'] ?? '') ?>
                            </span></a>
                        <a href="mailto:<?= esc($settings['contact_email'] ?? '') ?>" class="small mr-3"><span
                                class="icon-envelope mr-2"></span> <span class="d-none d-lg-inline-block">
                                <?= esc($settings['contact_email'] ?? '') ?>
                            </span></a>
                    </div>
                    <div class="col-6 col-lg-3 text-right">
                        <a href="<?= base_url('auth/login') ?>" class="small mr-3">
                            <span class="icon-lock"></span>
                            Masuk
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="container position-relative">
                <div class="site-navigation text-center">
                    <a href="<?= base_url('/') ?>" class="logo multiline menu-absolute m-0">
                        <?= esc($settings['site_name'] ?? 'Learner') ?><span class="text-primary">.</span>
                    </a>

                    <ul class="js-clone-nav d-none d-lg-inline-block site-menu">
                        <li><a href="<?= base_url('/') ?>">Beranda</a></li>
                        <li class="active"><a href="<?= base_url('/ujian') ?>">Ujian Publik</a></li>
                        <?php if (!empty($nav_links)): ?>
                            <?php foreach ($nav_links as $link): ?>
                                <li><a href="<?= esc($link['url']) ?>" target="<?= esc($link['target']) ?>">
                                        <?= esc($link['label']) ?>
                                    </a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>

                    <a href="#"
                        class="burger ml-auto float-right site-menu-toggle js-menu-toggle d-inline-block d-lg-none light"
                        data-toggle="collapse" data-target="#main-navbar">
                        <span></span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <?= $this->renderSection('content') ?>

    <div class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 mr-auto">
                    <div class="widget">
                        <h3>
                            <?= esc($settings['site_name'] ?? 'School System') ?><span class="text-primary">.</span>
                        </h3>
                        <p>
                            <?= esc($settings['site_tagline'] ?? '') ?>
                        </p>
                    </div>
                </div>
                <div class="col-lg-2 ml-auto">
                    <div class="widget">
                        <h3>Tautan Cepat</h3>
                        <ul class="list-unstyled float-left links">
                            <li><a href="<?= base_url('/') ?>">Beranda</a></li>
                            <li><a href="<?= base_url('/ujian') ?>">Ujian Publik</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="widget">
                        <h3>Kontak</h3>
                        <address>
                            <?= esc($settings['school_address'] ?? '') ?>
                        </address>
                        <ul class="list-unstyled links mb-4">
                            <li><a href="tel:<?= esc($settings['contact_phone'] ?? '') ?>">
                                    <?= esc($settings['contact_phone'] ?? '') ?>
                                </a></li>
                            <li><a href="mailto:<?= esc($settings['contact_email'] ?? '') ?>">
                                    <?= esc($settings['contact_email'] ?? '') ?>
                                </a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <p>Hak Cipta &copy;
                        <script>document.write(new Date().getFullYear());</script>. Dilindungi Undang-Undang. &mdash;
                        <?= esc($settings['site_name'] ?? 'School System') ?> Designed & Developed By Dimard Nugroho | Instagram : @dimardnugroho
                    </p>
                </div>
            </div>
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
    <script src="<?= base_url('learner/js/owl.carousel.min.js') ?>"></script>
    <script src="<?= base_url('learner/js/jquery.animateNumber.min.js') ?>"></script>
    <script src="<?= base_url('learner/js/jquery.waypoints.min.js') ?>"></script>
    <script src="<?= base_url('learner/js/jquery.fancybox.min.js') ?>"></script>
    <script src="<?= base_url('learner/js/jquery.sticky.js') ?>"></script>
    <script src="<?= base_url('learner/js/aos.js') ?>"></script>
    <script src="<?= base_url('learner/js/custom.js') ?>"></script>
    <?= $this->renderSection('scripts') ?>

</body>

</html>