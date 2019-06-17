<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\MemberAuthController;

class ChatContentController extends MemberAuthController
{
    /**
     * Display a listing of the resource.
     *
     * @param  int $chat_room_id
     * @return \Illuminate\Http\Response
     */
    public function index($chat_room_id)
    {
        return [ "response" => "return chat.contents.index" ];
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
        return [ "response" => "return chat.contents.store" ];
    }
}
