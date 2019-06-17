<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\MemberAuthController;

class HelpController extends MemberAuthController
{
    public function index()
    {
        return view("help");
    }
}
