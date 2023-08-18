<head>
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

    <!--Include vite generated file in order to use pusher npm-->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .chat-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .chat-header {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .chat-messages {
            padding: 20px;
            overflow-y: auto;
            max-height: 300px;
        }

        .message {
            margin-bottom: 15px;
        }

        .message-text {
            background-color: #e0e0e0;
            padding: 10px;
            border-radius: 10px;
            display: inline-block;
            max-width: 70%;
        }

        .user-message {
            align-self: flex-end;
            text-align: right;
        }

        .other-message {
            align-self: flex-start;
            text-align: left;
        }

        .message-input {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-top: 1px solid #ccc;
        }

        .input-field {
            flex: 1;
            padding: 8px;
            border: none;
            border-radius: 5px;
        }

        .send-button {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            padding: 8px 15px;
            cursor: pointer;
        }

        /* ... (existing styles) ... */

        .chats-list {
            max-width: 300px;
            margin: 20px auto;
        }

        .chat-cell {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ccc;
            cursor: pointer;
        }

        .chat-cell img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 10px;
        }

        .chat-info {
            flex: 1;
        }

        .chat-title {
            font-weight: bold;
        }

        .chat-desc {
            color: #777;
        }

        .chat-time {
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>

@livewireScripts
<script src="/js/simple-chat/simple-chat.js"></script>
<script src="/js/simple-chat/avatar.js"></script>
<script src="/js/simple-chat/axios.js"></script>


<!-- Component rendered here -->
{{ $slot }}

</body>

