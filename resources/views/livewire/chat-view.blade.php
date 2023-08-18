
<div class="chat-container">

    <!-- Chat header -->
    <div class="chat-header">
        <h2>{{$chatTitle}}</h2>
    </div>

    <!-- Chat messages -->
    <div class="chat-messages" id="chat-messages">

    </div>

    <!-- Chat input -->
    <div class="message-input">
        <input wire:model.defer="newMessage" type="text" class="input-field" id="user-input"
               placeholder="Type your message...">
        <button onclick="sendNewMessage()" class="send-button" id="send-button">Send</button>
    </div>

    <script>
        const sendButton = document.getElementById('send-button');
        const userMessageInput = document.getElementById('user-input');
        const chatMessages = document.getElementById('chat-messages');

        function scrollToBottom() {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Append new message to chat messages
        function addMessage(message, sentByLoggedUser) {
            let msgClass = sentByLoggedUser ? 'user-message' : 'other-message';
            chatMessages.innerHTML += `<div class="message ${msgClass}"><div class="message-text">${message}</div></div>`;
        }

        // Event loaded when the page is loaded
        document.addEventListener('livewire:initialized', () => {

            // Download all messages from the server and add them to the chat
            let messages = @js($messages);
            messages.forEach(message => {
                addMessage(message.body, message.user_id === {{$loggedUser->id}});
            });

            scrollToBottom();

            // Listen for new messages
            Echo.private('chat.{{$chat['id']}}').listen('.new-message', function(data) {
                addMessage(data.body, false);
            });
        })

        function sendNewMessage() {

            axios.post('/chat/newmessage', {
                chat_id: {{$chat['id']}},
                body: userMessageInput.value
            }, defaultHeaders)
                .then(function (response) {
                    userMessageInput.value = '';
                    addMessage(response.data.body, true);
                    scrollToBottom();
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    </script>
</div>

