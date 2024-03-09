<!DOCTYPE html>
<html lang="it">
<head>
    <title>Chat</title>
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
            --chat-secondary: {{config('simple-chat.secondary_color')}};
            --chat-active-cell: {{config('simple-chat.active_chat_cell_color')}};
        }
    </style>

    <!-- REMOVE -->
    @if(env('APP_ENV') === 'local')
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <!-- Assets -->
    <link href="{{ asset('simple-chat/css/app.css') }}" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-[100vh]">
@yield('content')
</body>

<script src="{{ asset('simple-chat/js/app.js') }}"></script>

</html>


