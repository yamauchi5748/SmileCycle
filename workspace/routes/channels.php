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

Broadcast::channel('room.{room_id}', function ($member, $room_id) {
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
Broadcast::channel('member.{member_id}', function ($member) {
    if ($member->_id == Auth::id()) {
        return $member;
    }
});
