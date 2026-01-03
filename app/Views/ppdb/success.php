<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="<?= base_url('learner/favicon.png') ?>">
    <link
        href="https://fonts.googleapis.com/css2?family=Display+Playfair:wght@400;700&family=Inter:wght@400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="<?= base_url('learner/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('learner/css/style.css') ?>">
    <title>Pendaftaran Berhasil - PPDB</title>
</head>

<body>
    <div class="untree_co-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="card shadow-lg">
                        <div class="card-body p-5">
                            <div class="mb-4">
                                <span class="icon-check-circle" style="font-size: 80px; color: #28a745;"></span>
                            </div>
                            <h2 class="mb-4">Pendaftaran Berhasil!</h2>
                            <p class="lead mb-4">Terima kasih telah mendaftar. Nomor registrasi Anda adalah:</p>
                            <div class="alert alert-success">
                                <h3 class="mb-0"><strong><?= esc($registration_number) ?></strong></h3>
                            </div>
                            <p class="text-muted mb-4">
                                Simpan nomor registrasi ini untuk keperluan pengecekan status pendaftaran Anda.
                                Tim kami akan menghubungi Anda melalui email/telepon yang terdaftar.
                            </p>
                            <a href="<?= base_url() ?>" class="btn btn-primary">
                                <i class="icon-home mr-2"></i>Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>