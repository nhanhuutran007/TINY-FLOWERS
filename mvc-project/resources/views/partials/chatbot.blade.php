<!-- Chatbot Assistant -->
<div id="chatbot-launcher">
    TF
</div>

<div id="chatbot-window">
    <div class="chatbot-header">
        <div class="chatbot-header-info">
            <div class="chatbot-avatar">TF</div>
            <div class="chatbot-name">
                <h4>TF Assistant</h4>
                <span>Trực tuyến</span>
            </div>
        </div>
        <div class="chatbot-header-actions">
            <button id="chatbot-clear" title="Xóa lịch sử chat"><i class="fas fa-trash-alt"></i></button>
            <div class="chatbot-close">
                <i class="fas fa-times"></i>
            </div>
        </div>
    </div>

    <div id="chatbot-content">
        <div class="message bot">
            Chào mừng bạn đến với TINY FLOWERS! Tôi có thể giúp gì cho bạn?
        </div>
        <div class="typing" id="chatbot-typing">
            <span></span><span></span><span></span>
        </div>
    </div>

    <div class="chatbot-options" id="chatbot-options">
        <button class="option-btn" data-question="Sản phẩm còn hàng không?">Sản phẩm còn hàng không?</button>
        <button class="option-btn" data-question="Thời gian giao hàng bao lâu?">Thời gian giao hàng bao lâu?</button>
        <button class="option-btn" data-question="Chính sách đổi trả thế nào?">Chính sách đổi trả thế nào?</button>
    </div>

    <div class="chatbot-input-area">
        <button id="chatbot-toggle-options" title="Câu hỏi gợi ý"><i class="fas fa-lightbulb"></i></button>
        <input type="text" id="chatbot-input" placeholder="Nhập tin nhắn..." autocomplete="off">
        <button id="chatbot-send"><i class="fas fa-paper-plane"></i></button>
    </div>
</div>

<script>
    window.TF_CONFIG = window.TF_CONFIG || {};
    window.TF_CONFIG.chatbotChatUrl = '{{ route('chatbot.chat') }}';
    window.TF_CONFIG.csrfToken = '{{ csrf_token() }}';
</script>
<script src="{{ asset('js/chatbot.js') }}?v={{ time() }}"></script>
