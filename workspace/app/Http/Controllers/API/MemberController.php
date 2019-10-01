<?php

namespace App\Http\Controllers\API;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Requests\MemberGet;
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
        $members = Member::raw()->aggregate(
            [
                /* 取得するデータを指定 */
                [
                    '$project' => [
                        '_id' => 1,                 // 会員のidを返す
                        'name' => 1,                // 会員名を返す
                        'ruby' => 1,                // 会員のふりがなを返す
                        'post' => 1,                // 会員の役職を返す
                        'department_name' => 1,     // 会員の部門名を返す
                    ]
                ]
            ]
        )->toArray();

        /* 返すレスポンスデータを整形 */
        $head = head($members);
        if($head){
            $this->response['members'] = $members;
        }else{
            $this->response['result'] = false;
        }

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
        return [ "response" => "return members.store"];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(MemberGet $request, $member_id)
    {
        /** 会員の詳細情報を取得 **/
        $member = Member::raw()->aggregate(
            [
                /* 会員を指定 */
                [
                    '$match' => [
                        '_id' => $member_id
                    ]
                ],
                /* 会社collectionと結合 */
                [
                    '$lookup' => [
                        'from' => 'companies',
                        'pipeline' => [
                            [
                                '$unwind' => '$members'
                            ],
                            [
                                '$match' => [
                                    'members' => $member_id
                                ]
                            ]
                        ],
                        'as' => 'company'
                    ]
                ],
                /* companyインベントリを展開 */
                [
                    '$unwind' => '$company'
                ],
                /* 取得するデータを指定 */
                [
                    '$project' => [
                        '_id' => 1,                             // 会員のidを返す
                        'name' => 1,                            // 会員名を返す
                        'ruby' => 1,                            // 会員のふりがなを返す
                        'post' => 1,                            // 会員の役職を返す
                        'telephone_number' => 1,                // 会員の電話番号を返す
                        'mail' => 1,                            // 会員のメールアドレスを返す
                        'department_name' => 1,                 // 部門名を返す
                        'secretary' => [                        // 秘書
                            'name' => '$secretary.name',
                            'mail' => '$secretary.mail'
                        ],
                        'company_id' => '$company._id',         // 会社のidを返す
                        'company_name' => '$company.name',      // 会社名を返す
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

        return response()->json(
            $this->response,
            200,
            [],
            JSON_UNESCAPED_UNICODE
        );
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
