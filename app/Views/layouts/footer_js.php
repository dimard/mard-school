<!-- Required Js -->
<script src="<?= base_url('assets/js/plugins/popper.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/simplebar.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/fonts/custom-font.js') ?>"></script>
<script src="<?= base_url('assets/js/pcoded.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/feather.min.js') ?>"></script>

<?php if (isset($includeCharts) && $includeCharts): ?>
    <!-- [Page Specific JS] start -->
    <script src="<?= base_url('assets/js/plugins/apexcharts.min.js') ?>"></script>
    <!-- [Page Specific JS] end -->
<?php endif; ?>

<!-- Initialize layout -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Ensure pcoded layout is initialized
        if (typeof layout_change !== 'undefined') {
            layout_change('light');
        }

        // Initialize Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Additional mobile sidebar click event
        const mobileCollapseBtn = document.getElementById('mobile-collapse');
        if (mobileCollapseBtn) {
            mobileCollapseBtn.addEventListener('click', function (e) {
                e.preventDefault();
                const sidebar = document.querySelector('.pc-sidebar');
                if (sidebar) {
                    sidebar.classList.toggle('mob-sidebar-active');
                }
            });
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function (e) {
            const sidebar = document.querySelector('.pc-sidebar');
            const mobileBtn = document.getElementById('mobile-collapse');

            if (sidebar && sidebar.classList.contains('mob-sidebar-active')) {
                if (!sidebar.contains(e.target) && e.target !== mobileBtn && !mobileBtn.contains(e.target)) {
                    sidebar.classList.remove('mob-sidebar-active');
                }
            }
        });
    });
</script>