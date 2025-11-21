<style>
#chat-widget-btn {
    position: fixed; bottom: 32px; right: 32px; z-index: 9999;
    background: #2563eb; color: white; border-radius: 50%; width: 56px; height: 56px;
    display: flex; align-items: center; justify-content: center; cursor: pointer;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}
#chat-widget-box {
    position: fixed; bottom: 100px; right: 32px; z-index: 9999;
    width: 350px; max-width: 90vw; background: white; border-radius: 12px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.2); display: none; flex-direction: column;
}
#chat-widget-box.active { display: flex; }
</style>

<div id="chat-widget-btn">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.77 9.77 0 01-4.39-1.02L3 20l1.02-3.61A8.96 8.96 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
    </svg>
</div>
<div id="chat-widget-box">
    <div class="p-3 border-b font-bold bg-blue-600 text-white flex justify-between items-center">
        Hỗ trợ trực tuyến
        <button onclick="document.getElementById('chat-widget-box').classList.remove('active')" class="text-white">&times;</button>
    </div>
    <div id="chat-messages" class="flex-1 p-3 overflow-y-auto" style="height: 300px;">
        <!-- Tin nhắn sẽ được load ở đây -->
    </div>
    <form id="chat-form" class="flex border-t">
        <input type="text" id="chat-input" class="flex-1 px-3 py-2" placeholder="Nhập tin nhắn..." autocomplete="off" required>
        <button class="bg-blue-600 text-white px-4">Gửi</button>
    </form>
</div>
<script>
document.getElementById('chat-widget-btn').onclick = function() {
    document.getElementById('chat-widget-box').classList.toggle('active');
    loadMessages();
};
document.getElementById('chat-form').onsubmit = function(e) {
    e.preventDefault();
    sendMessage();
};
function loadMessages() {
    fetch('/support/messages')
        .then(res => res.json())
        .then(data => {
            let html = '';
            data.forEach(msg => {
                html += `<div class="mb-2 ${msg.is_admin ? 'text-right' : ''}">
                    <span class="inline-block px-3 py-2 rounded ${msg.is_admin ? 'bg-blue-500 text-white' : 'bg-gray-200'}">
                        ${msg.message}
                    </span>
                    <div class="text-xs text-gray-400">${msg.created_at}</div>
                </div>`;
            });
            document.getElementById('chat-messages').innerHTML = html;
            document.getElementById('chat-messages').scrollTop = 99999;
        });
}
function sendMessage() {
    const input = document.getElementById('chat-input');
    fetch('/support/send', {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}','Content-Type':'application/json'},
        body: JSON.stringify({message: input.value})
    }).then(res => res.json())
      .then(() => {
        input.value = '';
        loadMessages();
      });
}
</script>
