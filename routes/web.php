<?php

use Illuminate\Support\Facades\Route;
use Murkrow\Chat\Http\Controllers\ChatController;
use Murkrow\Chat\Http\Livewire\ChatView;
use Murkrow\Chat\Http\Livewire\ChatsView;

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
    Route::get('/chats/{chatId}', ChatView::class);
    Route::get('/chats', ChatsView::class);

    //Post new message to chat
    Route::post('/newmessage', [ChatController::class, 'newMessage']);

});




