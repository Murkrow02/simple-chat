<!DOCTYPE html>
<html>
<head>
    <title>Chat</title>

    @livewireStyles

    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        let defaultHeaders = {
            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        };
    </script>

    <style>
        :root {
            --chat-primary: {{config('simple-chat.primary_color')}};
            --chat-active-cell: {{config('simple-chat.active_chat_cell_color')}};
        }
    </style>

    @if(env('APP_ENV') === 'local')
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <!--Include vite generated file in order to use pusher npm-->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ asset('simple-chat/css/app.css') }}" rel="stylesheet"/>
    <script src="{{ asset('simple-chat/js/app.js') }}"></script>

    @livewireScripts

</head>

<body class="h-[100vh]">

{{--<!-- Header -->--}}
{{--<div class="chat-header">--}}

{{--    @if(!str_ends_with(Request::url(), '/chat'))--}}
{{--        <button onclick="window.history.back()" class="back-button">--}}
{{--            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="28"--}}
{{--                 height="28">--}}
{{--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>--}}
{{--            </svg>--}}
{{--        </button>--}}
{{--    @endif--}}


{{--    <h2 id="chat-header-title"></h2>--}}
{{--</div>--}}

<!-- Component rendered here -->
{{ $slot }}


</body>
</html>


