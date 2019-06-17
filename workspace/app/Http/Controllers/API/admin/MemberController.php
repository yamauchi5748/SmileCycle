<?php

namespace App\Http\Controllers\API\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AdminAuthController;

class MemberController extends AdminAuthController
{
    /**
     * Display the specified resource.
     *
     * @param  int  $member_id
     * @return \Illuminate\Http\Response
     */
    public function show($member_id)
    {
        return [ "response" => "return admin.members.show"];
    }
}
