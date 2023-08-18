<div class="chats-list">

    @foreach($startableChats as $startableChat)
        <x-chat::chat-cell :id="$startableChat->id"
                           :chatName="$startableChat->first_name"
                           isNewChat="true"
                           secondLine=""
                           timeStamp=""
                           imageUrl=""/>
    @endforeach

</div>