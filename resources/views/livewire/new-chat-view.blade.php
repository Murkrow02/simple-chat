

<div class="chats-list">

    {{-- Error --}}
    @if($errorMessage)
        <x-chat::alert type="danger" :message="$errorMessage"/>
    @endif

    {{-- Render collapsed categories --}}
    @foreach ($collapsedCategories as $title => $categoryIndex)
        <a style="color: blue" href="newFromCategory/{{$categoryIndex}}">{{$title}}</a>
    @endforeach

    {{-- Render listed categories --}}
    @foreach ($listedCategories as $title => $startableChats)

        {{-- Category title --}}
        <h3>{{$title}}</h3>

        {{-- No data for this category --}}
        @if(count($startableChats) == 0)
            <p>{{__('simple-chat::chat.no_startable_chats')}}</p>
        @endif

        {{-- Render chats --}}
        @foreach ($startableChats as $startableChat)

            <x-chat::chat-cell :id="$startableChat->id"
                               :chatName="$startableChat->name"
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

<?php
//$alreadyAddedIds = [];
//                <?php
//                // Prevent duplicate chats
//                if (in_array($startableChat->id, $alreadyAddedIds)) {
//                    continue;
//                }
//                $alreadyAddedIds[] = $startableChat->id;
//
?>
