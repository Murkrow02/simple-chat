<div class="chat-cell" data-chat-id="{{$id}}">
    <img id="avatar-{{$id}}">
    <div class="chat-info">
        <div class="chat-title">{{$chatName}}</div>
        <div class="chat-desc">{{$secondLine}}</div>
    </div>
    <div class="chat-time">{{$timeStamp}}</div>

    <script>
        function getInitials(name) {
            const words = name.trim().split(' ');
            let initials = '';

            for (let i = 0; i < words.length && initials.length < 2; i++) {
                initials += words[i][0].toUpperCase();
            }

            return initials;
        }
        const initials = getInitials('{{$chatName}}');

        new Avatar(document.getElementById('avatar-{{$id}}'), {
            'useGravatar': false,
            'primarySource': '{{$imageUrl}}',
            'initials': initials
        });
    </script>
</div>