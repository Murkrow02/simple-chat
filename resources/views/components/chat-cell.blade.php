<div class="chat-cell" id="chat-cell-{{$id}}">
    <img id="avatar-{{$id}}" alt="user-avatar">
    <div class="chat-info">
        <div class="chat-title">{{$chatName}}</div>
        <div class="chat-desc">{{$secondLine}}</div>
    </div>
    <div class="chat-time">{{$timeStamp}}</div>

    <script>
        //Set cell avatar
        new Avatar(document.getElementById('avatar-{{$id}}'), {
            'useGravatar': false,
            'primarySource': '{{$imageUrl}}',
            'initials': getInitials('{{$chatName}}')
        });

        //Add on-click to open chat
        document.getElementById('chat-cell-{{$id}}').addEventListener('click', () => {
                let url = '{{isset($isNewChat) && $isNewChat  ? "newchat" : "chats"}}';
                window.location.href = `/${url}/{{$id}}`;
            });
    </script>
</div>