
<div class="chat-cell" id="chat-cell-{{$id}}" data-chat-id="{{$id}}"
     data-chat-new="{{isset($isNewChat) && $isNewChat  ? "true" : "false"}}">
    <img id="avatar-{{$id}}" alt="user-avatar">
    <div class="chat-info">
        <div class="chat-title" id="chat-title-{{$id}}">{{$chatName}}</div>
        <div class="chat-desc">{{$secondLine}}</div>
    </div>
    <div class="chat-time">{{$timeStamp}}</div>
</div>