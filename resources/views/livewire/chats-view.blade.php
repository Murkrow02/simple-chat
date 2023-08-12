<div>


    <div class="chats-list">

        <x-chat::chat-cell />



    </div>


    <script>
        const chatCells = document.querySelectorAll('.chat-cell');

        chatCells.forEach(chatCell => {
            chatCell.addEventListener('click', () => {
                const chatId = chatCell.getAttribute('data-chat-id');
                window.location.href = `/chats/${chatId}`;
            });
        });
    </script>

</div>