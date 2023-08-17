
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
        })

        function sendNewMessage(){


            const formData = new FormData();
            formData.append('chat_id', '1');
            formData.append('body', userMessageInput.value);

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('/newmessage', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json', // Optional: Specify the response format
                    // Add any other headers you need
                }
            })
                .then(response => response.json())
                .then(data => {
                    addMessage(userMessageInput.value, true);
                    scrollToBottom();
                    userMessageInput.value = '';
                })
                .catch(error => {
                    console.error('Error updating user details:', error);
                });
        }




    </script>
</div>

