// Chatbot Assistant logic
document.addEventListener('DOMContentLoaded', () => {
    const launcher = document.getElementById('chatbot-launcher');
    const chatWindow = document.getElementById('chatbot-window');
    const closeBtn = document.querySelector('.chatbot-close');
    const options = document.getElementById('chatbot-options');
    const content = document.getElementById('chatbot-content');
    const typing = document.getElementById('chatbot-typing');
    const input = document.getElementById('chatbot-input');
    const sendBtn = document.getElementById('chatbot-send');
    const toggleOptionsBtn = document.getElementById('chatbot-toggle-options');

    if (!launcher) return;

    // Load history from localStorage
    loadHistory();
    
    // Toggle Chat Window
    launcher.addEventListener('click', () => {
        chatWindow.classList.toggle('active');
        launcher.classList.toggle('active');
        if (chatWindow.classList.contains('active')) {
            input.focus();
            markRead();
        }
    });

    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            chatWindow.classList.remove('active');
            launcher.classList.remove('active');
        });
    }

    // Handle Question Clicking
    document.querySelectorAll('.option-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const question = this.getAttribute('data-question');
            handleSendMessage(question);
            hideOptions();
        });
    });

    // Toggle options visibility
    if (toggleOptionsBtn) {
        toggleOptionsBtn.addEventListener('click', () => {
            options.classList.toggle('active');
            toggleOptionsBtn.classList.toggle('active');
        });
    }

    function hideOptions() {
        if (options && options.classList.contains('active')) {
            options.classList.remove('active');
            if (toggleOptionsBtn) toggleOptionsBtn.classList.remove('active');
        }
    }

    // Handle Input Field
    input.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            handleSendMessage(input.value);
            hideOptions();
        }
    });

    sendBtn.addEventListener('click', () => {
        handleSendMessage(input.value);
        hideOptions();
    });

    async function handleSendMessage(text) {
        if (!text.trim()) return;

        // Add user message
        addMessage(text, 'user');
        saveToHistory(text, 'user');
        input.value = '';

        // Show typing indicator
        if (typing) typing.style.display = 'flex';
        content.scrollTop = content.scrollHeight;

        try {
            const response = await fetch(window.TF_CONFIG.chatbotChatUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.TF_CONFIG.csrfToken
                },
                body: JSON.stringify({ message: text })
            });

            const data = await response.json();

            if (typing) typing.style.display = 'none';

            if (data.reply) {
                addMessage(data.reply, 'bot', data.suggested_products);
                saveToHistory(data.reply, 'bot', data.suggested_products);
            } else {
                const errorMsg = "Xin lỗi, tôi gặp chút vấn đề khi kết nối. Bạn vui lòng thử lại sau nhé!";
                addMessage(errorMsg, 'bot');
            }
        } catch (error) {
            console.error('Chatbot Error:', error);
            if (typing) typing.style.display = 'none';
            addMessage("Có lỗi xảy ra, vui lòng kiểm tra kết nối internet.", 'bot');
        }
        
        content.scrollTop = content.scrollHeight;
    }

    function addMessage(text, side, products = []) {
        const msgDiv = document.createElement('div');
        msgDiv.className = `message ${side}`;
        
        // Better markdown-like formatting
        let formattedText = text
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\n/g, '<br>')
            .replace(/\[(.*?)\]\((.*?)\)/g, '<a href="$2" target="_blank">$1</a>');
            
        msgDiv.innerHTML = `<div class="message-text">${formattedText}</div>`;

        // If there are suggested products, add them
        if (products && products.length > 0) {
            const productsDiv = document.createElement('div');
            productsDiv.className = 'suggested-products';
            
            products.forEach(p => {
                const pLink = document.createElement('a');
                pLink.href = p.url;
                pLink.className = 'product-card-mini';
                pLink.innerHTML = `
                    <img src="${p.image}" alt="${p.name}" onerror="this.src='https://placehold.co/100x100?text=No+Image'">
                    <div class="product-info-mini">
                        <h5>${p.name}</h5>
                        <p>${p.price}</p>
                    </div>
                `;
                productsDiv.appendChild(pLink);
            });
            msgDiv.appendChild(productsDiv);
        }

        if (typing) {
            content.insertBefore(msgDiv, typing);
        } else {
            content.appendChild(msgDiv);
        }
        content.scrollTop = content.scrollHeight;
    }

    function saveToHistory(text, side, products = []) {
        let history = JSON.parse(localStorage.getItem('tf_chat_history') || '[]');
        history.push({ text, side, products, time: new Date().getTime() });
        // Keep only last 20 messages
        if (history.length > 20) history.shift();
        localStorage.setItem('tf_chat_history', JSON.stringify(history));
    }

    function loadHistory() {
        const history = JSON.parse(localStorage.getItem('tf_chat_history') || '[]');
        if (history.length > 0) {
            // Clear only messages, keep typing indicator
            const messages = content.querySelectorAll('.message');
            messages.forEach(m => m.remove());
            
            history.forEach(msg => {
                addMessage(msg.text, msg.side, msg.products);
            });
        }
    }

    function markRead() {
        // Implementation for marking messages as read if needed
    }

    const clearBtn = document.getElementById('chatbot-clear');
    if (clearBtn) {
        clearBtn.addEventListener('click', () => {
            if (confirm('Bạn có muốn xóa toàn bộ lịch sử trò chuyện?')) {
                localStorage.removeItem('tf_chat_history');
                location.reload();
            }
        });
    }
});
