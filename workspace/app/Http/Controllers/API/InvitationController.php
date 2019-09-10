<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
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
        $this->response['invitations'] = Invitation::raw()->aggregate([
            [
                '$unwind' => '$attend_members'
            ],
            [
                '$match' => [
                    'attend_members._id' => $this->author->_id
                ]
            ],
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
                    '_id' => $invitation_id
                ]
            ],
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

        $this->response['invitation'] = head($invitation);
        
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
    public function update(Request $request, $id)
    {
        return [ "response" => "return invitations.update"];
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
