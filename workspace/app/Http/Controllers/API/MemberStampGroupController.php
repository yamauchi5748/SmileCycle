<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\CommonAuthController;

class MemberStampGroupController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @param  int $member_id
     * @return \Illuminate\Http\Response
     */
    public function index($member_id)
    {
        return [ "response" => "return member.stamp_groups.index"];
    }
}
