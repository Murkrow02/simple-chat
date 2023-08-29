<div class="chats-list">

    @if($chats == null)
            <p style="text-align: center; font-size: 30px">{{__('simple-chat::chat.no_chats')}}</p>
    @endif

    <!-- Start new chat -->
    <button @if($chats == null)style="margin-right: auto" @endif class="btn new-chat-btn"
            onclick="window.location='/chat/new'+window.location.search;">{{__('simple-chat::chat.new_message')}}</button>

    <!-- Started chats -->
    @foreach($chats as $chat)
        <x-chat::chat-cell :id="$chat['id']"
                           :chatName="$chat['title']"
                           secondLine=""
                           timeStamp=""
                           imageUrl=""/>
    @endforeach


    <script>
        // Set the chat header title
        setChatHeaderTitle('Chats');


        let startableChatsDiv = document.getElementById('startable-chats');
        function addStartableChat(name){
            startableChatsDiv.innerHTML += `${name} <br>`;
        }

        function newChat(){
            axios.get("/startablechats")
                .then(startableChats => {

                    startableChats.data.forEach(startableChat => {
                        addStartableChat(startableChat.id);
                    });
                })
        }
    </script>

</div>

