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


Broadcast::channel('chat', function ($user) {
    return true;
});


Broadcast::channel('my-message.{id}', function () {
    return true;
});

Broadcast::channel('send-message-from-admin.{id}', function () {
    return true;
});
Broadcast::channel('send-message-to-group-from-client.{id}', function () {
    return true;
});
