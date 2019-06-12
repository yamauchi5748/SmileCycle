<?php

namespace App\Http\Controllers\API;

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
        return ["response" => "return members.index"];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $$member_id
     * @return \Illuminate\Http\Response
     */
    public function show($member_id)
    {
        return ["response" => "return members.show"];
    }
}
