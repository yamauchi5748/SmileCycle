<?php

use App\Models\ChatRoom;

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

Broadcast::channel('room.{room_id}', function ($user, $room_id) {
    $rooms = ChatRoom::raw()->aggregate([
        [
            '$match' => [
                '_id' => $room_id
            ]
        ]
    ])->toArray();
    $room = head($rooms);

    return $room;
});
Broadcast::channel('user.{user_id}', function ($user, $user_id) {
    if ($user_id == Auth::id()) {
        return $user;
    }
});