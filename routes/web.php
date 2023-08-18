<?php

use Illuminate\Support\Facades\Route;
use Murkrow\Chat\Http\Controllers\ChatController;
use Murkrow\Chat\Http\Livewire\ChatView;
use Murkrow\Chat\Http\Livewire\ChatsView;
use Murkrow\Chat\Http\Livewire\NewChatView;

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
Route::middleware(['web', 'auth'])->group(function () {

    //Return a single chat with messages
    Route::get('/chats/{chatId}', ChatView::class);

    //Return all started chats
    Route::get('/chats', ChatsView::class);

    //Post new message to chat
    Route::post('/newmessage', [ChatController::class, 'newMessage']);

    //Get a list of users to start a new chat
    Route::get('/newchat', NewChatView::class);

    //Start a new chat with requested user
    Route::get('/newchat/{targetUserId}', [ChatController::class, 'startNewChat']);

});




