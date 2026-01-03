<?= $this->extend('layouts/public_exam_focus') ?>

<?= $this->section('styles') ?>
<style>
    .sticky-timer {
        background: white;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .question-nav-btn {
        width: 40px;
        height: 40px;
        margin: 4px;
        font-weight: bold;
    }

    .question-nav-btn.answered {
        background-color: #28a745;
        color: white;
    }

    .question-nav-btn.active {
        border: 2px solid #000;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="sticky-timer py-3 border-bottom">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 text-truncate" style="max-width: 300px;">
                    <?= esc($exam['exam_name']) ?>
                </h5>
            </div>
            <div class="h4 mb-0 font-weight-bold text-danger">
                <i class="icon-clock-o mr-1"></i> <span id="timer">--:--:--</span>
            </div>
            <div>
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#submitModal">
                    Selesaikan Ujian
                </button>
            </div>
        </div>
    </div>
</div>

<div class="untree_co-section pt-5">
    <div class="container">
        <div class="row">
            <!-- Questions Column -->
            <div class="col-lg-8">
                <?php foreach ($questions as $index => $q): ?>
                    <div class="card shadow-sm border-0 mb-4 question-card" id="q-<?= $index ?>"
                        style="<?= $index > 0 ? 'display:none;' : '' ?>">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Soal
                                <?= $index + 1 ?>
                            </h5>
                            <span class="badge badge-secondary">
                                <?= $q['points'] ?> Poin
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="question-text mb-4 lead">
                                <?= $q['question_text'] ?>
                            </div>

                            <div class="options-list">
                                <?php foreach (['A', 'B', 'C', 'D', 'E'] as $opt): ?>
                                    <?php if (!empty($q['option_' . strtolower($opt)])): ?>
                                        <div class="custom-control custom-radio mb-3 p-3 border rounded hover-bg-light">
                                            <input type="radio" id="opt-<?= $q['id'] ?>-<?= $opt ?>" name="answer[<?= $q['id'] ?>]"
                                                class="custom-control-input answer-option" data-question-id="<?= $q['id'] ?>"
                                                data-index="<?= $index ?>" value="<?= $opt ?>">
                                            <label class="custom-control-label w-100 cursor-pointer"
                                                for="opt-<?= $q['id'] ?>-<?= $opt ?>">
                                                <span class="font-weight-bold mr-2">
                                                    <?= $opt ?>.
                                                </span>
                                                <?= $q['option_' . strtolower($opt)] ?>
                                            </label>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="card-footer bg-white d-flex justify-content-between">
                            <button type="button" class="btn btn-outline-secondary prev-btn" <?= $index == 0 ? 'disabled' : '' ?> onclick="showQuestion(
                            <?= $index - 1 ?>)">Sebelumnya
                            </button>
                            <?php if ($index < count($questions) - 1): ?>
                                <button type="button" class="btn btn-primary next-btn"
                                    onclick="showQuestion(<?= $index + 1 ?>)">Selanjutnya</button>
                            <?php else: ?>
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#submitModal">Selesai</button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Navigation Column -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h6 class="mb-0">Navigasi Soal</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap justify-content-center">
                            <?php foreach ($questions as $index => $q): ?>
                                <button type="button" class="btn btn-outline-secondary question-nav-btn"
                                    id="nav-btn-<?= $index ?>" onclick="showQuestion(<?= $index ?>)">
                                    <?= $index + 1 ?>
                                </button>
                            <?php endforeach; ?>
                        </div>

                        <div class="mt-4 small text-muted">
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-success rounded mr-2" style="width: 15px; height: 15px;"></div> Dijawab
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="border border-secondary rounded mr-2" style="width: 15px; height: 15px;">
                                </div> Belum Dijawab
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Submit Confirmation Modal -->
<div class="modal fade" id="submitModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Submit</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menyelesaikan ujian?</p>
                <div class="alert alert-warning">
                    <small>Dijawab: <span id="answered-count">0</span> /
                        <?= count($questions) ?>
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Lanjut Mengerjakan</button>
                <form action="<?= base_url('ujian/submit/' . $resultId) ?>" method="post">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-success">Ya, Kirim Jawaban</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Timer Logic
    const endTime = new Date("<?= $endTime ?>").getTime();

    const timerInterval = setInterval(function () {
        const now = new Date().getTime();
        const distance = endTime - now;

        if (distance < 0) {
            clearInterval(timerInterval);
            document.getElementById("timer").innerHTML = "WAKTU HABIS";
            alert("Waktu habis! Ujian akan disubmit secara otomatis.");
            window.location.href = "<?= base_url('ujian/submit/' . $resultId) ?>"; // Or auto submit form
            return;
        }

        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("timer").innerHTML =
            (hours < 10 ? "0" + hours : hours) + ":" +
            (minutes < 10 ? "0" + minutes : minutes) + ":" +
            (seconds < 10 ? "0" + seconds : seconds);

    }, 1000);

    // Question Navigation
    function showQuestion(index) {
        $('.question-card').hide();
        $('#q-' + index).show();

        $('.question-nav-btn').removeClass('active');
        $('#nav-btn-' + index).addClass('active');

        // Scroll to top of question
        $('html, body').animate({
            scrollTop: $(".sticky-timer").offset().top
        }, 500);
    }

    // Initial active state
    $('#nav-btn-0').addClass('active');

    // Answer Saving & Styling
    $('.answer-option').change(function () {
        const questionId = $(this).data('question-id');
        const index = $(this).data('index');
        const answer = $(this).val();

        // Update nav button style
        $('#nav-btn-' + index).addClass('answered').removeClass('btn-outline-secondary').addClass('btn-secondary'); // simplified

        // Update answered count
        updateAnsweredCount();

        // AJAX Save
        $.post('<?= base_url("ujian/save-answer") ?>', {
            result_id: '<?= $resultId ?>',
            question_id: questionId,
            answer: answer,
            <?= csrf_token() ?>: '<?= csrf_hash() ?>'
        }, function (response) {
            console.log('Saved:', response);
        });
    });

    function updateAnsweredCount() {
        const count = $('.answer-option:checked').length;
        $('#answered-count').text(count);
    }
</script>
<?= $this->endSection() ?>