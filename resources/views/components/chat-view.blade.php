<div class="flex-1 h-full flex flex-col">

    <!-- Chat messages -->
    <div class="flex-1 flex flex-col overflow-y-auto px-4" id="chat-messages">

    </div>

    <!-- Write new message -->
    <div class="w-full flex flex-row">
        <input wire:model.defer="newMessage" type="text" class="flex-1 border-none" id="user-input"
               placeholder="{{__('simple-chat::chat.write_message')}}">
        <button onclick="sendNewMessage()" class="bg-primary px-5"
                id="send-button">{{__('simple-chat::chat.send')}}</button>
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

    <script>

        // Get components
        let userMessageInput = document.getElementById('user-input');
        let chatMessages = document.getElementById('chat-messages');
        let sendButton = document.getElementById('send-button');

        let currentChatId = null;
        function currentChatChanged(newChatId) {

            // Clear messages from messages div
            chatMessages.innerHTML = '';

            // Set current chat id
            currentChatId = newChatId;

            // Download messages from selected chat
            axios.get('/chat/messages/' + newChatId)
                .then(function (response) {
                    chatMessages.innerHTML = '';
                    response.data.forEach(message => {
                        addMessage(message.body, message.user_id === {{ auth()->user()->id }} );
                    });
                    scrollToBottom();
                })
                .catch(function (error) {
                    console.log(error);
                });


            scrollToBottom();
        }

        function sendNewMessage() {

            //Disable send button
            sendButton.disabled = true;

            axios.post('/chat/newmessage', {
                chat_id: currentChatId,
                body: userMessageInput.value
            })
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
            })
        }

        // Append new message to chat messages
        function addMessage(message, sentByLoggedUser) {
            //document.getElementById('no-messages-alert').style.display = 'none';
            let msgClass = sentByLoggedUser ? 'user-message' : 'other-message';
            chatMessages.innerHTML +=
                `<div class="my-1 px-4 py-2 rounded-xl text-white ${msgClass}">
                    <div class="">
                        ${message}
                    </div>
                </div>`;
        }

        function scrollToBottom() {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }



        {{--// Event loaded when the page is loaded--}}
        {{--document.addEventListener('livewire:initialized', () => {--}}


        {{--    // Download all messages from the server and add them to the chat--}}
        {{--    let messages = @js($messages);--}}
        {{--    messages.forEach(message => {--}}
        {{--        addMessage(message.body, message.user_id === {{$loggedUser->id}});--}}
        {{--    });--}}

        {{--    --}}

        {{--    // Listen for new messages--}}
        {{--    Echo.private('chat.{{$chat['id']}}').listen('.new-message', function(data) {--}}
        {{--        addMessage(data.body, false);--}}
        {{--    });--}}
        {{--})--}}



        {{--}--}}
    </script>
</div>

