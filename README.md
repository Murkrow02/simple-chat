# simple-chat
A simple Laravel package to add intuitive and simple chat logic to your application

## Installation
1 - Install the package via composer:
```bash
composer require murkrow/simple-chat
```
2 - Publish the package files:
```bash
php artisan vendor:publish --provider="Murkrow\Chat\ChatServiceProvider" --force
```

3 - Set your pusher credentials in your `.env` file:
```bash
PUSHER_APP_ID=your-pusher-app-id
PUSHER_APP_KEY=your-pusher-key
PUSHER_APP_SECRET=your-pusher-secret
PUSHER_APP_CLUSTER=mt1
BROADCAST_DRIVER=pusher
```

4 - Include also the following variables in your `.env` file:
```bash
VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

5 - Install the laravel echo and pusher npm packages:
```bash
npm install --save-dev laravel-echo pusher-js
```

6 - Install the laravel pusher composer package:
```bash
composer require pusher/pusher-php-server
```

7 - Add the following code to your `resources/js/bootstrap.js` file:
```js
import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
    wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
    wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});
```

#### NOTE:
> Make sure to have uncommented App\Providers\BroadcastServiceProvider::class in your config/app.php file

## Usage
1 - Add the `CanChat` trait to your User model:
```php
use Murkrow\Chat\Traits\CanChat;
class User
{
    use CanChat;
}
```

## How it works

### Livewire
The major part of the UI is made with Livewire components and everything is handled by the corresponding php Livewire component class.
The only exception is the message bubbles list, this works with standard axios requests and an Http controller.
This is done to prevent excessive requests to the server and to keep the chat as smooth as possible.

### Events
When a new message is sent, the package will broadcast a `NewMessage` event to the channel `chat.{chat_id}`.
