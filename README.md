# simple-chat
A simple Laravel package to add intuitive and simple chat logic to your application

## Installation
1. Install the package via composer:
```bash
composer require murkrow/simple-chat
```
2. Publish the package's config file:
```bash
php artisan vendor:publish --tag=public
```

3. Set your pusher credentials in your `.env` file:
```bash
PUSHER_APP_ID=your-pusher-app-id
PUSHER_APP_KEY=your-pusher-key
PUSHER_APP_SECRET=your-pusher-secret
PUSHER_APP_CLUSTER=mt1
BROADCAST_DRIVER=pusher
```

4. Install the laravel echo npm package:
```bash
npm install --save-dev laravel-echo pusher-js
```

5. Install the laravel pusher composer package:
```bash
composer require pusher/pusher-php-server
```

## Usage
1. Add the `CanChat` trait to your User model:
```php
use Murkrow\Chat\Traits\CanChat;
class User
{
    use CanChat;
}
```

2. Finished!
