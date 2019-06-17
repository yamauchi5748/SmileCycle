<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\MemberWebAuthController;

class HelpController extends MemberWebAuthController
{
    public function index()
    {
        return view("help");
    }
}
