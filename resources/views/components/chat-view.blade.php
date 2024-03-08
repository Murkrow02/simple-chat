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

    <script>

        // Get components
        let userMessageInput    =  document.getElementById('user-input');
        let chatMessages        =  document.getElementById('chat-messages');
        let sendButton          =  document.getElementById('send-button');

        let currentChatId = null;
        function currentChatChanged(newChatId) {

            // Clear messages from messages div
            chatMessages.innerHTML = '';

            // Set current chat id
            currentChatId = newChatId;

            // Download messages from selected chat
            axios.get('/chat/messages/' + newChatId)
                .then(function (response) {

                    scrollToBottom();
                })
                .catch(function (error) {
                    console.log(error);
                });
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

