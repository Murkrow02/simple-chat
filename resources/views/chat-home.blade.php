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
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                            </svg>

                        </button>

                        <button id="close-new-chat-btn" onclick="hideNewChatSlideover()" class="text-white hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                            </svg>
                        </button>

                    </div>

                </div>

                <!-- Loading -->
                <div id="chats-loading-spinner">
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

