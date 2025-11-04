<?php

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

// Canal privado para las notificaciones de "Pendiente de Firma"
// Solo usuarios con el rol adecuado podrán escuchar este canal.
Broadcast::channel('pendiente-firma', function ($user) {
    return method_exists($user, 'hasRole') && $user->hasRole('Super Usuario');
});
