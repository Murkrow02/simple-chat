<div class="my-1 px-4 py-2 rounded-xl text-white
    {{auth()->id() === $message->user_id ? 'user-message' : 'other-message'}}">
    <div class="">
        ${message->body}
    </div>
</div>