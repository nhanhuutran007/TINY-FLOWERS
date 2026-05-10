<!-- Admin AI Assistant -->
<div id="admin-chatbot-launcher">
    <i class="fas fa-robot"></i>
</div>

<div id="admin-chatbot-window">
    <div class="admin-chatbot-header">
        <div class="admin-chatbot-header-info">
            <div class="admin-chatbot-avatar"><i class="fas fa-chart-line"></i></div>
            <div class="admin-chatbot-name">
                <h4>BI Assistant</h4>
                <span>Hệ thống phân tích</span>
            </div>
        </div>
        <div class="admin-chatbot-header-actions">
            <button id="admin-chatbot-clear" title="Xóa hội thoại"><i class="fas fa-sync-alt"></i></button>
            <div class="admin-chatbot-close">
                <i class="fas fa-times"></i>
            </div>
        </div>
    </div>

    <div id="admin-chatbot-content">
        <div class="message bot">
            Chào Admin! Tôi là trợ lý phân tích dữ liệu của TINY FLOWERS. Tôi có thể giúp bạn kiểm tra doanh thu, hàng tồn hoặc đề xuất chiến lược kinh doanh.
        </div>
        <div class="typing" id="admin-chatbot-typing">
            <span></span><span></span><span></span>
        </div>
    </div>

    <div class="admin-chatbot-options" id="admin-chatbot-options">
        <button class="admin-option-btn" data-question="Báo cáo doanh thu hôm nay">Doanh thu hôm nay?</button>
        <button class="admin-option-btn" data-question="Sản phẩm nào bán chạy nhất?">Top sản phẩm?</button>
        <button class="admin-option-btn" data-question="Cảnh báo hàng tồn kho">Cảnh báo tồn kho?</button>
        <button class="admin-option-btn" data-question="Đề xuất chiến lược tháng này">Chiến lược tháng này?</button>
    </div>

    <div class="admin-chatbot-input-area">
        <input type="text" id="admin-chatbot-input" placeholder="Hỏi tôi về số liệu..." autocomplete="off">
        <button id="admin-chatbot-send"><i class="fas fa-paper-plane"></i></button>
    </div>
</div>

<script>
    window.ADMIN_CONFIG = {
        chatUrl: '{{ route('admin-chatbot.chat') }}',
        csrfToken: '{{ csrf_token() }}'
    };
</script>
<script src="{{ asset('js/admin-chatbot.js') }}?v={{ time() }}"></script>
