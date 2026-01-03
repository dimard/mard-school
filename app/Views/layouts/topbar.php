<!-- [ Header Topbar ] start -->
<header class="pc-header">
    <div class="header-wrapper">
        <!-- [Mobile Media Block] start -->
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                <li class="pc-h-item pc-sidebar-collapse">
                    <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                        <i class="ph ph-list"></i>
                    </a>
                </li>
                <li class="pc-h-item pc-sidebar-popup">
                    <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                        <i class="ph ph-list"></i>
                    </a>
                </li>
                <li class="dropdown pc-h-item">
                    <a class="pc-head-link dropdown-toggle arrow-none m-0 trig-drp-search" data-bs-toggle="dropdown"
                        href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="ph ph-magnifying-glass"></i>
                    </a>
                    <div class="dropdown-menu pc-h-dropdown drp-search">
                        <form class="px-3 py-2" action="<?= base_url('search') ?>" method="get">
                            <input type="search" name="q" class="form-control border-0 shadow-none"
                                placeholder="Search here..." />
                        </form>
                    </div>
                </li>
            </ul>
        </div>
        <!-- [Mobile Media Block end] -->

        <div class="ms-auto">
            <ul class="list-unstyled">
                <!-- Notifications -->
                <li class="dropdown pc-h-item">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="ph ph-bell"></i>
                        <?php if (isset($notificationCount) && $notificationCount > 0): ?>
                            <span class="badge bg-success pc-h-badge"><?= $notificationCount ?></span>
                        <?php endif; ?>
                    </a>
                    <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header d-flex align-items-center justify-content-between">
                            <h5 class="m-0">Notifications</h5>
                            <a href="#!" class="btn btn-link btn-sm">Mark all read</a>
                        </div>
                        <div class="dropdown-body text-wrap header-notification-scroll position-relative"
                            style="max-height: calc(100vh - 215px)">
                            <?php if (isset($notifications) && !empty($notifications)): ?>
                                <?php foreach ($notifications as $notification): ?>
                                    <div class="card bg-transparent mb-0">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <h5 class="text-body mb-2">
                                                        <?= esc($notification['title'] ?? 'Notification') ?></h5>
                                                    <p class="mb-0"><?= esc($notification['message'] ?? '') ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center py-4">
                                    <p class="text-muted">No new notifications</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="text-center py-2">
                            <a href="<?= base_url('notifications') ?>" class="link-primary">View all Notifications</a>
                        </div>
                    </div>
                </li>

                <!-- User Profile -->
                <li class="dropdown pc-h-item header-user-profile">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                        <i class="ph ph-user-circle"></i>
                    </a>
                    <div
                        class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown p-0 overflow-hidden">
                        <div class="dropdown-header d-flex align-items-center justify-content-between bg-primary">
                            <div class="d-flex my-2">
                                <div class="flex-shrink-0">
                                    <img src="<?= base_url('assets/images/user/avatar-2.png') ?>" alt="user-image"
                                        class="user-avatar wid-35" />
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="text-white mb-1">
                                        <?= esc(session()->get('full_name') ?? session()->get('username')) ?></h6>
                                    <span
                                        class="text-white text-opacity-75"><?= esc(session()->get('email') ?? '') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-body">
                            <div class="profile-notification-scroll position-relative"
                                style="max-height: calc(100vh - 225px)">
                                <?php if (isset($profileUrl)): ?>
                                    <a href="<?= base_url($profileUrl) ?>" class="dropdown-item">
                                        <span>
                                            <i class="ph ph-user align-middle me-2"></i>
                                            <span>My Profile</span>
                                        </span>
                                    </a>
                                <?php endif; ?>
                                <?php if (isset($settingsUrl)): ?>
                                    <a href="<?= base_url($settingsUrl) ?>" class="dropdown-item">
                                        <span>
                                            <i class="ph ph-gear align-middle me-2"></i>
                                            <span>Settings</span>
                                        </span>
                                    </a>
                                <?php endif; ?>
                                <div class="d-grid my-2">
                                    <a href="<?= base_url('auth/logout') ?>" class="btn btn-primary">
                                        <i class="ph ph-sign-out align-middle me-2"></i>Logout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>
<!-- [ Header ] end -->