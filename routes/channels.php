<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;
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

/**
 * El usaurio autenticado
 * El id que hemos pasado
 */

Broadcast::channel('mensaje.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('escribiendo', function ($user) {
    return Auth::check();
});

Broadcast::channel('logput.user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
