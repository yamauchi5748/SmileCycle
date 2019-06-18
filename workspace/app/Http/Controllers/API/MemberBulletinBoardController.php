<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\MemberApiAuthController;

class MemberBulletinBoardController extends MemberApiAuthController
{
    /**
     * Display a listing of the resource.
     *
     * @param  int $member_id
     * @return \Illuminate\Http\Response
     */
    public function index($member_id)
    {
        return [ "response" => "return member.bulletin_boards.index" ];
    }
}
