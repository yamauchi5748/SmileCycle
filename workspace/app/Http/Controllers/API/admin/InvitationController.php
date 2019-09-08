<?php

namespace App\Http\Controllers\API\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AdminAuthController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
        return [ "response" => "return admin.invitations.index"];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
        foreach ($request->images as $image) {
            /* 画像のuuidを生成 */
            $image_id = (string) Str::uuid();

            /* 画像を保存 */
            Storage::putFileAs('public/images/invitaions', $image, $image_id . '.png', 'private');
        
            /* モデルに画像のidを追加 */
            $invitation['images'][] = $image_id;
        }

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

        /* モデルに会員を追加 */
        $invitation['attend_members'] = $attend_members;

        /* モデルをDBに登録 */
        Invitation::raw()->insertOne($invitation);

        /* レスポンスデータを整形 */
        $this->response['invitation'] = $invitation;

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
    public function show($id)
    {
        return [ "response" => "return admin.invitations.show"];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return [ "response" => "return admin.invitations.update"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return [ "response" => "return admin.invitations.delete"];
    }
}
