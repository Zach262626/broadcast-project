<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel("Upload.User.{userId}", function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
Broadcast::channel("Download.User.{userId}", function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
Broadcast::channel("Counter.User.{userId}", function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
Broadcast::channel("Counter.Done.User.{userId}", function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
Broadcast::channel("Export.Files.User.{userId}", function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

