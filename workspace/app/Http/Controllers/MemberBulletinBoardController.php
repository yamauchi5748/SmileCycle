<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\MemberWebAuthController;

class MemberBulletinBoardController extends MemberWebAuthController
{
    /**
     * Display a listing of the resource.
     *
     * @param  int $member_id
     * @return \Illuminate\Http\Response
     */
    public function index($member_id)
    {
        return view("members.bulletin_boards.index");
    }
}