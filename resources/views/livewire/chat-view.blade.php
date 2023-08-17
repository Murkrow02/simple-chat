
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


            const channel = pusher.subscribe('chat');
            channel.bind('NewChatMessage', function(data) {
                // Handle the received chat message data here
                console.log('New chat message:', data.message);
                // You can update your chat UI with the new message
            });
        })

        function sendNewMessage() {

            axios.post('/newmessage', {
                chat_id: 1,
                body: userMessageInput.value
            }, defaultHeaders)
                .then(function (response) {
                    userMessageInput.value = '';
                    addMessage(response.data.body, true);
                    scrollToBottom();
                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    </script>
</div>

