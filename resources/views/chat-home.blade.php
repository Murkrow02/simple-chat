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
            <div id="slide-over"
                 class="w-full lg:w-1/4 h-full flex flex-col absolute lg:relative lg:translate-x-0  ease-out duration-300 bg-white">

                <!-- Header -->
                <div class="flex flex-row items-center justify-between p-3 bg-primary text-white">
                    <h2 class="text-xl font-bold">Chats</h2>
                    <button onclick="showNewChatModal()" class="text-white">New chat</button>
                </div>

                <!-- Chats -->
                <div id="started-chats" class="border-r-2 h-full overflow-y-auto border-primary">
                </div>

            </div>

            <!-- RIGHT Selected chat -->
            <div class="flex-1" id="opened-chat" hidden>
                <x-simple-chat::chat-view/>
            </div>

            <!-- New chat modal -->
            <div id="new-chat-modal"
                 class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex justify-center items-center">
                <x-simple-chat::new-chat-modal/>
            </div>


        </div>
    </div>


    <script>

        // Get elements
        let openedChat = document.getElementById('opened-chat');
        let slideOver = document.getElementById('slide-over');
        let newChatModal = document.getElementById('new-chat-modal');


        // Variables
        let isLeftContainerOpen = true;

        // Open in right container the chat with messages
        function openChat(selectedChatCell) {

            // Show opened chat
            openedChat.hidden = false;

            // Hide slide over
            hideSlideOver();

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


        // Show left slide over with started chats
        function showSlideOver() {
            slideOver.classList.remove('-translate-x-full');
            isLeftContainerOpen = true;
        }

        // Hide left slide over with started chats
        function hideSlideOver() {
            slideOver.classList.add('-translate-x-full');
            isLeftContainerOpen = false;
        }

        function showNewChatModal() {
            newChatModal.style.display = "block";
        }


    </script>

@endsection

