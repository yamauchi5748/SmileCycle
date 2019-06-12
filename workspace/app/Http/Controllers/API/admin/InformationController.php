<?php

namespace App\Http\Controllers\API\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return [ "response" => "return admin.informations.index"];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $information_id
     * @return \Illuminate\Http\Response
     */
    public function show($information_id)
    {
        return [ "response" => "return admin.informations.show"];
    }
}
