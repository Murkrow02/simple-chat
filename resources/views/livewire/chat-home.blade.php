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
        <div class="w-1/4">

            <!-- Header -->
            <div class="flex flex-row items-center justify-between p-3 bg-primary text-white">
                <h2 class="text-xl font-bold">Chats</h2>
                <a href="/chat/new" class="text-white">New chat</a>
            </div>

            <!-- Chats -->
            @foreach($chats as $chat)
                <div wire:click="switchChatTo({{$chat['id']}})"
                     onclick="setActiveChatCellBackground(this)"
                     wire:ignore
                     wire:key="chat-{{$chat['id']}}">
                    <x-chat::chat-cell :id="$chat['id']"
                                       :chatName="$chat['title']"
                                       secondLine=""
                                       timeStamp=""
                                       imageUrl=""/>
                </div>
            @endforeach
        </div>

        <!-- Selected chat -->
        @if($selectedChatId != null)
            <div class="flex-1">
                <livewire:single-chat chat-id="1"/>
            </div>
        @endif
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
        function setActiveChatCellBackground(cell)
        {
            // Remove any previous cell with active background
            let activeCell = document.querySelector('.active-chat-cell');
            if(activeCell != null)
                activeCell.classList.remove('active-chat-cell');
            cell.classList.add('active-chat-cell');
        }


    </script>

</div>

