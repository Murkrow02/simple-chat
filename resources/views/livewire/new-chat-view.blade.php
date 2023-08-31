<?php
$alreadyAddedIds = [];
?>

<div class="chats-list">

    @if($errorMessage)
        <x-chat::alert type="danger" :message="$errorMessage"/>
    @endif

    @foreach ($eagerCategories as $title => $startableChats)

        <h3>{{$title}}</h3>

        @if(count($startableChats) == 0)
            <p>{{__('simple-chat::chat.no_startable_chats')}}</p>
        @endif
        @foreach ($startableChats as $startableChat)

                <?php
                // Prevent duplicate chats
                if (in_array($startableChat->id, $alreadyAddedIds)) {
                    continue;
                }
                $alreadyAddedIds[] = $startableChat->id;
                ?>


            <x-chat::chat-cell :id="$startableChat->id"
                               :chatName="$startableChat->first_name . ' ' . $startableChat->last_name"
                               isNewChat="true"
                               secondLine=""
                               timeStamp=""
                               imageUrl=""/>
        @endforeach
    @endforeach


    <script>
        // Set the chat header title
        setChatHeaderTitle('{{__('simple-chat::chat.new_chat')}}');
    </script>

</div>