
<div class="chat-container">

    <!-- No messages -->
    <div id="no-messages-alert" style="padding: 15px">
        <x-chat::alert type="info" :message="__('simple-chat::chat.no_messages')"/>
    </div>

    <!-- Chat messages -->
    <div class="chat-messages" id="chat-messages">

    </div>

    <!-- Chat input -->
    <div class="message-input">
        <input wire:model.defer="newMessage" type="text" class="input-field" id="user-input"
               placeholder="{{__('simple-chat::chat.write_message')}}">
        <button onclick="sendNewMessage()" class="btn send-button" id="send-button">{{__('simple-chat::chat.send')}}</button>
    </div>

    <script>

        // Set the chat header title
        setChatHeaderTitle('{{$chatTitle}}');

        const sendButton = document.getElementById('send-button');
        const userMessageInput = document.getElementById('user-input');
        const chatMessages = document.getElementById('chat-messages');

        function scrollToBottom() {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Append new message to chat messages
        function addMessage(message, sentByLoggedUser) {
            document.getElementById('no-messages-alert').style.display = 'none';
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

            //Disable send button
            sendButton.disabled = true;

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
                }).finally(function () {
                // always executed
                sendButton.disabled = false;
            });

        }
    </script>
</div>

