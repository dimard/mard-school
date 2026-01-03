<?= $this->extend('layouts/public_exam') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <h1 data-aos="fade-up" data-aos-delay="0">Konfirmasi Akses</h1>
                <p class="text-white-opacity lead" data-aos="fade-up" data-aos-delay="100">Masukkan kode akses untuk
                    melanjutkan.</p>
            </div>
        </div>
    </div>
</div>

<div class="untree_co-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h3 class="mb-2">
                                <?= esc($exam['exam_name']) ?>
                            </h3>
                            <p class="text-muted mb-0">
                                <i class="icon-clock-o mr-1"></i>
                                <?= esc($exam['duration_minutes']) ?> Menit &bull;
                                <i class="icon-question-circle mr-1"></i>
                                <?= esc($exam['total_questions']) ?> Soal
                            </p>
                        </div>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('ujian/validate-access') ?>" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="exam_id" value="<?= esc($exam['id']) ?>">

                            <div class="form-group mb-4">
                                <label for="access_code" class="font-weight-bold">Kode Akses</label>
                                <input type="text" class="form-control form-control-lg text-center letter-spacing-2"
                                    id="access_code" name="access_code" placeholder="MASUKKAN KODE"
                                    style="letter-spacing: 3px; text-transform: uppercase;" required>
                                <small class="form-text text-muted text-center mt-2">Silakan masukkan kode akses yang
                                    diberikan oleh admin.</small>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block btn-lg">Verifikasi Kode</button>
                            <a href="<?= base_url('ujian') ?>"
                                class="btn btn-outline-secondary btn-block mt-3">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>