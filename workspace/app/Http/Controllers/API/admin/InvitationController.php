<?php

namespace App\Http\Controllers\API\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AdminAuthController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Requests\InvitationPost;
use App\Http\Requests\InvitationDelete;
use App\Http\Requests\AdminInvitationPut;
use Carbon\Carbon;
use App\Models\Member;
use App\Models\Invitation;

class InvitationController extends AdminAuthController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** 会のご案内の一覧取得 **/
        $this->response['invitations'] = Invitation::raw()->aggregate([
            /* 返すプロパティを指定 */
            [
                '$project' => [
                    '_id' => 1,
                    'title' => 1,
                    'text' => 1,
                    'images' => 1,
                    'created_at' => 1
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
    public function store(InvitationPost $request)
    {
        $now  = (string) Carbon::now('Asia/Tokyo'); // 現在時刻

        /* 会のご案内モデル */
        $invitation = [
            '_id' => (string) Str::uuid(),              // 会のご案内のid
            'title' => $request->title,                 // 会のご案内のタイトル
            'text' => $request->text,                   // 会のご案内のテキスト
            'images' => [],                             // 会のご案内の画像
            'attend_members' => [],                     // 会のご案内に招待される会員
            'deadline_at' => $request->deadline_at,     // 会のご案内出席の締め切り日
            'created_at' => $now                        // 会のご案内投稿日
        ];

        /* 画像コンテンツの処理 */
        if ($request->images) {
            foreach ($request->images as $image) {
                /* 画像のuuidを生成 */
                $image_id = (string) Str::uuid();
    
                /* 画像を保存 */
                Storage::putFileAs('public/images/invitaions', $image, $image_id . '.png', 'private');
            
                /* モデルに画像のidを追加 */
                $invitation['images'][] = $image_id;
            }
        }

        $attend_members = [];
        /* 会のご案内へ招待される会員がいる場合 */
        if ($request->attend_members) {
            /* 会員の会のご案内追加 */
            Member::raw()->updateMany(
                [
                    // 会員を指定
                    '_id' => [
                        '$in' => $request->attend_members
                    ]
                ],
                [
                    '$push' => [
                        // 会のご案内を追加
                        'invitations' => $invitation['_id']
                    ]
                ]
            );

            /* 会員の整形データを取得 */
            $attend_members = Member::raw()->aggregate([
                // 会員を指定
                [
                    '$match' => [
                        '_id' => [
                            '$in' => $request->attend_members
                        ]
                    ]
                ],
                [
                    '$project' => [
                        '_id' => 1,
                        'name' => 1,
                        'ruby' => 1,
                        'status' => '3',
                    ]
                ]
            ])->toArray();
        }

        /* モデルに会員を追加 */
        $invitation['attend_members'] = $attend_members;

        /* モデルをDBに登録 */
        Invitation::raw()->insertOne($invitation);

        /* 返すレスポンスデータを整形 */
        if($invitation){
            $this->response['invitation'] = $invitation;
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($invitation_id)
    {
        $invitation = Invitation::raw()->aggregate([
            [
                '$match' => [
                    '_id' => $invitation_id     // idを指定
                ]
            ],
            /* 返すプロパティを指定 */
            [
                '$project' => [
                    '_id' => 1,
                    'title' => 1,
                    'text' => 1,
                    'images' => 1,
                    'attend_members' => 1,
                    'deadline_at' => 1,
                    'created_at' => 1
                ]
            ]
        ])->toArray();

        /* 返すレスポンスデータを整形 */
        if(head($invitation)){
            $this->response['invitation'] = head($invitation);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminInvitationPut $request, $invitation_id)
    {
        /* リクエストのパラメタをチェック */
        if(!$request->add_attend_members) $request->add_attend_members = [];
        if(!$request->delete_attend_members) $request->delete_attend_members = [];
        if(!$request->add_images) $request->add_images = [];
        if(!$request->delete_images) $request->delete_images = [];

        /* 追加対象の会員取得 */
        $add_members = Member::raw()->aggregate([
            [
                '$match' => [
                    '_id' => [
                        '$in' => $request->add_attend_members
                    ]
                ]
            ],
            [
                '$project' => [
                    '_id' => 1,
                    'name' => 1,
                ]
            ]
        ])->toArray();

        /* 追加対象の会員取得 */
        $delete_members = Member::raw()->aggregate([
            [
                '$match' => [
                    '_id' => [
                        '$in' => $request->delete_attend_members
                    ]
                ]
            ],
            [
                '$project' => [
                    '_id' => 1,
                    'name' => 1,
                ]
            ]
        ])->toArray();

        /* 画像コンテンツの処理 */
        $new_images = [];
        foreach ($request->add_images as $new_image) {
            /* 画像のuuidを生成 */
            $image_id = (string) Str::uuid();

            /* 画像を保存 */
            Storage::putFileAs('public/images/invitaions', $new_image, $image_id . '.png', 'private');
        
            /* モデルに画像のidを追加 */
            $new_images[] = $image_id;
        }

        /** 会のご案内の更新処理 **/
        Invitation::raw()->updateOne(
            // 会のご案内を指定
            [
                '_id' => $invitation_id
            ],
            [
                '$push' => [
                    // 会員を追加
                    'attend_members' => [
                        '$each' => $add_members
                    ],
                    // スタンプを追加
                    'images' => [
                        '$each' => $new_images
                    ]
                ]
            ]
        );

        Invitation::raw()->updateOne(
            // 会のご案内を指定
            [
                '_id' => $invitation_id
            ],
            [
                '$set' => [
                    'title' => $request->title,             // タイトルを更新
                    'text' => $request->text,               // テキストを更新
                    'deadline_at' => $request->deadline_at  // 締め切り日更新
                ]
            ]
        );

        /** 削除更新処理 **/
        invitation::raw()->updateMany(
            [
                '_id' => $invitation_id
            ],
            [
                
                '$pullAll' => [
                    // 会員を削除
                    'attend_members' => $delete_members,
                    'images' => $request->delete_images
                ]
            ]
        );

        /* スタンプ画像削除 */
        foreach ($request->delete_images as $image) {
            Storage::delete('public/images/invitations/' . $image . '.png');
        }

        $inv = Invitation::raw()->aggregate([
            [
                '$match' => [
                    '_id' => $invitation_id
                ]
            ]
        ])->toArray();

        /** 会員の追加処理 **/
        Member::raw()->updateMany(
            // 会員を指定
            [
                '_id' => [
                    '$in' => $request->add_attend_members
                ]
            ],
            [
                '$push' => [
                    // 会のご案内を追加
                    'invitations' => $invitation_id,
                ]
            ]
        );

        /** 会員の削除処理 **/
        Member::raw()->updateMany(
            // 会員を指定
            [
                '_id' => [
                    '$in' => $request->delete_attend_members
                ]
            ],
            [
                
                '$pull' => [
                    // 会のご案内を削除
                    'invitations' => $invitation_id,
                ]
            ]
        );

        /* レスポンスデータを整形 */
        $this->response['invitation'] = head(Invitation::raw()->aggregate([
            [
                '$match' => [
                    '_id' => $invitation_id
                ]
            ]
        ])->toArray());

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
    public function destroy(InvitationDelete $request, $invitation_id)
    {
        Invitation::raw()->deleteOne(
            [
                '_id' => $invitation_id
            ]
        );
        $invitation = Invitation::raw()->aggregate([
            [
                '$match' => [
                    '_id' => $invitation_id
                ]
            ]
        ])->toArray();
        return $invitation;
    }
}
