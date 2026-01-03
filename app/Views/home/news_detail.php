<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="<?= esc($settings['site_name'] ?? 'School System') ?>">
    <link rel="shortcut icon" href="<?= base_url('learner/favicon.png') ?>">

    <meta name="description" content="<?= esc(substr(strip_tags($news['content']), 0, 160)) ?>" />

    <link
        href="https://fonts.googleapis.com/css2?family=Display+Playfair:wght@400;700&family=Inter:wght@400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <link rel="stylesheet" href="<?= base_url('learner/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('learner/css/animate.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('learner/css/owl.carousel.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('learner/css/owl.theme.default.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('learner/css/jquery.fancybox.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('learner/fonts/icomoon/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('learner/fonts/flaticon/font/flaticon.css') ?>">
    <link rel="stylesheet" href="<?= base_url('learner/css/aos.css') ?>">
    <link rel="stylesheet" href="<?= base_url('learner/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('learner/css/custom-responsive.css?v=' . time()) ?>">

    <!-- Dynamic Theme CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/theme-dynamic.css') ?>?v=<?= time() ?>">

    <title><?= esc($news['title']) ?> - <?= esc($settings['site_name'] ?? 'Learner') ?></title>
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
                                class="d-none d-lg-inline-block">Have a questions?</span></a>
                        <a href="tel:<?= esc($settings['contact_phone'] ?? '') ?>" class="small mr-3"><span
                                class="icon-phone mr-2"></span> <span
                                class="d-none d-lg-inline-block"><?= esc($settings['contact_phone'] ?? '10 20 123 456') ?></span></a>
                        <a href="mailto:<?= esc($settings['contact_email'] ?? '') ?>" class="small mr-3"><span
                                class="icon-envelope mr-2"></span> <span
                                class="d-none d-lg-inline-block"><?= esc($settings['contact_email'] ?? 'info@mydomain.com') ?></span></a>
                    </div>

                    <div class="col-6 col-lg-3 text-right">
                        <a href="<?= base_url('auth/login') ?>" class="small mr-3">
                            <span class="icon-lock"></span>
                            Log In
                        </a>
                        <a href="<?= base_url('auth/login') ?>" class="small">
                            <span class="icon-person"></span>
                            Register
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <div class="sticky-nav js-sticky-header">
            <div class="container position-relative">
                <div class="site-navigation text-center">
                    <a href="<?= base_url('/') ?>"
                        class="logo menu-absolute m-0"><?= esc($settings['site_name'] ?? 'Learner') ?><span
                            class="text-primary">.</span></a>

                    <ul class="js-clone-nav d-none d-lg-inline-block site-menu">
                        <li><a href="<?= base_url('/') ?>">Home</a></li>
                        <?php if (!empty($nav_links)): ?>
                            <?php foreach ($nav_links as $link): ?>
                                <li><a href="<?= base_url('/') . esc($link['url']) ?>"><?= esc($link['label']) ?></a></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li><a href="<?= base_url('/') ?>#about">About</a></li>
                            <li><a href="<?= base_url('/') ?>#staff-section">Our Team</a></li>
                            <li class="active"><a href="<?= base_url('/') ?>#news">News</a></li>
                            <li><a href="<?= base_url('/') ?>#gallery">Gallery</a></li>
                            <li><a href="<?= base_url('/') ?>#contact">Contact</a></li>
                        <?php endif; ?>
                    </ul>

                    <a href="<?= base_url('auth/login') ?>"
                        class="btn-book btn btn-secondary btn-sm menu-absolute">Portal Login</a>

                    <a href="#"
                        class="burger ml-auto float-right site-menu-toggle js-menu-toggle d-inline-block d-lg-none light"
                        data-toggle="collapse" data-target="#main-navbar">
                        <span></span>
                    </a>

                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="untree_co-hero inner-page overlay"
        style="background-image: url('<?= base_url('learner/images/img-school-5-min.jpg') ?>');">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-lg-10 text-center">
                            <span class="d-block mb-3 text-white" data-aos="fade-up"
                                data-aos-delay="0"><?= date('F d, Y', strtotime($news['published_at'] ?? $news['created_at'])) ?>
                                <span class="mx-2 text-primary">&bullet;</span> By
                                <?= esc($news['author_name'] ?? 'Admin') ?></span>
                            <h1 class="mb-4 heading text-white" data-aos="fade-up" data-aos-delay="100">
                                <?= esc($news['title']) ?>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- News Content -->
    <div class="untree_co-section">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-lg-8">
                    <?php if (!empty($news['thumbnail'])): ?>
                        <div class="mb-5" data-aos="fade-up" data-aos-delay="0">
                            <img src="<?= base_url('uploads/news/' . esc($news['thumbnail'])) ?>"
                                alt="<?= esc($news['title']) ?>" class="img-fluid rounded">
                        </div>
                    <?php endif; ?>

                    <div class="news-content" data-aos="fade-up" data-aos-delay="100">
                        <?= $news['content'] ?>
                    </div>

                    <div class="mt-5 pt-5 border-top" data-aos="fade-up" data-aos-delay="200">
                        <a href="<?= base_url('/') ?>#news" class="btn btn-primary">Back to News</a>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="widget mb-5" data-aos="fade-up" data-aos-delay="0">
                        <h3 class="widget-title">Recent News</h3>
                        <?php if (!empty($recent_news)): ?>
                            <ul class="list-unstyled">
                                <?php foreach ($recent_news as $item): ?>
                                    <li class="mb-4">
                                        <a href="<?= base_url('news/' . esc($item['slug'])) ?>"
                                            class="d-flex align-items-start">
                                            <?php if (!empty($item['thumbnail'])): ?>
                                                <img src="<?= base_url('uploads/news/' . esc($item['thumbnail'])) ?>" alt="Image"
                                                    class="img-fluid mr-3"
                                                    style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px;">
                                            <?php endif; ?>
                                            <div>
                                                <span
                                                    class="d-block small text-muted mb-1"><?= date('M d, Y', strtotime($item['created_at'])) ?></span>
                                                <h5 class="h6 mb-0 text-black"><?= esc($item['title']) ?></h5>
                                            </div>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>

                    <div class="widget" data-aos="fade-up" data-aos-delay="100">
                        <h3 class="widget-title">Connect</h3>
                        <ul class="list-unstyled social">
                            <li><a href="#"><span class="icon-instagram"></span></a></li>
                            <li><a href="#"><span class="icon-twitter"></span></a></li>
                            <li><a href="#"><span class="icon-facebook"></span></a></li>
                            <li><a href="#"><span class="icon-linkedin"></span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 mr-auto">
                    <div class="widget">
                        <h3><?= esc($settings['site_name'] ?? 'Learner') ?><span class="text-primary">.</span> </h3>
                        <p><?= esc($settings['site_tagline'] ?? 'Modern education management system for schools and institutions.') ?>
                        </p>
                    </div>
                    <div class="widget">
                        <h3>Connect</h3>
                        <ul class="list-unstyled social">
                            <li><a href="#"><span class="icon-instagram"></span></a></li>
                            <li><a href="#"><span class="icon-twitter"></span></a></li>
                            <li><a href="#"><span class="icon-facebook"></span></a></li>
                            <li><a href="#"><span class="icon-linkedin"></span></a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-2 ml-auto">
                    <div class="widget">
                        <h3>Quick Links</h3>
                        <ul class="list-unstyled float-left links">
                            <li><a href="<?= base_url('/') ?>">Home</a></li>
                            <li><a href="<?= base_url('/') ?>#news">News</a></li>
                            <li><a href="<?= base_url('auth/login') ?>">Login</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="widget">
                        <h3>Contact</h3>
                        <address><?= esc($settings['school_address'] ?? 'Indonesia') ?></address>
                        <ul class="list-unstyled links mb-4">
                            <li><a
                                    href="tel:<?= esc($settings['contact_phone'] ?? '') ?>"><?= esc($settings['contact_phone'] ?? '+1(123)-456-7890') ?></a>
                            </li>
                            <li><a
                                    href="mailto:<?= esc($settings['contact_email'] ?? '') ?>"><?= esc($settings['contact_email'] ?? 'info@mydomain.com') ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12 text-center">
                    <p>Copyright &copy;
                        <script>document.write(new Date().getFullYear());</script>. All Rights Reserved. &mdash;
                        <?= esc($settings['site_name'] ?? 'School System') ?> &mdash; Designed & Developed <a
                            href="https://dimardnugroho.web.id">Dimard Nugroho | Instagram : @dimardnugroho</a>
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

</body>

</html>