<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Storage;
use App\Models\Member;
use App\Models\StampGroup;

class StampGroupController extends AuthController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stamp_groups = StampGroup::raw()->aggregate([
        
            /* 会員collectionと結合 */
            [
                '$lookup' => [
                    'from' => 'members',
                    'pipeline' => [
                        [
                            '$unwind' => '$stamp_groups'
                        ],
                        [
                            '$match' => [
                                '_id' => $this->author->_id
                            ]
                        ]
                    ],
                    'as' => 'member'
                ]
            ]
        ])->toArray();
        
        return $stamp_groups;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return [ "response" => "return stamp_groups.store"];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($stamp_group_id)
    {
        return [ "response" => "return stamp_groups.show"];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $stamp_group_id)
    {
        return [ "response" => "return stamp_groups.update"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($stamp_group_id)
    {
        return [ "response" => "return stamp_groups.destroy"];
    }
}
