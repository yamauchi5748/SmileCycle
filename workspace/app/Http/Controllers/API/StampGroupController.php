<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController;
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
        /** 認証会員が使用可能なスタンプグループを返す **/
        $this->response['stamp_groups'] = StampGroup::raw()->aggregate([
            /*  会員を指定 */
            [
                '$unwind' => '$members'
            ],
            [
                '$match' => [
                    'members' => $this->author->_id
                ]
            ],
            [
                '$project' => [
                    '_id' => 1,
                    'tab_image_id' => 1,
                    'is_all' => 1,
                    'stamps' => 1
                ]
            ]
        ])->toArray();
        
        return response()->json(
            $this->response,
            200,
            [],
            JSON_UNESCAPED_UNICODE
        );
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
