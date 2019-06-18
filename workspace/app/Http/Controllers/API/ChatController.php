<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\MemberApiAuthController;

class ChatController extends MemberApiAuthController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return [ "response" => "return chats.index"];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return [ "response" => "return chats.store"];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $chat_room_id
     * @return \Illuminate\Http\Response
     */
    public function show($chat_room_id)
    {
        return [ "response" => "return chats.show"];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $chat_room_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $chat_room_id)
    {
        return [ "response" => "return chats.update"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $chat_room_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($chat_room_id)
    {
        return [ "response" => "return chats.destroy"];
    }
}
