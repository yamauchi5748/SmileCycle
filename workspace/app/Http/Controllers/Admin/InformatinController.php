<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AdminAuthController;

class InformationController extends AdminAuthController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.informations.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.informations.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return view("admin.informations.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $information_id
     * @return \Illuminate\Http\Response
     */
    public function show($information_id)
    {
        return view("admin.informations.show");
    }
}
