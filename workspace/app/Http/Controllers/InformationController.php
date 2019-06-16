<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("informations.index");
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $information_id
     * @return \Illuminate\Http\Response
     */
    public function show($information_id)
    {
        return view("informations.show");
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $information_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $information_id)
    {
        return view("informations.show");
    }
}
