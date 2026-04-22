// script.js - Main application scripts

document.addEventListener('DOMContentLoaded', function () {
    // Toggle sidebar trên mobile
    const mobileBtn = document.getElementById('mobile_btn');
    const sidebar   = document.getElementById('sidebar');

    if (mobileBtn && sidebar) {
        mobileBtn.addEventListener('click', function () {
            sidebar.classList.toggle('show');
        });
    }

    // Toggle sidebar collapse trên desktop
    const toggleBtn = document.getElementById('toggle_btn');
    const contentWrapper = document.querySelector('.content-wrapper');

    if (toggleBtn && contentWrapper) {
        toggleBtn.addEventListener('click', function () {
            document.body.classList.toggle('mini-sidebar');
        });
    }

    // Auto-dismiss alerts sau 4 giây
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function (alert) {
        setTimeout(function () {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 4000);
    });
});
