<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BulletinBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("bulletin_boards,index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("bulletin_boards.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return view("bulletin_boards.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $bulletin_board_id
     * @return \Illuminate\Http\Response
     */
    public function show($bulletin_board_id)
    {
        return view("bulletin_boards.show");
    }
}
