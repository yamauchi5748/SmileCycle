<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\MemberApiAuthController;

class ChatMemberController extends MemberApiAuthController
{
    /**
     * Display a listing of the resource.
     *
     * @param  int $chat_room_id
     * @return \Illuminate\Http\Response
     */
    public function index($chat_room_id)
    {
        return [ "response" => "return chat.members.index" ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int $chat_room_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $chat_room_id)
    {
        return [ "response" => "return chat.members.store" ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $chat_room_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($chat_room_id, $member_id)
    {
        return [ "response" => "return chat.members.destory" ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $chat_room_id
     * @return \Illuminate\Http\Response
     */
    public function destroies(Request $request, $chat_room_id)
    {
        return [ "response" => "return chat.members.destory" ];
    }
}
