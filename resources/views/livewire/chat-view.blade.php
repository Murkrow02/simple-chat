<div class="chat-container">

    <!-- Chat header -->
    <div class="chat-header">
        <h2>{{$chatTitle}}</h2>
    </div>

    <!-- Chat messages -->
    <div class="chat-messages" id="chat-messages">

        @foreach ($messages as $message)
            <div class="message {{ $message['user_id'] == $loggedUser->id ? "user-message" : "other-message" }}">
                <div class="message-text">{{ $message['body'] }}</div>
            </div>
        @endforeach
    </div>

    <!-- Chat input -->
    <div class="message-input">
        <input wire:model.defer="newMessage" type="text" class="input-field" id="user-input" placeholder="Type your message...">
        <button wire:click="sendMessage" class="send-button" id="send-button">Send</button>
    </div>


    <script>
        const sendButton = document.getElementById('send-button');
        const userMessageInput = document.getElementById('user-input');
        const chatMessages = document.getElementById('chat-messages');

        function scrollToBottom() {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        document.addEventListener('livewire:load', function () {
            scrollToBottom();

            Livewire.on('messageSent', () => {
                scrollToBottom();
            });
        })


    </script>
</div>

