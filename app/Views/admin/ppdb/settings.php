<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Pengaturan PPDB']) ?>
    <?= view('layouts/head_css') ?>
    <style>
        .flow-step-item,
        .requirement-item {
            background: #f8f9fa;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            border-left: 3px solid #04a9f5;
        }

        .btn-remove {
            float: right;
        }
    </style>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>
    <?= view('layouts/sidebar') ?>
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Pengaturan PPDB',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'admin/dashboard'],
                    ['label' => 'PPDB', 'url' => 'admin/ppdb'],
                    ['label' => 'Pengaturan']
                ]
            ]) ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('admin/ppdb/settings/update') ?>" method="POST" id="ppdbSettingsForm">
                <?= csrf_field() ?>

                <div class="row">
                    <!-- General Settings -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Pengaturan Umum</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Status Pendaftaran</label>
                                    <select name="ppdb_status" class="form-select" required>
                                        <option value="open" <?= ($ppdb_settings['ppdb_status'] ?? '') == 'open' ? 'selected' : '' ?>>Open (Buka)</option>
                                        <option value="closed" <?= ($ppdb_settings['ppdb_status'] ?? '') == 'closed' ? 'selected' : '' ?>>Closed (Tutup)</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tahun Ajaran</label>
                                    <input type="text" name="ppdb_year" class="form-control"
                                        value="<?= esc($ppdb_settings['ppdb_year'] ?? '2024/2025') ?>"
                                        placeholder="2024/2025" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kuota Pendaftar</label>
                                    <input type="number" name="ppdb_quota" class="form-control"
                                        value="<?= esc($ppdb_settings['ppdb_quota'] ?? '100') ?>" min="0" required>
                                    <small class="text-muted">Isi 0 untuk unlimited</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tanggal Mulai</label>
                                    <input type="date" name="ppdb_start_date" class="form-control"
                                        value="<?= esc($ppdb_settings['ppdb_start_date'] ?? date('Y-m-d')) ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tanggal Berakhir</label>
                                    <input type="date" name="ppdb_end_date" class="form-control"
                                        value="<?= esc($ppdb_settings['ppdb_end_date'] ?? date('Y-m-d', strtotime('+30 days'))) ?>"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alur PPDB -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Alur PPDB</h5>
                                <button type="button" class="btn btn-sm btn-primary" onclick="addFlowStep()">
                                    <i class="ph ph-plus"></i> Tambah Step
                                </button>
                            </div>
                            <div class="card-body">
                                <div id="flowStepsContainer">
                                    <?php if (!empty($flow_steps)): ?>
                                        <?php foreach ($flow_steps as $index => $step): ?>
                                            <div class="flow-step-item" data-index="<?= $index ?>">
                                                <button type="button" class="btn btn-sm btn-danger btn-remove"
                                                    onclick="removeFlowStep(this)">
                                                    <i class="ph ph-trash"></i>
                                                </button>
                                                <div class="mb-2">
                                                    <label class="form-label small">Step <?= ($index + 1) ?></label>
                                                    <input type="hidden" name="flow_steps[<?= $index ?>][step]"
                                                        value="<?= ($index + 1) ?>">
                                                </div>
                                                <div class="mb-2">
                                                    <input type="text" name="flow_steps[<?= $index ?>][title]"
                                                        class="form-control form-control-sm" placeholder="Judul Step"
                                                        value="<?= esc($step['title'] ?? '') ?>" required>
                                                </div>
                                                <div>
                                                    <textarea name="flow_steps[<?= $index ?>][description]"
                                                        class="form-control form-control-sm" rows="2"
                                                        placeholder="Deskripsi"><?= esc($step['description'] ?? '') ?></textarea>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Persyaratan -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Persyaratan</h5>
                                <button type="button" class="btn btn-sm btn-primary" onclick="addRequirement()">
                                    <i class="ph ph-plus"></i> Tambah
                                </button>
                            </div>
                            <div class="card-body">
                                <div id="requirementsContainer">
                                    <?php if (!empty($requirements)): ?>
                                        <?php foreach ($requirements as $index => $req): ?>
                                            <div class="requirement-item mb-2">
                                                <button type="button" class="btn btn-sm btn-danger btn-remove"
                                                    onclick="removeRequirement(this)">
                                                    <i class="ph ph-trash"></i>
                                                </button>
                                                <input type="text" name="requirements[]" class="form-control form-control-sm"
                                                    placeholder="Persyaratan" value="<?= esc($req) ?>" required>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ph ph-floppy-disk me-1"></i>Simpan Pengaturan
                                </button>
                                <a href="<?= base_url('admin/ppdb') ?>" class="btn btn-secondary">
                                    <i class="ph ph-arrow-left me-1"></i>Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?= view('layouts/footer_js') ?>

    <script>
        let flowStepIndex = <?= count($flow_steps ?? []) ?>;

        function addFlowStep() {
            const container = document.getElementById('flowStepsContainer');
            const stepNumber = flowStepIndex + 1;

            const html = `
                <div class="flow-step-item" data-index="${flowStepIndex}">
                    <button type="button" class="btn btn-sm btn-danger btn-remove" onclick="removeFlowStep(this)">
                        <i class="ph ph-trash"></i>
                    </button>
                    <div class="mb-2">
                        <label class="form-label small">Step ${stepNumber}</label>
                        <input type="hidden" name="flow_steps[${flowStepIndex}][step]" value="${stepNumber}">
                    </div>
                    <div class="mb-2">
                        <input type="text" name="flow_steps[${flowStepIndex}][title]" class="form-control form-control-sm" 
                               placeholder="Judul Step" required>
                    </div>
                    <div>
                        <textarea name="flow_steps[${flowStepIndex}][description]" class="form-control form-control-sm" 
                                  rows="2" placeholder="Deskripsi"></textarea>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', html);
            flowStepIndex++;
            updateStepNumbers();
        }

        function removeFlowStep(btn) {
            btn.closest('.flow-step-item').remove();
            updateStepNumbers();
        }

        function updateStepNumbers() {
            const steps = document.querySelectorAll('.flow-step-item');
            steps.forEach((step, index) => {
                const label = step.querySelector('.form-label');
                const hiddenInput = step.querySelector('input[type="hidden"]');
                if (label) label.textContent = `Step ${index + 1}`;
                if (hiddenInput) hiddenInput.value = index + 1;
            });
        }

        function addRequirement() {
            const container = document.getElementById('requirementsContainer');

            const html = `
                <div class="requirement-item mb-2">
                    <button type="button" class="btn btn-sm btn-danger btn-remove" onclick="removeRequirement(this)">
                        <i class="ph ph-trash"></i>
                    </button>
                    <input type="text" name="requirements[]" class="form-control form-control-sm" 
                           placeholder="Persyaratan" required>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', html);
        }

        function removeRequirement(btn) {
            btn.closest('.requirement-item').remove();
        }
    </script>
</body>

</html>