<?php

namespace App\Http\Controllers\API;

use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController;

class MemberController extends AuthController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $response = [
            "auth" => true,
            "result" => true
        ];
        // データを整形して返す
        $response["members"] = Member::raw(function ($collection) {
            return $collection->aggregate(
                [
                    [
                        '$project' => [
                            'id' => 1,                  // 会員のidを返す
                            'name' => 1,                // 会員名を返す
                            'post' => 1,                // 会員の役職を返す
                            'mail' => 1,                // 会員のメールアドレスを返す
                            'profile_image_url' => [    // プロフィール画像のURLを追加 
                                '$concat' => [ 
                                    'https://', '$id' 
                                ] 
                            ],
                            'department_name' => 1,     // 部門名を返す
                            'company_id' => 1,          // 会社のidを返す
                        ]
                    ]
                ] 
            );
        });

        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return [ "response" => "return members.store"];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($member_id)
    {
        return [ "response" => "return members.show"];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $member_id)
    {
        return [ "response" => "return members.update"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($member_id)
    {
        return [ "response" => "return members.delete"];
    }
}
