<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\MemberAuthController;

class BulletinBoardController extends MemberAuthController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return [ "response" => "return bulletin_boards.index"];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $bulletin_board_id
     * @return \Illuminate\Http\Response
     */
    public function show($bulletin_board_id)
    {
        return [ "response" => "return bulletin_boards.show"];
    }
}
