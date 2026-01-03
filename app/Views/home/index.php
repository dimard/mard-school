<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="<?= esc($settings['site_name'] ?? 'School System') ?>">
    <link rel="shortcut icon" href="<?= base_url('learner/favicon.png') ?>">

    <meta name="description" content="<?= esc($settings['site_tagline'] ?? 'Modern Education Management System') ?>" />
    <meta name="keywords" content="education, school, management, learning" />

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

    <style>
        /* HERO SLIDER */
        .hero-slider-wrapper {
            position: relative;
            width: 100%;
        }

        .hero-slider .owl-stage-outer,
        .hero-slider .owl-stage,
        .hero-slider .owl-item,
        .hero-slider .untree_co-hero {
            height: 100vh;
            min-height: 600px;
        }

        .hero-slider .owl-nav {
            position: absolute;
            top: 50%;
            width: 100%;
            transform: translateY(-50%);
            z-index: 10;
        }

        .hero-slider .owl-nav button.owl-prev,
        .hero-slider .owl-nav button.owl-next {
            position: absolute;
            background: rgba(255, 255, 255, 0.2) !important;
            color: white !important;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            font-size: 24px;
            transition: all 0.3s ease;
        }

        .hero-slider .owl-nav button.owl-prev:hover,
        .hero-slider .owl-nav button.owl-next:hover {
            background: rgba(255, 255, 255, 0.4) !important;
        }

        .hero-slider .owl-nav button.owl-prev {
            left: 30px;
        }

        .hero-slider .owl-nav button.owl-next {
            right: 30px;
        }

        .hero-slider .owl-dots {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
        }

        .hero-slider .owl-dots .owl-dot {
            display: inline-block;
            margin: 0 5px;
        }

        .hero-slider .owl-dots .owl-dot span {
            width: 12px;
            height: 12px;
            background: rgba(255, 255, 255, 0.5);
            display: block;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .hero-slider .owl-dots .owl-dot.active span,
        .hero-slider .owl-dots .owl-dot:hover span {
            background: rgba(255, 255, 255, 1);
            transform: scale(1.2);
        }

        /* STAFF SLIDER FIXES */
        #staff-section .owl-carousel .item .staff .mb-3 {
            height: 220px !important;
            /* Fixed height for image container */
            width: 220px !important;
            /* Fixed width */
            margin: 0 auto 1rem auto !important;
            /* Center align */
            overflow: hidden;
            /* Crop excess image */
            border-radius: 50% !important;
            /* Optional: Rounded styling if desired, or keep square */
        }

        #staff-section .owl-carousel .item .staff .mb-3 img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            /* Ensure image fills container */
            border-radius: 10px;
            /* Rounded corners */
        }

        /* TEXT COMPRESSION */
        #staff-section .staff h3.staff-name {
            font-size: 1.25rem !important;
            margin-bottom: 0.1rem !important;
        }

        #staff-section .staff-body span.position {
            font-size: 0.9rem !important;
            margin-bottom: 0.5rem !important;
            display: block;
        }

        #staff-section .staff-body p {
            font-size: 0.9rem !important;
            margin-bottom: 0.5rem !important;
            line-height: 1.4 !important;
        }

        #staff-section .social {
            margin-top: 0.5rem !important;
            padding-top: 0.5rem;
            border-top: 1px solid #eee;
        }
    </style>

    <title><?= esc($settings['site_name'] ?? 'Learner') ?> - Education Management System</title>
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
                        <a href="<?= base_url('/ppdb') ?>" class="small">
                            <span class="icon-person"></span>
                            PPDB
                        </a>
                    </div>


                </div>
            </div>
        </div>
        <div class="sticky-nav js-sticky-header">
            <div class="container position-relative">
                <div class="site-navigation text-center">
                    <a href="<?= base_url('/') ?>"
                        class="logo multiline menu-absolute m-0"><?= esc($settings['site_name'] ?? 'Learner') ?><span
                            class="text-primary">.</span></a>

                    <ul class="js-clone-nav d-none d-lg-inline-block site-menu">
                        <li class="active"><a href="<?= base_url('/') ?>">Home</a></li>
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


    <?php if (!empty($sliders) && count($sliders) > 0): ?>
        <!-- Dynamic Slider Carousel from Database -->
        <div class="hero-slider-wrapper">
            <div class="owl-carousel hero-slider">
                <?php foreach ($sliders as $slider): ?>
                    <div class="untree_co-hero overlay"
                        style="background-image: url('<?= base_url('uploads/sliders/' . esc($slider['image_url'])) ?>');">
                        <div class="container">
                            <div class="row align-items-center justify-content-center">
                                <div class="col-12">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-6 text-center">
                                            <h1 class="mb-4 heading text-white" data-aos="fade-up" data-aos-delay="100">
                                                <?= esc($slider['title'] ?? 'Education is the Mother of Leadership') ?>
                                            </h1>
                                            <p class="mb-4 text-white" data-aos="fade-up" data-aos-delay="200">
                                                <?= esc($slider['description'] ?? '') ?>
                                            </p>
                                            <p class="mb-0" data-aos="fade-up" data-aos-delay="300"><a
                                                    href="<?= base_url('auth/login') ?>" class="btn btn-secondary">Get
                                                    Started</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <!-- Default Hero Section -->
        <div class="untree_co-hero overlay"
            style="background-image: url('<?= base_url('learner/images/hero-img-1-min.jpg') ?>');">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12">
                        <div class="row justify-content-center">
                            <div class="col-lg-6 text-center">
                                <h1 class="mb-4 heading text-white" data-aos="fade-up" data-aos-delay="100">Education is the
                                    Mother of Leadership</h1>
                                <p class="mb-0" data-aos="fade-up" data-aos-delay="300"><a
                                        href="<?= base_url('auth/login') ?>" class="btn btn-secondary">Get Started</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <!-- Features Section -->
    <div class="untree_co-section">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center" data-aos="fade-up" data-aos-delay="0">
                    <h2 class="line-bottom text-center mb-4">Our Features</h2>
                    <p>Comprehensive school management system with modern features for education.</p>
                </div>
            </div>
            <div class="row">
                <?php if (!empty($features)): ?>
                    <?php foreach ($features as $index => $feature): ?>
                        <div class="col-6 col-sm-6 col-md-6 col-lg-4" data-aos="fade-up"
                            data-aos-delay="<?= ($index + 1) * 100 ?>">
                            <div class="feature">
                                <span class="<?= esc($feature['icon_class']) ?>"></span>
                                <h3><?= esc($feature['title']) ?></h3>
                                <p><?= esc($feature['description']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Default features if none in database -->
                    <div class="col-6 col-sm-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="feature">
                            <span class="uil uil-book-open"></span>
                            <h3>Virtual Classes</h3>
                            <p>Create and manage online classrooms with code-based enrollment system.</p>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="feature">
                            <span class="uil uil-clipboard-notes"></span>
                            <h3>CBT Exams</h3>
                            <p>Computer-based testing with automatic grading and detailed analytics.</p>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="feature">
                            <span class="uil uil-book-alt"></span>
                            <h3>Assignments</h3>
                            <p>Distribute and grade assignments with deadline tracking.</p>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="feature">
                            <span class="uil uil-clock"></span>
                            <h3>Attendance</h3>
                            <p>Digital attendance tracking with real-time monitoring.</p>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="feature">
                            <span class="uil uil-chart-line"></span>
                            <h3>Reports</h3>
                            <p>Comprehensive performance reports and student rankings.</p>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="feature">
                            <span class="uil uil-users-alt"></span>
                            <h3>User Management</h3>
                            <p>Manage admin, teachers, and students with role-based access.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>


    <!-- About Section -->
    <div id="about" class="untree_co-section">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-5 mb-5">
                    <h2 class="line-bottom mb-4" data-aos="fade-up" data-aos-delay="0">
                        <?= esc($about_section['title'] ?? 'About Us') ?>
                    </h2>
                    <div class="about-content" data-aos="fade-up" data-aos-delay="100">
                        <?php
                        $content = $about_section['content'] ?? 'Our comprehensive school management system provides a complete solution for educational institutions. We offer modern tools for virtual learning, testing, and administration.';
                        // Split content into paragraphs if it contains line breaks
                        $paragraphs = explode("\n", $content);
                        foreach ($paragraphs as $paragraph):
                            $paragraph = trim($paragraph);
                            if (!empty($paragraph)):
                                ?>
                                <p class="text-justify"><?= esc($paragraph) ?></p>
                                <?php
                            endif;
                        endforeach;
                        ?>
                    </div>

                    <p data-aos="fade-up" data-aos-delay="200">
                        <a href="<?= base_url('auth/login') ?>" class="btn btn-primary mr-1">Access Portal</a>
                        <a href="#features" class="btn btn-outline-primary">Learn More</a>
                    </p>
                </div>
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="bg-1"></div>
                    <?php if (!empty($about_section['image_url'])): ?>
                        <img src="<?= base_url('uploads/about/' . esc($about_section['image_url'])) ?>" alt="About"
                            class="img-fluid rounded">
                    <?php else: ?>
                        <img src="<?= base_url('learner/images/img-school-4-min.jpg') ?>" alt="About"
                            class="img-fluid rounded">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>




    <!-- Staff Section -->
    <?php if (!empty($staff)): ?>
        <div id="staff-section" class="untree_co-section bg-light">
            <div class="container">
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-7 text-center" data-aos="fade-up" data-aos-delay="0">
                        <h2 class="line-bottom text-center mb-4">Our Team</h2>
                        <p>Meet our dedicated team of educators and staff members committed to excellence in education.</p>
                    </div>
                </div>
                <div class="owl-3-slider owl-carousel owl-theme">
                    <?php foreach ($staff as $index => $member): ?>
                        <div class="item">
                            <div class="staff text-center">
                                <div class="mb-3">
                                    <?php if (isset($member['photo']) && $member['photo']): ?>
                                        <img src="<?= base_url('uploads/staff/' . esc($member['photo'])) ?>"
                                            alt="<?= esc($member['name']) ?>" class="img-fluid">
                                    <?php else: ?>
                                        <img src="<?= base_url('learner/images/staff_1.jpg') ?>" alt="<?= esc($member['name']) ?>"
                                            class="img-fluid">
                                    <?php endif; ?>
                                </div>
                                <div class="staff-body">
                                    <h3 class="staff-name"><?= esc($member['name']) ?></h3>
                                    <span class="d-block position mb-2"><?= esc($member['position']) ?></span>
                                    <?php if (isset($member['bio']) && $member['bio']): ?>
                                        <p class="mb-4"><?= esc($member['bio']) ?></p>
                                    <?php endif; ?>
                                    <?php if (
                                        (isset($member['facebook_url']) && $member['facebook_url']) ||
                                        (isset($member['twitter_url']) && $member['twitter_url']) ||
                                        (isset($member['linkedin_url']) && $member['linkedin_url'])
                                    ): ?>
                                        <div class="social">
                                            <?php if (isset($member['facebook_url']) && $member['facebook_url']): ?>
                                                <a href="<?= esc($member['facebook_url']) ?>" class="mx-2" target="_blank"
                                                    rel="noopener">
                                                    <span class="icon-facebook"></span>
                                                </a>
                                            <?php endif; ?>
                                            <?php if (isset($member['twitter_url']) && $member['twitter_url']): ?>
                                                <a href="<?= esc($member['twitter_url']) ?>" class="mx-2" target="_blank"
                                                    rel="noopener">
                                                    <span class="icon-twitter"></span>
                                                </a>
                                            <?php endif; ?>
                                            <?php if (isset($member['linkedin_url']) && $member['linkedin_url']): ?>
                                                <a href="<?= esc($member['linkedin_url']) ?>" class="mx-2" target="_blank"
                                                    rel="noopener">
                                                    <span class="icon-linkedin"></span>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- News Section -->
    <?php if (!empty($news)): ?>
        <div class="untree_co-section bg-light">
            <div class="container">
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-7 text-center" data-aos="fade-up" data-aos-delay="0">
                        <h2 class="line-bottom text-center mb-4">School News</h2>
                        <p>Stay updated with the latest news and announcements from our institution.</p>
                    </div>
                </div>
                <div class="row align-items-stretch">
                    <?php foreach (array_slice($news, 0, 2) as $index => $item): ?>
                        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="<?= ($index + 1) * 100 ?>">
                            <div class="media-h d-flex h-100">
                                <figure>
                                    <?php if (!empty($item['thumbnail'])): ?>
                                        <img src="<?= base_url('uploads/news/' . esc($item['thumbnail'])) ?>"
                                            alt="<?= esc($item['title']) ?>">
                                    <?php else: ?>
                                        <img src="<?= base_url('learner/images/img-school-' . (($index % 3) + 1) . '-min.jpg') ?>"
                                            alt="<?= esc($item['title']) ?>">
                                    <?php endif; ?>
                                </figure>
                                <div class="media-h-body">
                                    <h2 class="mb-3"><a
                                            href="<?= base_url('news/' . esc($item['slug'])) ?>"><?= esc($item['title']) ?></a>
                                    </h2>
                                    <div class="meta mb-2"><span
                                            class="icon-calendar mr-2"></span><span><?= date('M d, Y', strtotime($item['created_at'])) ?></span>
                                        <span class="icon-person mr-2"></span>Admin
                                    </div>
                                    <p><?= esc(substr($item['excerpt'] ?? strip_tags($item['content']), 0, 150)) ?>...</p>
                                    <p><a href="<?= base_url('news/' . esc($item['slug'])) ?>">Read More</a></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Testimonials Section -->
    <?php if (!empty($testimonials)): ?>
        <div class="untree_co-section bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 text-center mx-auto">
                        <h3 class="line-bottom mb-4">Alumni Testimonials</h3>
                        <div class="owl-carousel wide-slider-testimonial">
                            <?php foreach ($testimonials as $testimonial): ?>
                                <div class="item">
                                    <blockquote class="block-testimonial">
                                        <p>&ldquo;<?= esc($testimonial['content']) ?>&rdquo;</p>
                                        <div class="author">
                                            <?php if (!empty($testimonial['photo'])): ?>
                                                <img src="<?= base_url('uploads/testimonials/' . esc($testimonial['photo'])) ?>"
                                                    alt="<?= esc($testimonial['name']) ?>">
                                            <?php else: ?>
                                                <img src="<?= base_url('learner/images/person_1.jpg') ?>" alt="Placeholder">
                                            <?php endif; ?>
                                            <h3><?= esc($testimonial['name']) ?></h3>
                                            <p class="position"><?= esc($testimonial['role']) ?></p>
                                        </div>
                                    </blockquote>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <!-- Call to Action -->
    <div class="untree_co-section pt-0 bg-img overlay"
        style="background-image: url('<?= base_url('learner/images/img-school-1-min.jpg') ?>');">
        <div class="container">
            <div class="row align-items-center justify-content-center text-center">
                <div class="col-lg-7">
                    <h2 class="text-white mb-3" data-aos="fade-up" data-aos-delay="0">Education for Tomorrow's Leaders
                    </h2>
                    <p class="text-white h5 mb-4" data-aos="fade-up" data-aos-delay="100">Join our modern education
                        platform and experience the future of learning.</p>
                    <p><a href="<?= base_url('auth/login') ?>" class="btn btn-secondary" data-aos="fade-up"
                            data-aos-delay="200">Get Started Now</a></p>
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
                        <h3><?= esc($settings['site_name'] ?? 'About Us') ?><span class="text-primary">.</span> </h3>
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
                            <li><a href="<?= base_url('/news') ?>">News</a></li>
                            <li><a href="<?= base_url('auth/login') ?>">Login</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="widget">
                        <h3>User Portals</h3>
                        <ul class="list-unstyled float-left links">
                            <li><a href="<?= base_url('auth/login') ?>">Admin Portal</a></li>
                            <li><a href="<?= base_url('auth/login') ?>">Teacher Portal</a></li>
                            <li><a href="<?= base_url('auth/login') ?>">Student Portal</a></li>
                        </ul>
                    </div>
                </div>


                <div class="col-lg-3">
                    <div class="widget">
                        <h3>Contact</h3>
                        <address><?= esc($settings['school_address'] ?? '43 Raymouth Rd. Indonesia') ?></address>
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
                        <?= esc($settings['site_name'] ?? 'School System') ?> &mdash; Designed & Developed by <a
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

    <!-- Hero Slider Initialization -->
    <script>
        $(document).ready(function () {
            $('.hero-slider').owlCarousel({
                items: 1,
                loop: true,
                margin: 0,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                animateOut: 'fadeOut',
                animateIn: 'fadeIn',
                nav: true,
                navText: ['<span class="icon-keyboard_arrow_left"></span>', '<span class="icon-keyboard_arrow_right"></span>'],
                dots: true,
                smartSpeed: 1000,
                responsive: {
                    0: {
                        nav: false
                    },
                    768: {
                        nav: true
                    }
                }
            });
        });
    </script>

</body>

</html>