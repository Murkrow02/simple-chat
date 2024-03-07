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

            <!-- Chats -->
            @foreach($chats as $chat)
                <div wire:click="switchChatTo({{$chat['id']}})">
                    <x-chat::chat-cell :id="$chat['id']"
                                       :chatName="$chat['title']"
                                       secondLine=""
                                       selected="{{$chat['id'] == $selectedChatId}}"
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

        // Applies the avatar function and the proper action to given class cell
        // Not using id as it could happen that the same person is in two categories at the same time (and so two elements will have same id)
        function applyAvatarToCell(userId)
        {
            //If in page there is an element with class chat-cell, then cycle through each element
            document.querySelectorAll(`[data-chat-id="${userId}"]`).forEach((cell) => {

                //Get data-id from cell
                let id = cell.getAttribute('data-chat-id');

                //Set cell avatar for each element with class avatar-<id> (need to use class instead of id because same id could be used in multiple cells)
                document.querySelectorAll('.avatar-' + id).forEach((avatar) => {
                    new Avatar(avatar, {
                        'useGravatar': false,
                        'initials': getInitials(document.querySelector('.chat-title-' + id).innerText),
                    });
                });

            });
        }
    </script>

</div>

