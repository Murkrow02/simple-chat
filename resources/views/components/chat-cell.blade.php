
<div class="chat-cell" data-chat-id="{{$id}}"
     data-chat-new="{{isset($isNewChat) && $isNewChat  ? "true" : "false"}}">
    <img class="avatar-{{$id}}" alt="user-avatar">
    <div class="chat-info">
        <div  class="chat-title-{{$id}}">{{$chatName}}</div>
        <div class="chat-desc">{{$secondLine}}</div>
    </div>
    <div class="chat-time">{{$timeStamp}}</div>
</div>