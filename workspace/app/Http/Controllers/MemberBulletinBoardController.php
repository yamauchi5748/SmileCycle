<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberBulletinBoardController extends Controller
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