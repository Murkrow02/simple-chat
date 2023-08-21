<div class="chats-list">



    <button onclick="window.location='/chat/new'+window.location.search;">Nuova chat</button>

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

