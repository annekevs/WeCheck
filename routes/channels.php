<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('donnees-channel', function ($user) {
    return true;
});

Broadcast::channel('etat-module-channel', function () {
    return true;
});
