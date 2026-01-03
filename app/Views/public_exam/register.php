<?= $this->extend('layouts/public_exam') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <h1 data-aos="fade-up" data-aos-delay="0">Registrasi Peserta</h1>
                <p class="text-white-opacity lead" data-aos="fade-up" data-aos-delay="100">Silakan isi data diri Anda
                    untuk memulai ujian.</p>
            </div>
        </div>
    </div>
</div>

<div class="untree_co-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom p-4">
                        <h4 class="mb-0 text-primary">
                            <?= esc($exam['exam_name']) ?>
                        </h4>
                        <small class="text-muted">Durasi:
                            <?= esc($exam['duration_minutes']) ?> Menit
                        </small>
                    </div>
                    <div class="card-body p-4">

                        <?php if (session()->getFlashdata('errors')): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0 pl-3">
                                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                        <li>
                                            <?= esc($error) ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('ujian/daftar') ?>" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="exam_id" value="<?= esc($exam['id']) ?>">

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="font-weight-bold">Nama Lengkap <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="full_name" required
                                        value="<?= old('full_name') ?>">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="font-weight-bold">Kelas <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="class_name" required
                                        value="<?= old('class_name') ?>" placeholder="Contoh: 10 IPA 1">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="font-weight-bold">No. Absen <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="student_number" required
                                        value="<?= old('student_number') ?>" placeholder="Contoh: 15">
                                </div>
                            </div>

                            <div class="alert alert-warning mt-4">
                                <strong><i class="icon-warning mr-1"></i> Penting:</strong>
                                <ul class="mb-0 pl-3 small">
                                    <li>Waktu ujian akan segera berjalan setelah Anda klik "Mulai Ujian".</li>
                                    <li>Jangan memuat ulang (refresh) halaman selama ujian berlangsung.</li>
                                    <li>Pastikan koneksi internet Anda stabil.</li>
                                </ul>
                            </div>

                            <div class="text-right mt-4">
                                <a href="<?= base_url('ujian/detail/' . $exam['id']) ?>"
                                    class="btn btn-light mr-2">Kembali</a>
                                <button type="submit" class="btn btn-primary px-5">Mulai Ujian</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>