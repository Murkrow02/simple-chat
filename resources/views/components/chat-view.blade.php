<div class="flex-1 h-full flex flex-col">

    <!-- Chat header -->
    <div class="p-3 bg-secondary text-white text-center flex flex-row justify-between lg:justify-center">
        <button onclick="showSlideOver()" class="lg:hidden">Left</button>
        <h2 class="text-xl font-bold">{{__('simple-chat::chat.chat')}}</h2>
        <p class="lg:hidden"></p>
    </div>

    <!-- Chat messages -->
    <div class="flex-1 flex flex-col overflow-y-auto px-4 pb-3" id="chat-messages">

    </div>

    <!-- Write new message -->
    <div class="w-full flex flex-row border-t-2 border-primary">
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
                    chatMessages.innerHTML = response.data;
                    scrollToBottom();
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        function sendNewMessage() {

            //Disable send button and text input
            sendButton.disabled = true;
            userMessageInput.disabled = true;

            axios.post('/chat/newmessage', {
                chat_id: currentChatId,
                body: userMessageInput.value
            })
                .then(function (response) {
                    userMessageInput.value = '';
                    chatMessages.innerHTML += response.data;
                    scrollToBottom();
                })
                .catch(function (error) {
                    console.log(error);
                }).finally(function () {


                // Enable send button and text input
                sendButton.disabled = false;
                userMessageInput.disabled = false;
            })
        }

        function scrollToBottom() {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        {{--// Listen for new messages--}}
        {{--Echo.private('chat.{{$chat['id']}}').listen('.new-message', function(data) {--}}
        {{--    //addMessage(data.body, false); RENDER MESSAGE BUBBLE FROM SERVER--}}
        {{--});--}}
    </script>
</div>

