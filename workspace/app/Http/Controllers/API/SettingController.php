<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Auth\AuthController;
use App\Models\Company;
use App\Models\Member;
use App\Http\Requests\SettingPut;

class SettingController extends AuthController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** 認証会員の情報を返す **/
        /* 認証会員の属している会社を取得 */
        $companies = Company::raw()->aggregate([
            [
                '$unwind' => '$members'
            ],
            [
                '$match' => [
                    'members' => $this->author->_id
                ]
            ]
        ])->toArray();
        $company = head($companies);

        /* 返すレスポンスデータを整形 */
        if (!$company) {
            $this->response['result'] = false;
            return $this->response;
        }
        
        /*レスポンスデータを整形 */
        $this->response['member'] = [
            '_id' => $this->author->_id,
            'name' => $this->author->name,
            'ruby' => $this->author->ruby,
            'post' => $this->author->post,
            'telephone_number' => $this->author->telephone_number,
            'mail' => $this->author->mail,
            'is_notification' => $this->author->is_notification,
            'notification_interval' => $this->author->notification_interval,
            'department_name' => $this->author->department_name,
            'company_name' => $company->name
        ];

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
        return [ "response" => "return settings.store"];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return [ "response" => "return settings.show"];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SettingPut $request)
    {
        /** 会員の更新 **/
        Member::raw()->updateOne(
            [
                '_id' => $this->author->_id
            ],
            [
                '$set' => [
                    'mail' => $request->mail,                                       // メールアドレス
                    'is_notification' => $request->is_notification,                 // 通知可否
                    'notification_interval' => $request->notification_interval      // 通知間隔
                ]
            ]
        );

        // 会員のプロフィール画像を更新
        Storage::putFileAs('private/images/profile_images', $request->profile_image, $this->author->_id . '.png', 'private');

        $member = Member::raw()->aggregate([
            /* 会員を指定 */
            [
                '$match' => [
                    '_id' => $this->author->_id
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
                                'members' => $this->author->_id
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
                    'is_notification' => 1,                 // 通知可否を返す
                    'notification_interval' => 1,           // 通知間隔を返す
                    'department_name' => 1,                 // 部門名を返す
                    'company_name' => '$company.name',      // 会社名を返す
                ]
            ]
        ])->toArray();

        /* 会員が取得できたかチェック */
        if ($member) {
            $this->response['member'] = $member;
        } else {
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return [ "response" => "return settings.delete"];
    }
}
