<?php

namespace App\Http\Controllers\API\admin;

use Illuminate\Http\Request;
use App\Http\Requests\MemberPost;
use App\Http\Requests\MemberPut;
use App\Http\Requests\MemberDelete;
use App\Http\Controllers\Auth\AdminAuthController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Str;
use App\Models\Member;
use App\Models\Company;
use App\Models\ChatRoom;

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
    public function store(MemberPost $request)
    {
        /** 会員の作成 **/
        /* 会員モデル */
        $member = [
            '_id' => (string) Str::uuid(),                      // 会員id
            'api_token' => Str::random(60),                     // api_token
            'is_notification' => true,                          // 通知の可否情報
            'notification_interval' => '0.5h',                  // 通知間隔
            'is_admin' => false,                                // 管理者かどうか
            'name' => $request->name,                           // 会員名
            'ruby' => $request->ruby,                           // ふりがな
            'post' => $request->post,                           // 役職名
            'telephone_number' => $request->telephone_number,   // 電話番号
            'department_name' => $request->department_name,     // 部門名
            'mail' => $request->mail,                           // メールアドレス
            'password' => Hash::make($request->password),       // パスワード
            'secretary' => [],                                  // 秘書
            'stamp_groups' => [],                               // 会員が使用できるスタンプ
            'invitations' => [],                                // 会員が投稿した掲示板
        ];

        /* 秘書情報があれば追加 */
        if ($request->secretary_name && $request->secretary_mail) {
            $member['secretary'] = [
                'name' => $request->secretary_name,
                'mail' => $request->secretary_mail
            ];
        }

        // 会員のプロフィール画像をストレージに保存
        Storage::copy('images/boy_3.png', 'public/images/profile_images/' . $member['_id'] . '.png');
        
        /* 会員モデルをDBに登録 */
        Member::raw()->insertOne($member);

        /** 会社の会員情報を更新 **/
        Company::raw()->updateOne(
            [
                '_id' => $request->company_id
            ],
            [
                '$push' => [
                    'members' => $member['_id']                 // 会員のidを追加
                ]
            ]
        );

        /** 部門チャットグループに会員を追加 **/
        ChatRoom::raw()->updateOne(
            [
                'group_name' => $request->department_name,
                'is_department' => true,
            ],
            [
                '$push' => [
                    'members' => [
                        '_id' => $member['_id'],
                        'name' => $member['name']
                    ]
                ]
            ]
        );

        /* 会員が作成できたかチェック */
        $return_member = $this->getMember($member['_id']);
        if ($return_member) {
            $this->response['member'] = $return_member;
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
    public function update(MemberPut $request, $member_id)
    {
        /** 会員の更新 **/
        /* 更新会員のモデル */
        $member = [
            'name' => $request->name,                           // 会員名
            'ruby' => $request->ruby,                           // ふりがな
            'post' => $request->post,                           // 役職名
            'telephone_number' => $request->telephone_number,   // 電話番号
            'company_id' => $request->company_id,               // 会社id
            'department_name' => $request->department_name,     // 部門名
            'mail' => $request->mail,                           // メールアドレス
        ];

        /* 秘書情報があれば追加 */
        if ($request->secretary_name && $request->secretary_mail) {
            $member['secretary'] = [
                'name' => $request->secretary_name,
                'mail' => $request->secretary_mail
            ];
        }
        
        if ($request->password) {
            $member['password'] = Hash::make($request->password);   // パスワード
        }
        Member::raw()->updateOne(
            [
                '_id' => $member_id
            ],
            [
                '$set' => $member
            ]
        );

        /* 会員が更新できたかチェック */
        $return_member = $this->getMember($member_id);
        if ($return_member) {
            $this->response['member'] = $return_member;
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
    public function destroy(MemberDelete $request, $member_id)
    {
        /* 削除する会員を取得 */
        $member = $this->getMember($member_id);

        /* 会員を取得できなかった場合 */
        if (!$member) {
            $this->response['result'] = false;
            return $this->response;
        }

        /** 会社の会員情報を削除 **/
        Company::raw()->updateOne(
            [
                '_id' => $member->company_id
            ],
            [
                '$pull' => [
                    'members' => $member_id                     // 会員のidを削除
                ]
            ]
        );

        /** 会員の削除 **/
        Member::raw()->deleteOne(
            [
                '_id' => $member_id
            ]
        );

        return response()->json(
            $this->response,
            200,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }

    /**指定された会員を取得
     *
     * @param  int  $id
     * @return \App\Models\Member
     */
    public function getMember($member_id)
    {
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

        return head($member);
    }
}
