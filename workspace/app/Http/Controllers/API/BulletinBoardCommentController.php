<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\MemberApiAuthController;

class BulletinBoardCommentController extends MemberApiAuthController
{
    /**
     * Display a listing of the resource.
     *
     * @param  int $billetin_board_id
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return [ "response" => "return bulletin_board.comments.index"];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int $billetin_board_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $billetin_board_id)
    {
        return [ "response" => "return bulletin_board.comments.store"];
    }
}
