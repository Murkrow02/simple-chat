<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Murkrow\Chat\Http\Controllers\ChatController;
use Murkrow\Chat\Http\Livewire\ChatsView;
use Murkrow\Chat\Http\Livewire\ChatView;
use Murkrow\Chat\Http\Livewire\NewChatView;
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

//Authenticate routes
Route::middleware(['web', 'auth'])->prefix('chat')->group(function () {

    //Get a list of users to start a new chat
    Route::get('new', NewChatView::class);

    //Post new message to chat
    Route::post('newmessage', [ChatController::class, 'newMessage']);

    //Return a single chat with messages
    Route::get('{chatId}', ChatView::class);

    //Start a new chat with requested user
    Route::get('new/{targetUserId}', [ChatController::class, 'startNewChat']);

    //Return all started chats
    Route::get('', ChatsView::class);

    //Hub used by mobile clients to be automatically logged in when using a web view
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('tokenlogin/{userId}/{token}', function ($userId, $token){

        //Validate token for user
        $providedToken = Utils::getUserClass()::find($userId)->tokens->where('token', $token);
        if($providedToken == null || $providedToken->count() == 0){
            abort(403);
        }

        //Token is found, log user in
        Auth::loginUsingId($userId);

        //Redirect to chat view
        return redirect('chat');
    });
});




