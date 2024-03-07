<div data-chat-id="{{$id}}" class="flex items-center p-4 border-b border-gray-300 cursor-pointer"
     data-chat-new="{{isset($isNewChat) && $isNewChat  ? "true" : "false"}}">
    <img class="avatar-{{$id}} w-[50px] h-[50px] object-cover rounded-full mr-5" alt="user-avatar"/>
    <div class="flex-1">
        <div class="chat-title-{{$id}} text-bold">{{$chatName}}</div>
        <div class="chat-desc">{{$secondLine}}</div>
    </div>
    <div class="chat-time">{{$timeStamp}}</div>

    <script>
        applyAvatarAndActionToUserId('{{$id}}');
    </script>
</div>