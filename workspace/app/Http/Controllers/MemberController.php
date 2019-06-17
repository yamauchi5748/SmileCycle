<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\MemberWebAuthController;

class MemberController extends MemberWebAuthController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("members.index");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $member_id
     * @return \Illuminate\Http\Response
     */
    public function edit($member_id)
    {
        return view("members.edit");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $member_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $member_id)
    {
        return view("members.edit");
    }
}
