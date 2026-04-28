// Chatbot Assistant logic
document.addEventListener('DOMContentLoaded', () => {
    const launcher = document.getElementById('chatbot-launcher');
    const chatWindow = document.getElementById('chatbot-window');
    const closeBtn = document.querySelector('.chatbot-close');
    const options = document.getElementById('chatbot-options');
    const content = document.getElementById('chatbot-content');
    const typing = document.getElementById('chatbot-typing');

    if (!launcher) return;

    // Toggle Chat Window
    launcher.addEventListener('click', () => {
        chatWindow.classList.toggle('active');
        launcher.classList.toggle('active');
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
            const answer = this.getAttribute('data-answer');

            // Add user message
            addMessage(question, 'user');

            // Disable options during typing
            if (options) {
                options.style.opacity = '0.5';
                options.style.pointerEvents = 'none';
            }

            // Show typing indicator
            if (typing) typing.style.display = 'flex';
            content.scrollTop = content.scrollHeight;

            // Simulated bot response after 3 seconds
            setTimeout(() => {
                if (typing) typing.style.display = 'none';
                addMessage(answer, 'bot');
                
                // Re-enable options
                if (options) {
                    options.style.opacity = '1';
                    options.style.pointerEvents = 'all';
                }
                
                content.scrollTop = content.scrollHeight;
            }, 3000);
        });
    });

    function addMessage(text, side) {
        const msgDiv = document.createElement('div');
        msgDiv.className = `message ${side}`;
        msgDiv.innerText = text;
        if (typing) {
            content.insertBefore(msgDiv, typing);
        } else {
            content.appendChild(msgDiv);
        }
        content.scrollTop = content.scrollHeight;
    }
});
