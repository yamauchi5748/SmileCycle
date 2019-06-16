<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.members.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.members.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return view("admin.members.index");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $$member_id
     * @return \Illuminate\Http\Response
     */
    public function edit($member_id)
    {
        return view("admin.members.edit");
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
        return view("admin.members.edit");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $$member_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($member_id)
    {
        return view("admin.members.index");
    }
}
