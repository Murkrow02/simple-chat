<?php
$alreadyAddedIds = [];
?>

<div class="chats-list">
    @foreach ($eagerCategories as $title => $startableChats)

        <h3>{{$title}}</h3>

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

</div>