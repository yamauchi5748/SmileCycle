<?php

namespace App\Http\Controllers\API\admin;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyPost;
use App\Http\Requests\CompanyPut;
use App\Http\Requests\CompanyDelete;
use App\Http\Controllers\Auth\AdminAuthController;
use Illuminate\Support\Str;

class CompanyController extends AdminAuthController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return [ "response" => "return admin.companies.index"];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyPost $request)
    {
        /** 会社を作成 **/
        /* モデル作成 */
        $company = [
            /* 各データを設定 */
            '_id' => (string) Str::uuid(),
            'name' => $request->name,
            'address' => $request->address,
            'telephone_number' => $request->telephone_number,
            'members' => []
        ];

        Company::raw()->insertOne($company);
        $this->response['company'] = $company;

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
    public function show($company_id)
    {
        return [ "response" => "return admin.companies.show"];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyPut $request, $company_id)
    {
        /** 会社を作成 **/
        /* モデル作成 */
        $company = [
            /* 各データを設定 */
            'name' => $request->name,
            'address' => $request->address,
            'telephone_number' => $request->telephone_number
        ];

        $this->response['company'] = $company;

        Company::raw()->updateOne(
            [
                '_id' => $company_id
            ],
            [
                '$set' => [
                    /* 各データを設定 */
                    'name' => $request->name,
                    'address' => $request->address,
                    'telephone_number' => $request->telephone_number
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompanyDelete $request, $company_id)
    {
        /** 会社の削除 **/
        Company::raw()->deleteOne(
            [
                '_id' => $company_id
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
