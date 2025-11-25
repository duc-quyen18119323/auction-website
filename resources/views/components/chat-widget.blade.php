<link rel="stylesheet" href="{{ asset('css/chat.css') }}">

<div id="chat-widget-btn">
    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="none" viewBox="0 0 24 24"
         stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.77 9.77 0 01-4.39-1.02L3 20l1.02-3.61A8.96 8.96 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
    </svg>
</div>

<div id="chat-widget-box">
    {{-- HEADER --}}
    <div class="chat-header">
        <div class="chat-header-left">
            <div class="chat-header-avatar">CS</div>
            <div class="chat-header-text">
                <span class="chat-header-name">Hỗ trợ QBidzone</span>
                <span class="chat-header-status">Đang hoạt động</span>
            </div>
        </div>
        <div class="chat-header-actions">
            <button type="button" class="chat-header-btn" id="chat-minimize-btn">−</button>
            <button type="button" class="chat-header-btn" id="chat-close-btn">&times;</button>
        </div>
    </div>

    {{-- MESSAGES --}}
    <div id="chat-messages"></div>

    {{-- INPUT --}}
    <form id="chat-form">
        <label for="chat-image" style="margin-right: 6px; cursor:pointer;">
            📎
        </label>
        <input type="file" id="chat-image" accept="image/*" style="display:none">

        <input type="text" id="chat-input" placeholder="Aa" autocomplete="off">

        <button type="submit" id="chat-send-btn">Gửi</button>
    </form>
</div>

<script>
    const chatBtn     = document.getElementById('chat-widget-btn');
    const chatBox     = document.getElementById('chat-widget-box');
    const closeBtn    = document.getElementById('chat-close-btn');
    const minimizeBtn = document.getElementById('chat-minimize-btn');
    const form        = document.getElementById('chat-form');
    const input       = document.getElementById('chat-input');
    const msgBox      = document.getElementById('chat-messages');
    const imageEl     = document.getElementById('chat-image');

    chatBtn.onclick = function () {
        chatBox.classList.toggle('active');
        if (chatBox.classList.contains('active')) {
            loadMessages();
        }
    };

    closeBtn.onclick = function () {
        chatBox.classList.remove('active');
    };

    minimizeBtn.onclick = function () {
        chatBox.classList.remove('active');
    };

    form.onsubmit = function (e) {
        e.preventDefault();
        sendMessage();
    };

    function renderMessages(data) {
        let html = '';
        data.forEach(msg => {
            const me = !msg.is_admin; // user = me

            let content = '';
            if (msg.message) {
                content += `<div>${msg.message}</div>`;
            }
            if (msg.image_url) {
                content += `
                    <div style="margin-top:4px;">
                        <img src="${msg.image_url}"
                             style="max-width:200px;border-radius:8px;display:block;">
                    </div>`;
            }

            html += `
                <div class="chat-row ${me ? 'me' : 'other'}">
                    ${me ? '' : `<div class="chat-avatar">U</div>`}
                    <div class="chat-msg">
                        <div class="chat-bubble ${me ? 'me' : 'other'}">
                            ${content}
                        </div>
                        <div class="chat-time">${msg.created_at}</div>
                    </div>
                </div>`;
        });

        msgBox.innerHTML = html;
        msgBox.scrollTop = msgBox.scrollHeight;
    }

    function loadMessages() {
        fetch('/support/messages')
            .then(res => res.json())
            .then(data => renderMessages(data));
    }

    function sendMessage() {
        const text = input.value.trim();
        const file = imageEl.files[0];

        // Không có text và cũng không có ảnh thì không gửi
        if (!text && !file) return;

        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('message', text);
        if (file) {
            formData.append('image', file);
        }

        fetch('/support/send', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(() => {
            input.value = '';
            imageEl.value = '';
            loadMessages();
        });
    }
</script>
