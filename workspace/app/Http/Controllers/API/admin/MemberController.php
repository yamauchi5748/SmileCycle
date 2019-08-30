<?php

namespace App\Http\Controllers\API\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AdminAuthController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Member;

class MemberController extends AdminAuthController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return [ "response" => "return admin.members.index"];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /** 会員の作成 **/
        $id = (string) Str::uuid(); // uuidを生成
        
        Member::raw()->insertOne([
            'id' => $id,                                        // 会員id
            'api_token' => Str::random(60),                     // api_token
            'is_notification' => true,                          // 通知の可否情報
            'notification_interval' => '0.5h',                  // 通知間隔
            'is_admin' => false,                                // 管理者かどうか
            'name' => $request->name,                           // 会員名
            'ruby' => $request->ruby,                           // ふりがな
            'post' => $request->post,                           // 役職名
            'tel' => $request->tel,                             // 電話番号
            'company_id' => $request->company_id,               // 会社id
            'department_name' => $request->department_name,     // 部門名
            'mail' => $request->mail,                           // メールアドレス
            'password' => Hash::make($request->password)        // パスワード
        ]);

        $member = Member::raw()->aggregate(
            [
                /* 会社collectionと結合 */
                [
                    '$lookup' => [
                        'from' => 'companies',
                        'localField' => "company_id",
                        'foreignField' => "id",
                        'as' => 'company'
                    ]
                ],
                /* companyインベントリを展開 */
                [
                    '$unwind' => '$company'
                ],
                /* 作成した会員を指定 */
                [
                    '$match' => [
                        'id' => $id
                    ]
                ],
                /* 取得するデータを指定 */
                [
                    '$project' => [
                        '_id' => 0,
                        'id' => 1,                              // 会員のidを返す
                        'name' => 1,                            // 会員名を返す
                        'ruby' => 1,                            // 会員のふりがなを返す
                        'post' => 1,                            // 会員の役職を返す
                        'tel' => 1,                             // 会員の電話番号を返す
                        'mail' => 1,                            // 会員のメールアドレスを返す
                        'department_name' => 1,                 // 部門名を返す
                        'company_id' => 1,                      // 会社のidを返す
                        'company_name' => '$company.name',      // 会社名を返す
                    ]
                ]
            ]
        )->toArray();

        /* 会員が作成できたかチェック */
        if(head($member) && head($member)['company_name']){
            $this->response['member'] = head($member);
        }else {
            $this->response['result'] = false; 
        }

        return $this->response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($member_id)
    {
        return [ "response" => "return admin.members.show"];
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
        return [ "response" => "return admin.members.update"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($member_id)
    {
        return [ "response" => "return admin.members.destroy"];
    }
}
