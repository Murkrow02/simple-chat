<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;
use Murkrow\Chat\Http\Controllers\ChatController;
use Murkrow\Chat\Http\Livewire\ChatHome;
use Murkrow\Chat\Http\Livewire\SingleChat;
use Murkrow\Chat\Http\Livewire\NewChatFromCategoryView;
use Murkrow\Chat\Http\Livewire\StartableChatsList;
use Murkrow\Chat\Http\Middleware\AuthTokenFromUrl;
use Murkrow\Chat\Utils\Utils;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::prefix('chat')->middleware('web')->group(function () {


    //Route used by mobile clients to be automatically logged in when using a web view
    Route::get('tokenlogin/{token}', function ($token) {

        //Get token from url
        $tokenMatch = PersonalAccessToken::findToken(base64_decode($token));
        if (!$tokenMatch || ($tokenMatch->expires_at && $tokenMatch->expires_at < now())) {
            abort(401);
        }

        //Token is valid, get user id
        Auth::loginUsingId($tokenMatch->tokenable->id);

        //Redirect to chat view and keep query parameters in url
        $queryParams = request()->query();
        return redirect('chat?' . http_build_query($queryParams));
    });


    //Authenticated routes
    Route::middleware('auth')->group(function () {

        //Get a list of users to start a new chat
        Route::get('new', StartableChatsList::class);

        //Post new message to chat
        Route::post('newmessage', [ChatController::class, 'newMessage']);

        //Return a single chat with messages
        Route::get('{chatId}', SingleChat::class);

        //Start a new chat with requested user
        Route::get('new/{targetUserId}', [ChatController::class, 'startNewChat']);

        //Return all started chats
        Route::get('', ChatHome::class);

        //Lazy load a new page for a category of users to start a new chat
        Route::get('loadCategoryPage/{categoryIndex}/{page}',  [ChatController::class, 'loadCategoryPage']);
    });
});






