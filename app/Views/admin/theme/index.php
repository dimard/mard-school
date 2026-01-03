<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Pengaturan Tema']) ?>
    <?= view('layouts/head_css') ?>
    <style>
        .color-preview {
            width: 100%;
            height: 80px;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            /* text-shadow removed for flat look */
            margin-top: 10px;
        }

        .color-input-group {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .color-input-group input[type="color"] {
            width: 60px;
            height: 38px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            cursor: pointer;
        }

        .color-input-group input[type="text"] {
            flex: 1;
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
                'pageTitle' => 'Pengaturan Tema',
                'breadcrumbs' => [
                    ['label' => 'Beranda', 'url' => 'admin/dashboard'],
                    ['label' => 'Pengaturan Tema']
                ]
            ]) ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="ph ph-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="ph ph-warning me-2"></i><?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('admin/theme/update') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="ph ph-palette me-2"></i>Sesuaikan Warna Beranda</h5>
                                <p class="text-muted mb-0 small">Kontrol warna untuk elemen beranda tertentu</p>
                            </div>
                            <div class="card-body">
                                <!-- Navbar Color -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">🔵 Warna Bilah Navigasi Atas</label>
                                    <p class="text-muted small">Warna semi-transparan untuk bilah atas (transparansi
                                        60%)</p>
                                    <div class="color-input-group">
                                        <input type="color" id="navbarColorPicker" value="<?= esc($navbar_color) ?>"
                                            onchange="updateColor('navbar', this.value)">
                                        <input type="text" name="theme_navbar_color" id="navbarColorInput"
                                            class="form-control" value="<?= esc($navbar_color) ?>"
                                            pattern="^#[a-fA-F0-9]{6}$" required
                                            oninput="updateColorFromInput('navbar', this.value)">
                                    </div>
                                    <div class="color-preview" id="navbarPreview"
                                        style="background-color: <?= esc($navbar_color) ?>; opacity: 0.6;">
                                        Pratinjau Navigasi Atas (transparansi 60%)
                                    </div>
                                </div>

                                <!-- Slider Overlay Color -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">🖼️ Warna Overlay Slider</label>
                                    <p class="text-muted small">Warna overlay semi-transparan pada slider utama
                                        (transparansi 60%)</p>
                                    <div class="color-input-group">
                                        <input type="color" id="sliderColorPicker"
                                            value="<?= esc($slider_overlay_color) ?>"
                                            onchange="updateColor('slider', this.value)">
                                        <input type="text" name="theme_slider_overlay_color" id="sliderColorInput"
                                            class="form-control" value="<?= esc($slider_overlay_color) ?>"
                                            pattern="^#[a-fA-F0-9]{6}$" required
                                            oninput="updateColorFromInput('slider', this.value)">
                                    </div>
                                    <div class="color-preview" id="sliderPreview"
                                        style="background-color: <?= esc($slider_overlay_color) ?>; opacity: 0.6;">
                                        Pratinjau Overlay Slider (transparansi 60%)
                                    </div>
                                </div>

                                <!-- Footer Color -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">📄 Warna Latar Belakang Footer</label>
                                    <p class="text-muted small">Warna untuk bagian footer di bagian bawah halaman</p>
                                    <div class="color-input-group">
                                        <input type="color" id="footerColorPicker" value="<?= esc($footer_color) ?>"
                                            onchange="updateColor('footer', this.value)">
                                        <input type="text" name="theme_footer_color" id="footerColorInput"
                                            class="form-control" value="<?= esc($footer_color) ?>"
                                            pattern="^#[a-fA-F0-9]{6}$" required
                                            oninput="updateColorFromInput('footer', this.value)">
                                    </div>
                                    <div class="color-preview" id="footerPreview"
                                        style="background-color: <?= esc($footer_color) ?>">
                                        Pratinjau Footer
                                    </div>
                                </div>

                                <!-- Button Color -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">🔘 Warna Tombol</label>
                                    <p class="text-muted small">Warna untuk tombol utama di seluruh situs</p>
                                    <div class="color-input-group">
                                        <input type="color" id="buttonColorPicker" value="<?= esc($button_color) ?>"
                                            onchange="updateColor('button', this.value)">
                                        <input type="text" name="theme_button_color" id="buttonColorInput"
                                            class="form-control" value="<?= esc($button_color) ?>"
                                            pattern="^#[a-fA-F0-9]{6}$" required
                                            oninput="updateColorFromInput('button', this.value)">
                                    </div>
                                    <div class="color-preview" id="buttonPreview"
                                        style="background-color: <?= esc($button_color) ?>">
                                        Pratinjau Tombol
                                    </div>
                                </div>

                                <!-- Link Hover Color -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">🔗 Warna Link Saat Diarahkan</label>
                                    <p class="text-muted small">Warna saat mengarahkan kursor ke tautan dan item menu
                                    </p>
                                    <div class="color-input-group">
                                        <input type="color" id="linkColorPicker" value="<?= esc($link_hover_color) ?>"
                                            onchange="updateColor('link', this.value)">
                                        <input type="text" name="theme_link_hover_color" id="linkColorInput"
                                            class="form-control" value="<?= esc($link_hover_color) ?>"
                                            pattern="^#[a-fA-F0-9]{6}$" required
                                            oninput="updateColorFromInput('link', this.value)">
                                    </div>
                                    <div class="color-preview" id="linkPreview"
                                        style="background-color: <?= esc($link_hover_color) ?>">
                                        Pratinjau Link Hover
                                    </div>
                                </div>

                                <!-- Heading Color -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">📝 Warna Judul (H2)</label>
                                    <p class="text-muted small">Warna untuk semua judul H2 di beranda</p>
                                    <div class="color-input-group">
                                        <input type="color" id="headingColorPicker" value="<?= esc($heading_color) ?>"
                                            onchange="updateColor('heading', this.value)">
                                        <input type="text" name="theme_heading_color" id="headingColorInput"
                                            class="form-control" value="<?= esc($heading_color) ?>"
                                            pattern="^#[a-fA-F0-9]{6}$" required
                                            oninput="updateColorFromInput('heading', this.value)">
                                    </div>
                                    <div class="color-preview" id="headingPreview"
                                        style="background-color: #f8f9fa; color: <?= esc($heading_color) ?>; border-color: <?= esc($heading_color) ?>">
                                        <h2 style="margin: 0; font-size: 1.5rem;">Contoh Judul</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="ph ph-eye me-2"></i>Pratinjau Langsung</h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted small mb-3">Lihat bagaimana tampilan warna Anda:</p>

                                <div class="mb-3">
                                    <small class="text-muted d-block mb-1">Navigasi</small>
                                    <div id="previewNavbar"
                                        style="background-color: <?= esc($navbar_color) ?>; opacity: 0.6; color: white; padding: 10px; border-radius: 4px; text-align: center;">
                                        Navigasi Atas
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <small class="text-muted d-block mb-1">Overlay Slider</small>
                                    <div id="previewSlider"
                                        style="background-color: <?= esc($slider_overlay_color) ?>; opacity: 0.6; color: white; padding: 15px; border-radius: 4px; text-align: center;">
                                        Bagian Hero
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <small class="text-muted d-block mb-1">Footer</small>
                                    <div id="previewFooter"
                                        style="background-color: <?= esc($footer_color) ?>; color: white; padding: 10px; border-radius: 4px; text-align: center;">
                                        Bagian Footer
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <small class="text-muted d-block mb-1">Tombol</small>
                                    <button type="button" class="btn btn-lg w-100" id="previewButton"
                                        style="background-color: <?= esc($button_color) ?>; color: white; border: none;">
                                        Tombol Utama
                                    </button>
                                </div>

                                <div class="mb-3">
                                    <small class="text-muted d-block mb-1">Link Hover</small>
                                    <div class="p-3" id="previewLink"
                                        style="background-color: <?= esc($link_hover_color) ?>; color: white; border-radius: 4px; text-align: center;">
                                        Tautan Saat Diarahkan
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <small class="text-muted d-block mb-1">Judul (H2)</small>
                                    <div class="p-3" id="previewHeading"
                                        style="background-color: #f8f9fa; border-radius: 4px; text-align: center;">
                                        <h2 style="margin: 0; font-size: 1.3rem; color: <?= esc($heading_color) ?>">
                                            Judul Halaman</h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body text-center">
                                <button type="submit" class="btn btn-primary btn-lg w-100 mb-2">
                                    <i class="ph ph-floppy-disk me-2"></i>Simpan Perubahan
                                </button>

                                <a href="<?= base_url('admin/theme/reset') ?>" class="btn btn-outline-secondary w-100"
                                    onclick="return confirm('Reset semua warna ke biru default?')">
                                    <i class="ph ph-arrow-counter-clockwise me-2"></i>Reset ke Default
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>

    <?= view('layouts/footer_js') ?>

    <script>
        function updateColor(type, color) {
            // Update input field
            document.getElementById(type + 'ColorInput').value = color;

            // Update preview
            const preview = document.getElementById(type + 'Preview');
            preview.style.backgroundColor = color;

            // Update preview panel
            if (type === 'navbar') {
                document.getElementById('previewNavbar').style.backgroundColor = color;
            } else if (type === 'slider') {
                document.getElementById('previewSlider').style.backgroundColor = color;
            } else if (type === 'footer') {
                document.getElementById('previewFooter').style.backgroundColor = color;
            } else if (type === 'button') {
                document.getElementById('previewButton').style.backgroundColor = color;
            } else if (type === 'link') {
                document.getElementById('previewLink').style.backgroundColor = color;
            } else if (type === 'heading') {
                // For heading, update text color not background
                const headingPreview = document.getElementById('headingPreview');
                headingPreview.style.color = color;
                headingPreview.style.borderColor = color;
                const h2 = headingPreview.querySelector('h2');
                if (h2) h2.style.color = color;

                // Update preview panel
                const previewHeading = document.getElementById('previewHeading');
                const previewH2 = previewHeading.querySelector('h2');
                if (previewH2) previewH2.style.color = color;
            }
        }

        function updateColorFromInput(type, color) {
            // Validate hex color
            if (/^#[0-9A-F]{6}$/i.test(color)) {
                // Update color picker
                document.getElementById(type + 'ColorPicker').value = color;

                // Update preview
                updateColor(type, color);
            }
        }
    </script>
</body>

</html>