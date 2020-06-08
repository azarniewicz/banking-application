<?php

use Illuminate\Support\Facades\Broadcast;
use App\Broadcasting\OrderChannel;
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
Broadcast::channel('ustawienia.{user_id}', function ($user) {
    return Auth::check();
});

