<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => esc($exam['exam_name'])]) ?>
    <?= view('layouts/head_css') ?>
    <style>
        .timer-floating {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1050;
            background: #fff;
            padding: 15px 25px;
            border-radius: 50px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 15px;
            border: 2px solid #dc3545;
            animation: pulse-border 2s infinite;
        }

        @keyframes pulse-border {
            0% {
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(220, 53, 69, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
            }
        }
    </style>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>

    <!-- We hide sidebar/topbar for distraction-free exam mode but keep the structure -->
    <div class="pc-container" style="margin-left: 0; padding-top: 20px;">
        <div class="pc-content">

            <div class="timer-floating">
                <i class="ph ph-timer text-danger" style="font-size: 1.5rem;"></i>
                <div class="text-end">
                    <small class="d-block text-muted" style="font-size: 0.75rem; line-height: 1;">WAKTU TERSISA</small>
                    <span id="timer" class="fw-bold fs-4 text-danger font-monospace">Memuat...</span>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card mb-4 border-top-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-1"><?= esc($exam['exam_name']) ?></h4>
                                    <p class="text-muted mb-0"><?= esc($exam['description']) ?></p>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-light-primary text-primary">Mode Ujian</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="<?= base_url('siswa/cbt/submit/' . $resultId) ?>" method="post" id="examForm">
                        <?php if (!empty($questions)): ?>
                            <?php foreach ($questions as $index => $q): ?>
                                <div class="card mb-4">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Pertanyaan <?= $index + 1 ?></h5>
                                        <i class="ph ph-question text-muted"></i>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <p class="lead" style="font-size: 1.1rem;"><?= esc($q['question_text']) ?></p>
                                        </div>

                                        <div class="radio-list">
                                            <?php
                                            $options = ['A' => $q['option_a'], 'B' => $q['option_b'], 'C' => $q['option_c'], 'D' => $q['option_d'], 'E' => $q['option_e'] ?? null];
                                            foreach ($options as $key => $val):
                                                if (!$val)
                                                    continue;
                                                ?>
                                                <div class="form-check card-radio p-0 mb-2">
                                                    <input class="form-check-input d-none save-answer" type="radio"
                                                        name="q_<?= $q['id'] ?>" value="<?= $key ?>"
                                                        id="q<?= $q['id'] ?>_<?= $key ?>" data-qid="<?= $q['id'] ?>">
                                                    <label class="form-check-label card p-3 cursor-pointer mb-0"
                                                        for="q<?= $q['id'] ?>_<?= $key ?>">
                                                        <div class="d-flex align-items-center">
                                                            <span class="badge bg-light-secondary text-dark me-3"
                                                                style="width: 30px;"><?= $key ?></span>
                                                            <span><?= esc($val) ?></span>
                                                        </div>
                                                    </label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="alert alert-warning">Tidak ada pertanyaan untuk ujian ini.</div>
                        <?php endif; ?>

                        <div class="card bg-light-secondary mt-5 mb-5">
                            <div class="card-body text-center">
                                <i class="ph ph-check-circle text-primary mb-2" style="font-size: 2rem;"></i>
                                <h5>Selesaikan Ujian?</h5>
                                <p class="text-muted">Pastikan Anda telah menjawab semua pertanyaan sebelum
                                    mengumpulkan.</p>
                                <button type="submit" class="btn btn-primary btn-lg px-5"
                                    onclick="return confirm('Apakah Anda yakin ingin menyelesaikan ujian ini? Tindakan ini tidak dapat dibatalkan.')">
                                    Kirim dan Selesai
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?= view('layouts/footer_js', ['includeCharts' => false]) ?>
    <style>
        .form-check-input:checked+.form-check-label {
            background-color: rgba(13, 110, 253, 0.05);
            border: 1px solid #0d6efd;
        }

        .form-check-input:checked+.form-check-label .badge {
            background-color: #0d6efd !important;
            color: #fff !important;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .card-radio:hover .form-check-label {
            background-color: #f8f9fa;
        }
    </style>

    <script>
        // Timer Logic
        const endTime = new Date("<?= $endTime ?>").getTime();

        const x = setInterval(function () {
            const now = new Date().getTime();
            const distance = endTime - now;

            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            const display = (hours > 0 ? hours + "h " : "") + minutes + "m " + seconds + "s";
            document.getElementById("timer").innerHTML = display;

            // Warning style if less than 5 min
            if (distance < 5 * 60 * 1000) {
                document.querySelector('.timer-floating').classList.add('bg-light-danger');
            }

            if (distance < 0) {
                clearInterval(x);
                document.getElementById("timer").innerHTML = "EXPIRED";
                alert("Waktu habis! Mengumpulkan jawaban ujian...");
                document.getElementById("examForm").submit();
            }
        }, 1000);

        // Auto Save Answer
        $('.save-answer').change(function () {
            const questionId = $(this).data('qid');
            const answer = $(this).val();
            const resultId = <?= $resultId ?>;

            $.post('<?= base_url('siswa/cbt/answer') ?>', {
                result_id: resultId,
                question_id: questionId,
                answer: answer
            }, function (data) {
                console.log('Answer saved');
            });
        });
    </script>
</body>

</html>