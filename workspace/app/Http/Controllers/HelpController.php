<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController;

class HelpController extends AuthController
{
    public function index()
    {
        return view("help");
    }
}
