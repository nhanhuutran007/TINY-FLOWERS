// Admin Dashboard logic
document.addEventListener('DOMContentLoaded', function () {
    // --- Dropdown Management ---
    const topbarNotif = document.getElementById('topbar-notif');
    const notifPanel = document.getElementById('notif-panel');
    const topbarUserBtn = document.getElementById('topbar-user-btn');
    const userDropdown = document.getElementById('user-dropdown');
    const topbarSearch = document.getElementById('top-bar-search');
    const searchSuggestions = document.getElementById('search-suggestions');

    if (!topbarNotif) return; // Not on admin page

    function closeAllDropdowns() {
        if(notifPanel) notifPanel.classList.add('d-none');
        if(userDropdown) userDropdown.classList.add('d-none');
        if(searchSuggestions) searchSuggestions.classList.add('d-none');
    }

    topbarNotif.addEventListener('click', function (e) {
        e.stopPropagation();
        if(userDropdown) userDropdown.classList.add('d-none');
        if(notifPanel) {
            notifPanel.classList.toggle('d-none');
            if (!notifPanel.classList.contains('d-none')) {
                fetchStockAlerts();
            }
        }
    });

    if (topbarUserBtn) {
        topbarUserBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            if(notifPanel) notifPanel.classList.add('d-none');
            if(userDropdown) userDropdown.classList.toggle('d-none');
        });
    }

    document.addEventListener('click', function (e) {
        if (notifPanel && !notifPanel.contains(e.target) && !topbarNotif.contains(e.target)) {
            notifPanel.classList.add('d-none');
        }
        if (userDropdown && !userDropdown.contains(e.target) && !topbarUserBtn.contains(e.target)) {
            userDropdown.classList.add('d-none');
        }
        if (searchSuggestions && !searchSuggestions.contains(e.target) && !topbarSearch.contains(e.target)) {
            searchSuggestions.classList.add('d-none');
        }
    });

    // --- Stock Alerts Logic ---
    const notifList = document.getElementById('notif-list');
    const notifBadge = document.getElementById('notif-badge');
    const notifSummary = document.getElementById('notif-summary');

    function fetchStockAlerts() {
        const url = window.stockAlertsUrl || '/api/stock-alerts';
        fetch(url)
            .then(response => response.json())
            .then(data => {
                renderAlerts(data);
            })
            .catch(err => {
                if(notifList) notifList.innerHTML = '<div class="notif-loading text-danger">Không thể tải dữ liệu</div>';
            });
    }

    function renderAlerts(data) {
        if (!notifList) return;
        
        if (data.total === 0) {
            notifList.innerHTML = '<div class="notif-loading text-success"><i class="fas fa-check-circle"></i> Mọi thứ đều ổn!</div>';
            if(notifBadge) {
                notifBadge.classList.add('d-none');
                notifBadge.innerText = '';
            }
            if(notifSummary) notifSummary.classList.add('d-none');
            return;
        }

        if(notifBadge) {
            notifBadge.classList.remove('d-none');
            notifBadge.innerText = data.total > 9 ? '9+' : data.total;
        }
        if(notifSummary) {
            notifSummary.classList.remove('d-none');
            notifSummary.innerText = data.total + ' cảnh báo';
        }

        let html = '';
        data.out_of_stock.forEach(p => {
            html += `
                <a href="/products?search=${p.barcode}" class="notif-item">
                    <div class="notif-icon out"><i class="fas fa-times-circle"></i></div>
                    <div class="notif-info">
                        <span class="notif-name">${p.name}</span>
                        <div class="notif-desc"><span>${p.barcode}</span><span class="text-danger">Hết hàng</span></div>
                    </div>
                </a>
            `;
        });
        data.low_stock.forEach(p => {
            html += `
                <a href="/products?search=${p.barcode}" class="notif-item">
                    <div class="notif-icon low"><i class="fas fa-exclamation-triangle"></i></div>
                    <div class="notif-info">
                        <span class="notif-name">${p.name}</span>
                        <div class="notif-desc"><span>${p.barcode}</span><span class="text-warning">Còn ${p.stock_quantity}</span></div>
                    </div>
                </a>
            `;
        });
        notifList.innerHTML = html;
    }

    // Initial silent fetch
    const initStockFetch = () => {
        const url = window.stockAlertsUrl || '/api/stock-alerts';
        console.log('Fetching stock alerts from:', url);
        
        fetch(url)
            .then(r => {
                if (!r.ok) throw new Error('HTTP error ' + r.status);
                return r.json();
            })
            .then(data => {
                console.log('Stock alerts data received:', data);
                if (data.total > 0 && notifBadge) {
                    notifBadge.classList.remove('d-none');
                    notifBadge.innerText = data.total > 9 ? '9+' : data.total;
                    notifBadge.style.display = 'flex'; // Force display
                } else {
                    if(notifBadge) {
                        notifBadge.classList.add('d-none');
                        notifBadge.style.display = 'none';
                    }
                }
            })
            .catch(err => {
                console.error('Failed to init stock alerts:', err);
                // Fallback to relative path if absolute failed
                if (window.stockAlertsUrl && !window.stockAlertsUrl.includes('/api/stock-alerts')) {
                     console.log('Retrying with relative path...');
                     // Try a simpler relative path
                     fetch('api/stock-alerts')
                        .then(r => r.json())
                        .then(data => {
                            if (data.total > 0 && notifBadge) {
                                notifBadge.classList.remove('d-none');
                                notifBadge.innerText = data.total > 9 ? '9+' : data.total;
                                notifBadge.style.display = 'flex';
                            }
                        }).catch(e => console.error('Final fallback failed:', e));
                }
            });
    };

    if (topbarNotif) {
        initStockFetch();
    }

    // --- Global Search Suggestions ---
    if (topbarSearch) {
        topbarSearch.addEventListener('input', function () {
            const query = this.value.toLowerCase().trim();
            if (query.length === 0) {
                if(searchSuggestions) searchSuggestions.classList.add('d-none');
                return;
            }

            if (!window.ADMIN_FEATURES) return;

            const filtered = window.ADMIN_FEATURES.filter(f => f.title.toLowerCase().includes(query));
            renderSearchSuggestions(filtered);
        });
    }

    function renderSearchSuggestions(items) {
        if (!searchSuggestions) return;
        
        if (items.length === 0) {
            searchSuggestions.innerHTML = '<div class="search-no-result">Không tìm thấy chức năng này</div>';
        } else {
            let html = '';
            items.forEach(item => {
                html += `
                    <a href="${item.route}" class="search-item">
                        <i class="fas ${item.icon}"></i>
                        <span>${item.title}</span>
                    </a>
                `;
            });
            searchSuggestions.innerHTML = html;
        }
        searchSuggestions.classList.remove('d-none');
    }
});
