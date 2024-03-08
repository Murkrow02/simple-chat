@extends('simple-chat::layouts.app')
@section('title', 'Welcome')
@section('content')

    <div class="h-full">

        {{--    @if($chats == null)--}}
        {{--        <x-chat::alert type="info" message="{{__('simple-chat::chat.no_chats')}}"/>--}}
        {{--    @endif--}}

        {{--    <!-- Start new chat -->--}}
        {{--    <button @if($chats == null)style="margin-right: auto" @endif class="btn new-chat-btn"--}}
        {{--            onclick="window.location='/chat/new'+window.location.search;">{{__('simple-chat::chat.new_message')}}</button>--}}



        <!-- Main container -->
        <div class="flex flex-row h-full">

            <!-- LEFT Started chats -->
            <div class="w-1/4 h-full flex flex-col absolute md:relative md:translate-x-0 -translate-x-full ease-out duration-300">

                <!-- Header -->
                <div class="flex flex-row items-center justify-between p-3 bg-primary text-white">
                    <h2 class="text-xl font-bold">Chats</h2>
                    <a href="/chat/new" class="text-white">New chat</a>
                </div>

                <!-- Chats -->
                <div id="started-chats" class="border-r-2 h-full overflow-y-auto border-primary">
                </div>

            </div>

            <!-- RIGHT Selected chat -->
            <div class="flex-1" id="opened-chat" hidden>
                <x-simple-chat::chat-view/>
            </div>

        </div>


        <script>

            let openedChat = document.getElementById('opened-chat');
            function openChat(selectedChatCell) {

                // Show opened chat
                openedChat.hidden = false;

                // Call function on chat view in order to detect new chat
                currentChatChanged(selectedChatCell.getAttribute('data-chat-id'));

                // Remove any previous cell with active background
                let activeCell = document.querySelector('.active-chat-cell');
                if (activeCell != null)
                    activeCell.classList.remove('active-chat-cell');

                // Add active background to selected cell
                selectedChatCell.classList.add('active-chat-cell');
            }


            // Download started chats
            let startedChatsDiv = document.getElementById('started-chats');
            document.addEventListener("DOMContentLoaded", function () {
                axios.get('/chat/chats')
                    .then(response => {
                        startedChatsDiv.innerHTML += response.data;
                    });
            });


        </script>

    </div>
@endsection

