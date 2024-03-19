<div class="flex-1 h-full flex flex-col">

    <!-- Chat header -->
    <div class="p-3 bg-secondary text-white text-center flex flex-row justify-between lg:justify-center">
        <button onclick="showSlideOver()" class="lg:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="white" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14"/>
            </svg>
        </button>
        <h2 class="text-xl font-bold">{{__('simple-chat::chat.chat')}}</h2>
        <p class="lg:hidden"></p>
    </div>

    <!-- Loading -->
    <div id="chat-loading-spinner">
        <x-simple-chat::loading-spinner/>
    </div>

    <!-- Chat messages -->
    <div class="flex-1 flex flex-col overflow-y-auto px-4 pb-3" id="chat-messages">

    </div>

    <!-- Write new message -->
    <div class="w-full flex flex-row border-t-2 border-primary">
        <textarea wire:model.defer="newMessage"
                  type="text"
                  class="flex-1 border-none h-[50px] p-3 resize-none"
                  id="user-input"
                  placeholder="{{__('simple-chat::chat.write_message')}}">
        </textarea>
        <button onclick="sendNewMessage()" class="bg-primary px-5"
                id="send-button">{{__('simple-chat::chat.send')}}</button>
    </div>

</div>

