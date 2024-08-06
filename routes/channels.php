<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;


Broadcast::channel("App.Models.User.{userId}", function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
