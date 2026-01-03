<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="<?= base_url('learner/favicon.png') ?>">

    <meta name="description" content="<?= esc($settings['site_tagline'] ?? 'Pendaftaran Peserta Didik Baru') ?>" />
    <meta name="keywords" content="ppdb, pendaftaran, siswa baru" />

    <link
        href="https://fonts.googleapis.com/css2?family=Display+Playfair:wght@400;700&family=Inter:wght@400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <link rel="stylesheet" href="<?= base_url('learner/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('learner/css/animate.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('learner/css/aos.css') ?>">
    <link rel="stylesheet" href="<?= base_url('learner/fonts/icomoon/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('learner/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('learner/css/custom-responsive.css?v=' . time()) ?>">

    <!-- Dynamic Theme CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/theme-dynamic.css?v=' . time()) ?>">

    <title>PPDB - <?= esc($settings['site_name'] ?? 'School System') ?></title>
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

    <!-- Navbar - Same as homepage -->
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
                            <span class="icon-lock"></span> Log In
                        </a>
                        <a href="<?= base_url() ?>" class="small">
                            <span class="icon-home"></span> Home
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
                        <li><a href="<?= base_url('/') ?>">Home</a></li>
                        <?php if (!empty($nav_links)): ?>
                            <?php foreach ($nav_links as $link): ?>
                                <li><a href="<?= esc($link['url']) ?>"
                                        target="<?= esc($link['target']) ?>"><?= esc($link['label']) ?></a></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li><a href="<?= base_url('/news') ?>">News</a></li>
                            <li><a href="#about">About</a></li>
                        <?php endif; ?>
                        <li class="active"><a href="<?= base_url('ppdb') ?>">PPDB</a></li>
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
        style="background-image: url('<?= base_url('learner/images/img-school-1-min.jpg') ?>');">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12">
                    <div class="row justify-content-center ">
                        <div class="col-lg-8 text-center ">
                            <h1 class="mb-4 heading text-white" data-aos="fade-up" data-aos-delay="100">
                                Penerimaan Peserta Didik Baru (PPDB)
                            </h1>
                            <p class="text-white mb-4" data-aos="fade-up" data-aos-delay="200">
                                Tahun Ajaran <?= esc($ppdb_info['year']) ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Info -->
    <div class="untree_co-section bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <?php if ($is_open && !$is_full): ?>
                        <div class="alert alert-success" role="alert">
                            <h4 class="alert-heading"><i class="icon-check mr-2"></i>Pendaftaran Dibuka!</h4>
                            <p>Pendaftaran PPDB Tahun Ajaran <?= esc($ppdb_info['year']) ?> sedang dibuka.</p>
                            <hr>
                            <p class="mb-0">
                                <strong>Periode:</strong> <?= date('d F Y', strtotime($ppdb_info['start_date'])) ?> -
                                <?= date('d F Y', strtotime($ppdb_info['end_date'])) ?><br>
                                <strong>Kuota:</strong> <?= $ppdb_info['quota'] ?> siswa
                            </p>
                        </div>
                    <?php elseif ($is_full): ?>
                        <div class="alert alert-warning" role="alert">
                            <h4 class="alert-heading"><i class="icon-alert-triangle mr-2"></i>Kuota Penuh</h4>
                            <p>Maaf, kuota pendaftaran untuk tahun ajaran ini sudah penuh.</p>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-danger" role="alert">
                            <h4 class="alert-heading"><i class="icon-x-circle mr-2"></i>Pendaftaran Ditutup</h4>
                            <p>Pendaftaran PPDB untuk tahun ajaran ini sedang ditutup. Silakan pantau informasi lebih
                                lanjut.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Alur PPDB -->
    <div class="untree_co-section">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center" data-aos="fade-up">
                    <h2 class="line-bottom text-center mb-4">Alur Pendaftaran</h2>
                    <p>Berikut adalah tahapan yang harus dilalui dalam proses penerimaan peserta didik baru</p>
                </div>
            </div>

            <div class="row">
                <?php foreach ($ppdb_flow as $index => $step): ?>
                    <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="<?= ($index + 1) * 100 ?>">
                        <div class="service text-center">
                            <div class="service-number"><?= $step['step'] ?></div>
                            <h3><?= esc($step['title']) ?></h3>
                            <p><?= esc($step['description']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Persyaratan -->
    <div class="untree_co-section bg-light">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center" data-aos="fade-up">
                    <h2 class="line-bottom text-center mb-4">Persyaratan Pendaftaran</h2>
                    <p>Dokumen-dokumen yang perlu disiapkan untuk pendaftaran</p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <ul class="list-unstyled">
                        <?php foreach ($ppdb_requirements as $req): ?>
                            <li class="mb-3" data-aos="fade-up">
                                <i class="icon-check text-primary mr-2"></i>
                                <span><?= esc($req) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Cek Status Pendaftaran -->
    <div class="untree_co-section">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center" data-aos="fade-up">
                    <h2 class="line-bottom text-center mb-4">Cek Status Pendaftaran</h2>
                    <p>Masukkan nomor registrasi Anda untuk melihat status pendaftaran</p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="bg-white p-4 p-md-5 shadow-sm" style="border-radius: 10px;">
                        <form id="checkStatusForm" onsubmit="checkStatus(event)">
                            <div class="form-group mb-3">
                                <label class="font-weight-bold">Nomor Registrasi</label>
                                <input type="text" id="registrationNumber" class="form-control"
                                    placeholder="Contoh: PPDB-202412-0001" required>
                                <small class="text-muted">Nomor registrasi yang Anda terima saat mendaftar</small>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="icon-search mr-2"></i>Cek Status
                            </button>
                        </form>

                        <!-- Status Result -->
                        <div id="statusResult" class="mt-4" style="display: none;">
                            <hr class="my-4">
                            <div id="statusContent"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration Form -->
    <?php if ($is_open && !$is_full): ?>
        <div id="form-pendaftaran" class="untree_co-section">
            <div class="container">
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-10 text-center" data-aos="fade-up">
                        <h2 class="line-bottom text-center mb-4">Form Pendaftaran</h2>
                        <p>Lengkapi formulir di bawah ini dengan data yang benar</p>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('error') ?>
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('errors')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                        <li><?= $error ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>
                        <?php endif; ?>

                        <div class="bg-white p-4 p-md-5 shadow-sm" style="border-radius: 10px;">
                            <form action="<?= base_url('ppdb/register') ?>" method="POST" enctype="multipart/form-data">
                                <?= csrf_field() ?>

                                <!-- Data Pribadi -->
                                <div class="mb-4">
                                    <h4 class="mb-4 text-primary">
                                        <i class="icon-user mr-2"></i>Data Pribadi Calon Siswa
                                    </h4>
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label class="font-weight-bold">Nama Lengkap *</label>
                                            <input type="text" name="full_name" class="form-control" required
                                                value="<?= old('full_name') ?>">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">NIK *</label>
                                            <input type="text" name="nik" class="form-control" required maxlength="16"
                                                value="<?= old('nik') ?>">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Jenis Kelamin *</label>
                                            <select name="gender" class="form-control" required>
                                                <option value="">Pilih</option>
                                                <option value="L" <?= old('gender') == 'L' ? 'selected' : '' ?>>Laki-laki
                                                </option>
                                                <option value="P" <?= old('gender') == 'P' ? 'selected' : '' ?>>Perempuan
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Tempat Lahir *</label>
                                            <input type="text" name="birth_place" class="form-control" required
                                                value="<?= old('birth_place') ?>">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Tanggal Lahir *</label>
                                            <input type="date" name="birth_date" class="form-control" required
                                                value="<?= old('birth_date') ?>">
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- Data Kontak -->
                                <div class="mb-4">
                                    <h4 class="mb-4 text-primary">
                                        <i class="icon-phone mr-2"></i>Data Kontak
                                    </h4>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Email *</label>
                                            <input type="email" name="email" class="form-control" required
                                                value="<?= old('email') ?>">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">No. HP *</label>
                                            <input type="tel" name="phone" class="form-control" required
                                                value="<?= old('phone') ?>">
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label class="font-weight-bold">Alamat Lengkap *</label>
                                            <textarea name="address" class="form-control" rows="3"
                                                required><?= old('address') ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- Data Orang Tua -->
                                <div class="mb-4">
                                    <h4 class="mb-4 text-primary">
                                        <i class="icon-users mr-2"></i>Data Orang Tua/Wali
                                    </h4>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Nama Orang Tua/Wali *</label>
                                            <input type="text" name="parent_name" class="form-control" required
                                                value="<?= old('parent_name') ?>">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">No. HP Orang Tua *</label>
                                            <input type="tel" name="parent_phone" class="form-control" required
                                                value="<?= old('parent_phone') ?>">
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label class="font-weight-bold">Pekerjaan Orang Tua</label>
                                            <input type="text" name="parent_occupation" class="form-control"
                                                value="<?= old('parent_occupation') ?>">
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- Data Pendidikan -->
                                <div class="mb-4">
                                    <h4 class="mb-4 text-primary">
                                        <i class="icon-book mr-2"></i>Data Pendidikan
                                    </h4>
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label class="font-weight-bold">Asal Sekolah *</label>
                                            <input type="text" name="previous_school" class="form-control" required
                                                value="<?= old('previous_school') ?>">
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- Upload Dokumen -->
                                <div class="mb-4">
                                    <h4 class="mb-4 text-primary">
                                        <i class="icon-paperclip mr-2"></i>Upload Dokumen
                                    </h4>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Pas Foto 3x4 * <small class="text-muted">(Max
                                                    2MB)</small></label>
                                            <input type="file" name="photo" class="form-control" accept="image/*" required>
                                            <small class="text-muted">Format: JPG, JPEG, PNG</small>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Fotocopy Ijazah <small class="text-muted">(Max
                                                    5MB)</small></label>
                                            <input type="file" name="document_ijazah" class="form-control"
                                                accept=".pdf,.jpg,.jpeg,.png">
                                            <small class="text-muted">Format: PDF, JPG, PNG</small>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Fotocopy Kartu Keluarga <small
                                                    class="text-muted">(Max 5MB)</small></label>
                                            <input type="file" name="document_kk" class="form-control"
                                                accept=".pdf,.jpg,.jpeg,.png">
                                            <small class="text-muted">Format: PDF, JPG, PNG</small>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Fotocopy Akta Kelahiran <small
                                                    class="text-muted">(Max 5MB)</small></label>
                                            <input type="file" name="document_akta" class="form-control"
                                                accept=".pdf,.jpg,.jpeg,.png">
                                            <small class="text-muted">Format: PDF, JPG, PNG</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-5">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                                        <i class="icon-check mr-2"></i>Daftar Sekarang
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Footer - Same as homepage -->
    <div class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 mr-auto">
                    <div class="widget">
                        <h3><?= esc($settings['site_name'] ?? 'About Us') ?><span class="text-primary">.</span> </h3>
                        <p><?= esc($settings['site_tagline'] ?? 'Modern education management system for schools and institutions.') ?>
                        </p>
                    </div>
                </div>
                <div class="col-lg-2 ml-auto">
                    <div class="widget">
                        <h3>Quick Links</h3>
                        <ul class="list-unstyled float-left links">
                            <li><a href="<?= base_url('/') ?>">Home</a></li>
                            <li><a href="<?= base_url('/news') ?>">News</a></li>
                            <li><a href="<?= base_url('ppdb') ?>">PPDB</a></li>
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
                        <script>document.write(new Date().getFullYear());</script>.
                        <?= esc($settings['site_name'] ?? 'School System') ?>
                    </p>
                    Designed & Developed <a href="https://dimardnugroho.web.id">Dimard Nugroho | Instagram :
                        @dimardnugroho</a>
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
    <script src="<?= base_url('learner/js/jquery.sticky.js') ?>"></script>
    <script src="<?= base_url('learner/js/aos.js') ?>"></script>
    <script src="<?= base_url('learner/js/custom.js') ?>"></script>

    <script>
        function checkStatus(event) {
            event.preventDefault();

            const regNumber = document.getElementById('registrationNumber').value.trim();
            const resultDiv = document.getElementById('statusResult');
            const contentDiv = document.getElementById('statusContent');

            if (!regNumber) {
                return;
            }

            // Show loading
            contentDiv.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div><p class="mt-2">Mencari data...</p></div>';
            resultDiv.style.display = 'block';

            // AJAX request
            fetch('<?= base_url('ppdb/check-status') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ registration_number: regNumber })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayStatus(data.data);
                    } else {
                        contentDiv.innerHTML = `
                        <div class="alert alert-warning">
                            <i class="icon-alert-triangle mr-2"></i>
                            ${data.message || 'Nomor registrasi tidak ditemukan'}
                        </div>
                    `;
                    }
                })
                .catch(error => {
                    contentDiv.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="icon-x-circle mr-2"></i>
                        Terjadi kesalahan. Silakan coba lagi.
                    </div>
                `;
                });
        }

        function displayStatus(data) {
            const statusColors = {
                'pending': 'warning',
                'verified': 'info',
                'approved': 'success',
                'rejected': 'danger'
            };

            const statusLabels = {
                'pending': 'Menunggu Verifikasi',
                'verified': 'Terverifikasi',
                'approved': 'Diterima',
                'rejected': 'Ditolak'
            };

            const statusIcons = {
                'pending': 'icon-clock',
                'verified': 'icon-check-circle',
                'approved': 'icon-check-square',
                'rejected': 'icon-x-circle'
            };

            const statusColor = statusColors[data.status] || 'secondary';
            const statusLabel = statusLabels[data.status] || data.status;
            const statusIcon = statusIcons[data.status] || 'icon-info';

            let html = `
                <div class="alert alert-${statusColor}">
                    <h5 class="alert-heading">
                        <i class="${statusIcon} mr-2"></i>
                        Status: ${statusLabel}
                    </h5>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted d-block">Nomor Registrasi</small>
                            <strong>${data.registration_number}</strong>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Nama Lengkap</small>
                            <strong>${data.full_name}</strong>
                        </div>
                        <div class="col-md-6 mt-2">
                            <small class="text-muted d-block">Email</small>
                            <strong>${data.email}</strong>
                        </div>
                        <div class="col-md-6 mt-2">
                            <small class="text-muted d-block">Tanggal Daftar</small>
                            <strong>${new Date(data.created_at).toLocaleDateString('id-ID')}</strong>
                        </div>
                    </div>
            `;

            if (data.admin_notes) {
                html += `
                    <hr>
                    <small class="text-muted d-block mb-1">Catatan Admin:</small>
                    <p class="mb-0">${data.admin_notes}</p>
                `;
            }

            html += '</div>';

            document.getElementById('statusContent').innerHTML = html;
        }
    </script>
</body>

</html>