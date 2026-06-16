/**
 * sidebar.js — Laskar Cilik
 *
 * Satu tombol: #sidebarToggleBtn (di header, tidak ikut geser).
 *
 * Desktop (>768px) : toggle body.sidebar-collapsed
 * Mobile  (≤768px) : toggle .sidebar-wrapper.open
 *
 * Saat resize: bersihkan state yang tidak relevan
 * agar kedua sistem tidak saling mengganggu.
 */
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {

        var wrapper   = document.getElementById('sidebarWrapper');
        var toggleBtn = document.getElementById('sidebarToggleBtn');

        if (!wrapper || !toggleBtn) return;

        function isMobile() { return window.innerWidth <= 768; }

        toggleBtn.addEventListener('click', function () {
            if (isMobile()) {
                /* Mobile: buka/tutup sidebar overlay */
                wrapper.classList.toggle('open');
            } else {
                /* Desktop: collapse/expand sidebar */
                document.body.classList.toggle('sidebar-collapsed');
            }
        });

        /* Tutup mobile sidebar saat klik backdrop */
        wrapper.addEventListener('click', function (e) {
            if (isMobile() && wrapper.classList.contains('open')) {
                var sidebar = wrapper.querySelector('.sidebar');
                if (sidebar && !sidebar.contains(e.target)) {
                    wrapper.classList.remove('open');
                }
            }
        });

        /* Bersihkan state saat resize agar tidak tumpang tindih */
        var resizeTimer;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function () {
                if (isMobile()) {
                    /* Pindah ke mobile: hapus state desktop */
                    document.body.classList.remove('sidebar-collapsed');
                } else {
                    /* Pindah ke desktop: hapus state mobile */
                    wrapper.classList.remove('open');
                }
            }, 100);
        });

    });
})();