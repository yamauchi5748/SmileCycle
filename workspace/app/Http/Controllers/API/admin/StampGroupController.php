<?php

namespace App\Http\Controllers\API\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AdminAuthController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
        return [ "response" => "return admin.stamp_groups.index"];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
        /* タブ画像が既存でなければストレージに保存 */
        if (!$request->tab_image['exist']) {
            /* タブ画像のuuidを生成 */
            $tab_image_id = (string) Str::uuid();

            /* タブ画像を保存 */
            Storage::putFileAs('public/images/stamps', $request->tab_image['image'], $tab_image_id . '.png', 'public');
        }

        /* モデルにタブ画像のidをセット */
        $stamp_group['tab_image_id'] = $request->tab_image['exist'] ? $request->tab_image['image'] : $tab_image_id;

        /* 各スタンプの処理 */
        foreach ($request->stamps as $stamp) {
            /* スタンプ画像が既存でなければストレージに保存 */
            if (!$stamp['exist']) {
                /* スタンプのuuidを生成 */
                $stamp_id = (string) Str::uuid();

                /* スタンプ画像を保存 */
                Storage::putFileAs('public/images/stamps', $stamp['image'], $stamp_id . '.png', 'public');
            }
            /* モデルにスタンプ画像のidを追加 */
            $stamp_group['stamps'][] = $stamp['exist'] ? $stamp['image'] : $stamp_id;
        }

        /* スタンプグループが個人用ならばモデルに会員を追加 */
        if (!$request->is_all) {
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
        }

        /* スタンプグループを登録 */
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
    public function update(Request $request, $stamp_group_id)
    {
        return [ "response" => "return admin.stamp_groups.update"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return [ "response" => "return admin.stamp_groups.destroy"];
    }
}
