<div class="h-full">

    @if($chats == null)
        <x-chat::alert type="info" message="{{__('simple-chat::chat.no_chats')}}"/>
    @endif

    {{--    <!-- Start new chat -->--}}
    {{--    <button @if($chats == null)style="margin-right: auto" @endif class="btn new-chat-btn"--}}
    {{--            onclick="window.location='/chat/new'+window.location.search;">{{__('simple-chat::chat.new_message')}}</button>--}}


    <!-- Main container -->
    <div class="flex flex-row h-full">

        <!-- Started chats -->
        <div class="w-[20vw]">

            <!-- Header -->
            <div class="flex flex-row items-center justify-between p-3 bg-primary text-white">
                <h2 class="text-xl font-bold">Chats</h2>
                <button class="btn" onclick="newChat()">New chat</button>
            </div>

            @foreach($chats as $chat)
                <x-chat::chat-cell :id="$chat['id']"
                                   :chatName="$chat['title']"
                                   secondLine=""
                                   timeStamp=""
                                   imageUrl=""/>
            @endforeach
        </div>

        <!-- Selected chat -->
        <div class="flex-1">
            <livewire:single-chat chat-id="1"/>
        </div>
    </div>


    <script>
        // Set the chat header title
        setChatHeaderTitle('Chats');


        let startableChatsDiv = document.getElementById('startable-chats');

        function addStartableChat(name) {
            startableChatsDiv.innerHTML += `${name} <br>`;
        }

        function newChat() {
            axios.get("/startablechats")
                .then(startableChats => {

                    startableChats.data.forEach(startableChat => {
                        addStartableChat(startableChat.id);
                    });
                })
        }
    </script>

</div>

