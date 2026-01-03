<?= $this->extend('layouts/public_exam') ?>

<?= $this->section('content') ?>

<div class="page-header" style="background-color: #1a4d1e;">
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <h1 data-aos="fade-up" data-aos-delay="100">Ujian Publik</h1>
                <p class="text-white-opacity lead" data-aos="fade-up" data-aos-delay="200">Daftar ujian yang tersedia
                    untuk umum.</p>
            </div>
        </div>
    </div>
</div>

<div class="untree_co-section">
    <div class="container">

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger mb-4">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (empty($exams)): ?>
            <div class="text-center py-5">
                <img src="<?= base_url('learner/images/no-data.svg') ?>" alt="No Data" class="img-fluid mb-4"
                    style="max-height: 200px;">
                <h3>Belum ada ujian publik yang aktif saat ini.</h3>
                <p>Silakan cek kembali nanti.</p>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($exams as $exam): ?>
                    <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="staff text-center p-4 bg-light rounded h-100">
                            <div class="staff-body">
                                <h3 class="staff-name mb-2">
                                    <?= esc($exam['exam_name']) ?>
                                </h3>
                                <div class="mb-3">
                                    <span class="badge badge-primary px-3 py-2">
                                        <?= esc($exam['duration_minutes']) ?> Menit
                                    </span>
                                    <span class="badge badge-info px-3 py-2">
                                        <?= esc($exam['total_questions']) ?> Soal
                                    </span>
                                </div>
                                <p class="mb-4 text-muted">
                                    <?= esc($exam['description'] ?? 'Tidak ada deskripsi.') ?>
                                </p>
                                <div class="mb-3">
                                    <small><i class="icon-users mr-1"></i> <span class="font-weight-bold text-primary">
                                            <?= esc($exam['participant_count']) ?>
                                        </span> Peserta</small>
                                </div>
                                <a href="<?= base_url('ujian/detail/' . $exam['id']) ?>"
                                    class="btn btn-secondary btn-block">Ikuti Ujian</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>