<?php

namespace App\Http\Controllers\API\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AdminAuthController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Requests\StampGroupPost;
use App\Http\Requests\StampGroupPut;
use App\Http\Requests\StampGroupDelete;
use App\Models\Member;
use App\Models\StampGroup;

class StampGroupController extends AdminAuthController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** すべてのスタンプグループを返す **/
        $this->response['stamp_groups'] = StampGroup::raw()->aggregate([
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
    public function store(StampGroupPost $request)
    {
        /* スタンプグループモデル */
        $stamp_group = [
            '_id' => (string) Str::uuid(),  // スタンプグループid
            'tab_image_id' => '',           // タブ画像のid
            'is_all' => $request->is_all,   // スタンプグループのタイプ
            'stamps' => [],                 // スタンプのidを格納
            'members' => $request->members, // 使用可能な会員のidを格納
        ];

        /** スタンプグループの作成 **/
        /* タブ画像のuuidを生成 */
        $tab_image_id = (string) Str::uuid();

        /* タブ画像を保存 */
        Storage::putFileAs('private/images/stamps', $request->tab_image, $tab_image_id . '.png', 'private');
    

        /* モデルにタブ画像のidをセット */
        $stamp_group['tab_image_id'] = $tab_image_id;

        /* 各スタンプの処理 */
        foreach ($request->stamps as $stamp) {
            /* スタンプ画像が既存でなければストレージに保存 */
            /* スタンプのuuidを生成 */
            $stamp_id = (string) Str::uuid();

            /* スタンプ画像を保存 */
            Storage::putFileAs('private/images/stamps', $stamp, $stamp_id . '.png', 'private');
        
            /* モデルにスタンプ画像のidを追加 */
            $stamp_group['stamps'][] = $stamp_id;
        }

        /* Memberモデルにスタンプグループを追加 */
        foreach ($stamp_group['members'] as $member) {
            Member::raw()->updateOne(
                [
                    '_id' => $member
                ],
                [
                    '$push' => [
                        'stamp_groups' => $stamp_group['_id']
                    ],
                    '$currentDate' => [
                        'lastModified' => true
                    ]
                ]
            );
        }

        /* スタンプグループをDBに登録 */
        StampGroup::raw()->insertOne($stamp_group);

        /* レスポンスデータを整形 */
        $this->response['stamp_group'] = $stamp_group;

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
    public function show($stamp_group_id)
    {
        return [ "response" => "return admin.stamp_groups.show"];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StampGroupPut $request, $stamp_group_id)
    {
        /* リクエストのパラメタをチェック */
        if(!$request->add_stamps) $request->add_stamps = [];
        if(!$request->remove_stamps) $request->remove_stamps = [];
        if(!$request->add_members) $request->add_members = [];
        if(!$request->remove_members) $request->remove_members = [];

        /* 追加するスタンプがあればidを生成し、ストレージに保存 */
        $new_stamps = [];
        foreach($request->add_stamps as $new_stamp)
        {
            /* スタンプのuuidを生成 */
            $stamp_id = (string) Str::uuid();

            /* スタンプ画像を保存 */
            Storage::putFileAs('private/images/stamps', $new_stamp, $stamp_id . '.png', 'private');
        
            /* モデルにスタンプ画像のidを追加 */
            $new_stamps[] = $stamp_id;
        }

        /** スタンプグループの追加処理 **/
        StampGroup::raw()->updateMany(
            // スタンプグループを指定
            [
                '_id' => $stamp_group_id
            ],
            [
                '$push' => [
                    // 会員を追加
                    'members' => [
                        '$each' => $request->add_members
                    ],
                    // スタンプを追加
                    'stamps' => [
                        '$each' => $new_stamps
                    ]
                ]
            ]
        );

        /** スタンプグループの削除処理 **/
        StampGroup::raw()->updateMany(
            // スタンプグループを指定
            [
                '_id' => $stamp_group_id
            ],
            [
                
                '$pullAll' => [
                    // 会員を削除
                    'members' => $request->remove_members,
                    'stamps' => $request->remove_stamps
                ]
            ]
        );

        /** 会員の追加処理 **/
        Member::raw()->updateMany(
            // 会員を指定
            [
                '_id' => [
                    '$in' => $request->add_members
                ]
            ],
            [
                '$push' => [
                    // スタンプグループを追加
                    'stamp_groups' => $stamp_group_id,
                ]
            ]
        );

        /** 会員の削除処理 **/
        Member::raw()->updateMany(
            // 会員を指定
            [
                '_id' => [
                    '$in' => $request->remove_members
                ]
            ],
            [
                
                '$pull' => [
                    // スタンプグループを削除
                    'stamp_groups' => $stamp_group_id
                ]
            ]
        );

        /* レスポンスデータを整形 */
        $this->response['stamp_group'] = head(StampGroup::raw()->aggregate([
            [
                '$match' => [
                    '_id' => $stamp_group_id
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(StampGroupDelete $request)
    {
        /** 会員のスタンプグループ情報を更新 **/
        Member::raw()->updateMany(
            [],
            [
                '$pull' => [
                    'stamp_groups' => [
                        '$in' => $request->delete_stamp_groups
                    ]
                ]
            ]
        );

        /** スタンプグループの削除 **/
        StampGroup::raw()->deleteOne(
            [
                '_id' => [
                    '$in' => $request->delete_stamp_groups
                ]
            ]
        );

        return response()->json(
            $this->response,
            200,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }
}
