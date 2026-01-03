<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="<?= base_url($homeUrl ?? '/') ?>"
                class="b-brand text-primary d-flex align-items-center gap-2 text-decoration-none">
                <i class="ph ph-graduation-cap text-white" style="font-size: 1.5rem;"></i>
                <span class="fw-bold text-white" style="font-size: 1.25rem;">Maarif Rdb</span>
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <?php
                if (!isset($menuItems)) {
                    $role = session()->get('role');
                    $currentUri = uri_string();

                    if ($role == 'admin') {
                        $menuItems = [
                            [
                                'caption' => 'Navigasi',
                                'items' => [
                                    [
                                        'label' => 'Dashboard',
                                        'url' => 'admin/dashboard',
                                        'icon' => 'ph ph-gauge',
                                        'active' => strpos($currentUri, 'admin/dashboard') !== false
                                    ]
                                ]
                            ],
                            [
                                'caption' => 'Manajemen Pengguna',
                                'items' => [
                                    [
                                        'label' => 'Semua Pengguna',
                                        'url' => 'admin/users',
                                        'icon' => 'ph ph-users-three',
                                        'active' => strpos($currentUri, 'admin/users') === 0 && strpos($currentUri, 'students') === false && strpos($currentUri, 'teachers') === false
                                    ],
                                    [
                                        'label' => 'Guru',
                                        'url' => 'admin/teachers',
                                        'icon' => 'ph ph-chalkboard-teacher',
                                        'active' => strpos($currentUri, 'admin/teachers') !== false
                                    ],
                                    [
                                        'label' => 'Siswa',
                                        'url' => 'admin/students',
                                        'icon' => 'ph ph-student',
                                        'active' => strpos($currentUri, 'admin/students') !== false
                                    ],
                                    [
                                        'label' => 'Staf',
                                        'url' => 'admin/staff',
                                        'icon' => 'ph ph-users-three',
                                        'active' => strpos($currentUri, 'admin/staff') !== false
                                    ],
                                    [
                                        'label' => 'Testimoni',
                                        'url' => 'admin/testimonials',
                                        'icon' => 'ph ph-quotes',
                                        'active' => strpos($currentUri, 'admin/testimonials') !== false
                                    ]
                                ]
                            ],
                            [
                                'caption' => 'Akademik',
                                'items' => [
                                    [
                                        'label' => 'Kelas',
                                        'url' => 'admin/classes',
                                        'icon' => 'ph ph-chalkboard-simple',
                                        'active' => strpos($currentUri, 'admin/classes') !== false
                                    ],
                                    [
                                        'label' => 'Ujian CBT',
                                        'url' => 'admin/cbt',
                                        'icon' => 'ph ph-laptop',
                                        'active' => strpos($currentUri, 'admin/cbt') !== false
                                    ],
                                    [
                                        'label' => 'Materi Pelajaran',
                                        'url' => 'admin/materials',
                                        'icon' => 'ph ph-books',
                                        'active' => strpos($currentUri, 'admin/materials') !== false
                                    ],
                                    [
                                        'label' => 'Absensi',
                                        'url' => 'admin/attendance',
                                        'icon' => 'ph ph-clock-user',
                                        'active' => strpos($currentUri, 'admin/attendance') !== false
                                    ],
                                    [
                                        'label' => 'E-Rapor',
                                        'url' => 'admin/reports',
                                        'icon' => 'ph ph-file-text',
                                        'active' => strpos($currentUri, 'admin/reports') !== false
                                    ],
                                    [
                                        'label' => 'Laporan Ujian Publik',
                                        'url' => 'admin/public-exam-reports',
                                        'icon' => 'ph ph-globe',
                                        'active' => strpos($currentUri, 'admin/public-exam-reports') !== false
                                    ],
                                    [
                                        'label' => 'PPDB',
                                        'url' => 'admin/ppdb',
                                        'icon' => 'ph ph-clipboard-text',
                                        'active' => strpos($currentUri, 'admin/ppdb') !== false
                                    ]
                                ]
                            ],
                            [
                                'caption' => 'Konten & Pengaturan',
                                'items' => [
                                    [
                                        'label' => 'Manajemen Beranda',
                                        'url' => 'admin/homepage',
                                        'icon' => 'ph ph-house-line',
                                        'active' => strpos($currentUri, 'admin/homepage') !== false
                                    ],
                                    [
                                        'label' => 'Manajemen Berita',
                                        'url' => 'admin/news',
                                        'icon' => 'ph ph-newspaper',
                                        'active' => strpos($currentUri, 'admin/news') !== false
                                    ],
                                    [
                                        'label' => 'Slider Gambar',
                                        'url' => 'admin/sliders',
                                        'icon' => 'ph ph-images',
                                        'active' => strpos($currentUri, 'admin/sliders') !== false
                                    ],
                                    [
                                        'label' => 'Pengaturan Tema',
                                        'url' => 'admin/theme',
                                        'icon' => 'ph ph-palette',
                                        'active' => strpos($currentUri, 'admin/theme') !== false
                                    ],
                                    [
                                        'label' => 'Pengaturan Sistem',
                                        'url' => 'admin/settings',
                                        'icon' => 'ph ph-gear-six',
                                        'active' => strpos($currentUri, 'admin/settings') !== false
                                    ]
                                ]
                            ]
                        ];
                    } elseif ($role == 'guru') {
                        $menuItems = [
                            [
                                'caption' => 'Utama',
                                'items' => [
                                    [
                                        'label' => 'Dashboard',
                                        'url' => 'guru/dashboard',
                                        'icon' => 'ph ph-gauge',
                                        'active' => strpos($currentUri, 'guru/dashboard') !== false
                                    ]
                                ]
                            ],
                            [
                                'caption' => 'Akademik',
                                'items' => [
                                    [
                                        'label' => 'Kelas Saya',
                                        'url' => 'guru/classes',
                                        'icon' => 'ph ph-chalkboard-teacher',
                                        'active' => strpos($currentUri, 'guru/classes') !== false
                                    ],
                                    [
                                        'label' => 'Siswa',
                                        'url' => 'guru/students',
                                        'icon' => 'ph ph-student',
                                        'active' => strpos($currentUri, 'guru/students') !== false
                                    ],
                                    [
                                        'label' => 'Input Perilaku',
                                        'url' => 'guru/conduct',
                                        'icon' => 'ph ph-smiley',
                                        'active' => strpos($currentUri, 'guru/conduct') !== false
                                    ],
                                    [
                                        'label' => 'Materi Pelajaran',
                                        'url' => 'guru/materials',
                                        'icon' => 'ph ph-books',
                                        'active' => strpos($currentUri, 'guru/materials') !== false
                                    ],
                                    [
                                        'label' => 'Ujian CBT',
                                        'url' => 'guru/cbt',
                                        'icon' => 'ph ph-laptop',
                                        'active' => strpos($currentUri, 'guru/cbt') !== false
                                    ],
                                    [
                                        'label' => 'Laporan',
                                        'url' => 'guru/reports',
                                        'icon' => 'ph ph-chart-line-up',
                                        'active' => strpos($currentUri, 'guru/reports') !== false
                                    ]
                                ]
                            ]
                        ];
                    }
                }
                ?>
                <?php if (isset($menuItems) && is_array($menuItems)): ?>
                    <?php foreach ($menuItems as $section): ?>
                        <?php if (isset($section['caption'])): ?>
                            <li class="pc-item pc-caption">
                                <label><?= esc($section['caption']) ?></label>
                                <?php if (isset($section['icon'])): ?>
                                    <i class="<?= esc($section['icon']) ?>"></i>
                                <?php endif; ?>
                            </li>
                        <?php endif; ?>

                        <?php if (isset($section['items']) && is_array($section['items'])): ?>
                            <?php foreach ($section['items'] as $item): ?>
                                <li class="pc-item <?= isset($item['submenu']) ? 'pc-hasmenu' : '' ?>">
                                    <a href="<?= isset($item['submenu']) ? '#!' : base_url($item['url'] ?? '#') ?>"
                                        class="pc-link <?= (isset($item['active']) && $item['active']) ? 'active' : '' ?>">
                                        <span class="pc-micon">
                                            <i class="<?= esc($item['icon'] ?? 'ph ph-circle') ?>"></i>
                                        </span>
                                        <span class="pc-mtext"><?= esc($item['label']) ?></span>
                                        <?php if (isset($item['badge'])): ?>
                                            <span class="pc-badge"><?= esc($item['badge']) ?></span>
                                        <?php endif; ?>
                                        <?php if (isset($item['submenu'])): ?>
                                            <span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>
                                        <?php endif; ?>
                                    </a>

                                    <?php if (isset($item['submenu']) && is_array($item['submenu'])): ?>
                                        <ul class="pc-submenu">
                                            <?php foreach ($item['submenu'] as $subitem): ?>
                                                <li class="pc-item">
                                                    <a class="pc-link" href="<?= base_url($subitem['url'] ?? '#') ?>">
                                                        <?= esc($subitem['label']) ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<!-- [ Sidebar Menu ] end -->