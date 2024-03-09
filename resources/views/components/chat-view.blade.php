<div class="flex-1 h-full flex flex-col">

    <!-- Chat header -->
    <div class="p-3 bg-secondary text-white text-center flex flex-row justify-between lg:justify-center">
        <button onclick="showSlideOver()" class="lg:hidden">Left</button>
        <h2 class="text-xl font-bold">{{__('simple-chat::chat.chat')}}</h2>
        <p class="lg:hidden"></p>
    </div>

    <!-- Chat messages -->
    <div class="flex-1 flex flex-col overflow-y-auto px-4 pb-3" id="chat-messages">

    </div>

    <!-- Write new message -->
    <div class="w-full flex flex-row border-t-2 border-primary">
        <input wire:model.defer="newMessage" type="text" class="flex-1 border-none" id="user-input"
               placeholder="{{__('simple-chat::chat.write_message')}}">
        <button onclick="sendNewMessage()" class="bg-primary px-5"
                id="send-button">{{__('simple-chat::chat.send')}}</button>
    </div>

</div>

