<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.user.{id}', function ($user,$id) {
    // return (int) Auth::id() === (int) $id;
    return true;
});
Broadcast::channel('chat.messageRead.{user_sender}', function ($user,$user_sender) {
    return true;
});
Broadcast::channel('message.notRead.user.{user_sender}', function ($user,$user_sender) {
    return true;
});
