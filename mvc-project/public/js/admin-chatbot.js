// Admin AI Assistant logic
document.addEventListener('DOMContentLoaded', () => {
    const launcher = document.getElementById('admin-chatbot-launcher');
    const window = document.getElementById('admin-chatbot-window');
    const closeBtn = document.querySelector('.admin-chatbot-close');
    const content = document.getElementById('admin-chatbot-content');
    const input = document.getElementById('admin-chatbot-input');
    const sendBtn = document.getElementById('admin-chatbot-send');
    const typing = document.getElementById('admin-chatbot-typing');
    const clearBtn = document.getElementById('admin-chatbot-clear');

    if (!launcher) return;

    // Toggle Chat Window
    launcher.addEventListener('click', () => {
        window.classList.toggle('active');
        if (window.classList.contains('active')) {
            input.focus();
        }
    });

    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            window.classList.remove('active');
        });
    }

    // Handle Sending Messages
    async function handleSendMessage(text) {
        if (!text.trim()) return;

        addMessage(text, 'user');
        input.value = '';

        if (typing) typing.style.display = 'flex';
        content.scrollTop = content.scrollHeight;

        try {
            const response = await fetch(ADMIN_CONFIG.chatUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': ADMIN_CONFIG.csrfToken
                },
                body: JSON.stringify({ message: text })
            });

            const data = await response.json();

            if (typing) typing.style.display = 'none';

            if (data.reply) {
                addMessage(data.reply, 'bot');
            } else {
                addMessage("Xin lỗi Admin, tôi gặp sự cố khi kết nối dữ liệu.", 'bot');
            }
        } catch (error) {
            console.error('Admin AI Error:', error);
            if (typing) typing.style.display = 'none';
            addMessage("Lỗi hệ thống, Admin vui lòng kiểm tra console.", 'bot');
        }
        
        content.scrollTop = content.scrollHeight;
    }

    function addMessage(text, side) {
        const msgDiv = document.createElement('div');
        msgDiv.className = `message ${side}`;
        
        // Basic Markdown formatting
        let formattedText = text
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\n/g, '<br>')
            .replace(/•/g, '&bull;')
            .replace(/- /g, '&bull; ');
            
        msgDiv.innerHTML = `<div class="message-text">${formattedText}</div>`;

        if (typing) {
            content.insertBefore(msgDiv, typing);
        } else {
            content.appendChild(msgDiv);
        }
        content.scrollTop = content.scrollHeight;
    }

    // Event Listeners
    input.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            handleSendMessage(input.value);
        }
    });

    sendBtn.addEventListener('click', () => {
        handleSendMessage(input.value);
    });

    document.querySelectorAll('.admin-option-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            handleSendMessage(this.getAttribute('data-question'));
        });
    });

    if (clearBtn) {
        clearBtn.addEventListener('click', () => {
            const messages = content.querySelectorAll('.message:not(.bot:first-child)');
            messages.forEach(m => m.remove());
        });
    }
});
