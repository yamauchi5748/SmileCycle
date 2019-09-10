<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\InvitationPut;
use App\Http\Controllers\Auth\AuthController;
use App\Models\Invitation;

class InvitationController extends AuthController
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
            /* プロパティを展開 */
            [
                '$unwind' => '$attend_members'
            ],
            /* 認証会員が招待されている会のご案内を指定 */
            [
                '$match' => [
                    'attend_members._id' => $this->author->_id
                ]
            ],
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
    public function store(Request $request)
    {
        return [ "response" => "return invitations.store"];
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
                    '_id' => $invitation_id,                    // idを指定
                    'attend_members._id' => $this->author->_id  // 認証会員が招待されている会のご案内を指定
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
    public function update(InvitationPut $request, $invitation_id)
    {
        /** 会員の会のご案内出席状況を更新 **/
        Invitation::raw()->updateOne(
            /* 更新する会のご案内を指定 */
            [
                '_id' => $invitation_id,
                'attend_members._id' => $this->author->_id
            ],
            /* プロパティをセット */
            [
                '$set' => [
                    'attend_members.$.status' => $request->attend_status
                ]
            ]
        );

        /* 更新された会のご案内を取得 */
        $invitation = Invitation::raw()->aggregate([
            [
                '$match' => [
                    '_id' => $invitation_id,                    // idを指定
                    'attend_members._id' => $this->author->_id  // 認証会員が招待されている会のご案内を指定
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return [ "response" => "return invitations.delete"];
    }
}
