<div class="chats-list">

    <a href="/chat/new">Nuova chat</a>

    @foreach($chats as $chat)
        <x-chat::chat-cell :id="$chat['id']"
                           :chatName="$chat['title']"
                           secondLine=""
                           timeStamp=""
                           imageUrl=""/>
    @endforeach


    <script>

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

