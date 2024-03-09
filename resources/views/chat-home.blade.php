@extends('simple-chat::layouts.app')
@section('content')

    <div class="h-full">

        <!-- Main container -->
        <div class="flex flex-row h-full">

            <!-- LEFT Started chats -->
            <div id="slide-over"
                 class="w-full lg:w-[450px] h-full flex flex-col absolute lg:relative lg:translate-x-0  ease-out duration-300 bg-white">


                <!-- Header -->
                <div class="flex flex-row items-center justify-between p-3 bg-primary text-white h-[90px]">

                    <!-- Go back button and title -->
                    <div class="flex flex-row">
                        <h2 class="text-3xl font-bold">Chats</h2>
                    </div>

                    <!-- New chat button and close button -->
                    <div>
                        <button id="new-chat-btn" onclick="showNewChatSlideover()" class="text-white">
                           New
                        </button>

                        <button id="close-new-chat-btn" onclick="hideNewChatSlideover()" class="text-white hidden">
                            Close
                        </button>

                    </div>

                </div>

                <!-- Loading -->
                <div id="loading-spinner">
                    <x-simple-chat::loading-spinner/>
                </div>

                <!-- Content -->
                <div id="slideover-content" class="border-r-2 border-primary h-full overflow-x-auto pr-2">

                    <!-- Already started chats slideover content -->
                    <div id="started-chats-slideover-content">
                    </div>

                    <!-- New chat slideover content -->
                    <div id="new-chat-slideover-content">

                    </div>
                </div>


            </div>

            <!-- RIGHT Selected chat -->
            <div class="flex-1" id="opened-chat" hidden>
                <x-simple-chat::chat-view/>
            </div>

        </div>
    </div>

@endsection

