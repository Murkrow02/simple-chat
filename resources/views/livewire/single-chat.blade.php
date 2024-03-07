
<div class="flex-1 h-full flex flex-col p-5">

    <!-- No messages -->
    <div id="no-messages-alert">
        <x-chat::alert type="info" :message="__('simple-chat::chat.no_messages')"/>
    </div>

    <!-- Chat messages -->
    <div class="flex-1 flex flex-col" id="chat-messages">

    </div>

    <!-- Write new message -->
    <div class="w-full flex flex-row">
        <input wire:model.defer="newMessage" type="text" class="flex-1 rounded-l-lg" id="user-input"
               placeholder="{{__('simple-chat::chat.write_message')}}">
        <button onclick="sendNewMessage()" class="bg-primary px-5 rounded-r-lg" id="send-button">{{__('simple-chat::chat.send')}}</button>
    </div>

    <style>
        .user-message {
            background-color: var(--chat-primary);
            align-self: flex-end;
        }

        .other-message {
            background-color: #e0e0e0;
            align-self: flex-start;
        }
    </style>

    @script
    <script>

        // Set the chat header title
       // setChatHeaderTitle('{{$chatTitle}}');

        let userMessageInput = document.getElementById('user-input');
        let chatMessages = document.getElementById('chat-messages');

        function scrollToBottom() {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Append new message to chat messages
        function addMessage(message, sentByLoggedUser) {
            document.getElementById('no-messages-alert').style.display = 'none';
            let msgClass = sentByLoggedUser ? 'user-message' : 'other-message';
            chatMessages.innerHTML +=
                `<div class="my-1 px-4 py-2 rounded-xl text-white ${msgClass}">
                    <div class="">
                        ${message}
                    </div>
                </div>`;
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

            // Get the send button
            let sendButton = document.getElementById('send-button');

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
    @endscript
</div>

