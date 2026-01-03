<!-- /*
* Template Name: Learner
* Template Author: Untree.co
* Tempalte URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="<?= base_url('learner/favicon.png') ?>">

    <meta name="description" content="School Management System - Login" />
    <meta name="keywords" content="school, management, system, login" />

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

    <!-- Dynamic Theme CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/theme-dynamic.css') ?>?v=<?= time() ?>">

    <title>Login - School Management System</title>
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
                        <a href="<?= base_url() ?>" class="small">
                            <span class="icon-home"></span>
                            Home
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <div class="sticky-nav">
            <div class="container position-relative">
                <div class="site-navigation text-center">
                    <a href="<?= base_url('/') ?>"
                        class="logo multiline menu-absolute m-0"><?= esc($settings['site_name'] ?? 'Learner') ?><span
                            class="text-primary">.</span></a>

                    <ul class="js-clone-nav d-none d-lg-inline-block site-menu">
                        <li><a href="<?= base_url('/') ?>">Home</a></li>
                        <?php if (!empty($nav_links)): ?>
                            <?php foreach ($nav_links as $link): ?>
                                <li><a href="<?= esc($link['url']) ?>"
                                        target="<?= esc($link['target']) ?>"><?= esc($link['label']) ?></a></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li><a href="<?= base_url('/news') ?>">News</a></li>
                            <li><a href="#about">About</a></li>
                            <li><a href="<?= base_url('auth/login') ?>">Login</a></li>
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


    <div class="untree_co-hero inner-page overlay"
        style="background-image: url('<?= base_url('learner/images/img-school-5-min.jpg') ?>');">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12">
                    <div class="row justify-content-center ">
                        <div class="col-lg-6 text-center ">
                            <h1 class="mb-4 heading text-white" data-aos="fade-up" data-aos-delay="100">Login</h1>

                        </div>
                    </div>
                </div>
            </div> <!-- /.row -->
        </div> <!-- /.container -->

    </div> <!-- /.untree_co-hero -->




    <div class="untree_co-section">
        <div class="container">

            <div class="row mb-5 justify-content-center">
                <div class="col-lg-5 mx-auto order-1" data-aos="fade-up" data-aos-delay="200">

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> <?= session()->getFlashdata('error') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> <?= session()->getFlashdata('success') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('auth/login') ?>" method="POST" class="form-box">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="username" class="form-label">Username atau Email</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Masukkan username atau email" value="<?= old('username') ?>" required
                                    autofocus>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Masukkan password" required>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="control control--checkbox">
                                    <span class="caption">Remember me</span>
                                    <input type="checkbox" name="remember" id="rememberMe" />
                                    <div class="control__indicator"></div>
                                </label>
                            </div>

                            <div class="col-12">
                                <input type="submit" value="Login" class="btn btn-primary">
                            </div>
                        </div>
                    </form>

                    <!-- Test Credentials Info -->
                    <!-- Credentials removed -->
                </div>
            </div>


        </div>
    </div> <!-- /.untree_co-section -->

    <div class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <p>Copyright &copy; 2026. All Rights Reserved. &mdash; MA Maarif Randublatung &mdash; Designed &
                        Developed by <a href="https://dimardnugroho.web.id">Dimard Nugroho</a></p>
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