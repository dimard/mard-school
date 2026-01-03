<?= $this->extend('layouts/public_exam') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <h1 data-aos="fade-up">Exam Results</h1>
                <p class="text-white-opacity lead" data-aos="fade-up" data-aos-delay="100">
                    <?= esc($result['exam_name']) ?>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="untree_co-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <!-- Score Card -->
                <div class="card shadow border-0 mb-5 text-center data-aos=" fade-up">
                    <div class="card-body p-5">
                        <h4 class="text-muted mb-3">Nilai Anda</h4>
                        <div class="display-1 font-weight-bold <?= $passed ? 'text-success' : 'text-danger' ?> mb-3">
                            <?= number_format($result['score'], 0) ?>
                        </div>

                        <?php if ($passed): ?>
                            <div class="badge badge-success px-4 py-2 mb-4" style="font-size: 1.2rem;">LULUS</div>
                            <p class="lead">Selamat,
                                <?= esc($result['full_name']) ?>! Anda telah lulus ujian.
                            </p>
                        <?php else: ?>
                            <div class="badge badge-danger px-4 py-2 mb-4" style="font-size: 1.2rem;">TIDAK LULUS</div>
                            <p class="lead">Jangan menyerah,
                                <?= esc($result['full_name']) ?>. Terus belajar!
                            </p>
                        <?php endif; ?>

                        <div class="row mt-5">
                            <div class="col-4 border-right">
                                <h3 class="text-success">
                                    <?= $result['total_correct'] ?>
                                </h3>
                                <small class="text-uppercase text-muted letter-spacing-2">Benar</small>
                            </div>
                            <div class="col-4 border-right">
                                <h3 class="text-danger">
                                    <?= $result['total_wrong'] ?>
                                </h3>
                                <small class="text-uppercase text-muted letter-spacing-2">Salah</small>
                            </div>
                            <div class="col-4">
                                <h3>
                                    <?= count($answers) ?>
                                </h3>
                                <small class="text-uppercase text-muted letter-spacing-2">Total</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="text-center mb-5">
                    <button onclick="window.print()" class="btn btn-outline-primary mr-2"><i
                            class="icon-print mr-2"></i> Cetak Hasil</button>
                    <a href="<?= base_url('ujian') ?>" class="btn btn-primary">Kembali ke Daftar Ujian</a>
                </div>

                <!-- Detailed Review removed for security -->
                <!-- 
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Detailed Review</h5>
                    </div>
                    <div class="card-body">
                       ...
                    </div>
                </div> 
                -->

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>