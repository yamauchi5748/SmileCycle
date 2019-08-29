<?php

namespace App\Http\Controllers\API;

use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController;
use Jenssegers\Mongodb;

class MemberController extends AuthController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* 会員の情報を一覧にまとめてJsonデータを生成 */
        $this->response["members"] = Member::raw()->aggregate(
            [
                /* 取得するデータを指定 */
                [
                    '$project' => [
                        '_id' => 0,
                        'id' => 1,                  // 会員のidを返す
                        'name' => 1,                // 会員名を返す
                        'ruby' => 1,                // 会員のふりがなを返す
                        'post' => 1,                // 会員の役職を返す
                        'profile_image_url' => [    // プロフィール画像のURLを追加
                            '$concat' => [
                                'https://', '$id', '.png'
                            ]
                        ]
                    ]
                ]
            ]
        )->toArray();

        return $this->response;
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
        /** 会員の詳細情報のJsonデータを生成 **/
        /* MongoDBCollectionからcursorを生成 */
        $member = Member::raw()->aggregate(
            [
                /* 送られたmember_idに対応する会員を指定 */
                [
                    '$match' => [
                        'id' => $member_id
                    ]
                ],
                /* 取得するデータを指定 */
                [
                    '$project' => [
                        '_id' => 0,
                        'id' => 1,                  // 会員のidを返す
                        'name' => 1,                // 会員名を返す
                        'ruby' => 1,                // 会員のふりがなを返す
                        'post' => 1,                // 会員の役職を返す
                        'tel' => 1,                // 会員の電話番号を返す
                        'mail' => 1,                // 会員のメールアドレスを返す
                        'profile_image_url' => [    // プロフィール画像のURLを追加
                            '$concat' => [
                                'https://', '$id'
                            ]
                        ],
                        'department_name' => 1,     // 部門名を返す
                        'company_id' => 1,          // 会社のidを返す
                        'company_name' => 1,          // 会社名を返す
                    ]
                ]
            ]
        )->toArray();

        /* 会員が取得できたかチェック */
        if(head($member)){
            $this->response['member'] = head($member);
        }else {
            $this->response['result'] = false; 
        }

        return $this->response;
        ;
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
