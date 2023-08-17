<div>


    <div class="chats-list">

        @foreach($chats as $chat)
            <x-chat::chat-cell :id="$chat['id']"
                               :chatName="$chat['title']"
                               secondLine="TEST"
                               timeStamp=""
                               imageUrl=""/>
        @endforeach
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