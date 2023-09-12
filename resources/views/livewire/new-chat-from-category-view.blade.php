<div class="chats-list">

{{--    --}}{{-- Error --}}
{{--    @if($errorMessage)--}}
{{--        <x-chat::alert type="danger" :message="$errorMessage"/>--}}
{{--    @endif--}}


{{--    --}}{{-- Category title --}}
{{--    <h3>{{$title}}</h3>--}}

{{--    --}}{{-- No data for this category --}}
{{--    @if(count($startableChats) == 0)--}}
{{--        <p>{{__('simple-chat::chat.no_startable_chats')}}</p>--}}
{{--    @endif--}}

{{--    --}}{{-- Render chats --}}
{{--    @foreach ($startableChats as $startableChat)--}}

{{--        <x-chat::chat-cell :id="$startableChat->id"--}}
{{--                           :chatName="$startableChat->name"--}}
{{--                           isNewChat="true"--}}
{{--                           secondLine=""--}}
{{--                           timeStamp=""--}}
{{--                           imageUrl=""/>--}}
{{--    @endforeach--}}


    <script>
        // Set the chat header title
        setChatHeaderTitle('{{__('simple-chat::chat.new_chat')}}');
    </script>

</div>