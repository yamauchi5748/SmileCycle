<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Requests\CompanyGet;
use App\Models\Company;

class CompanyController extends AuthController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** 会社情報を返す **/
        $companies = Company::raw()->aggregate([
            [
                '$project' => [
                    '_id' => 1,
                    'name' => 1
                ]
            ]
        ])->toArray();
        
        /* 返すレスポンスデータを整形 */
        if($companies){
            $this->response['companies'] = $companies;
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return [ "response" => "return companies.store"];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CompanyGet $request, $company_id)
    {
        /** 会社情報を返す **/
        $company_corsor = Company::raw()->aggregate([
            [
                '$match' => [
                    '_id' => $company_id
                ]
            ],
            [
                '$lookup' => [
                    'from' => 'members',
                    'let' => [
                        'members' => '$members'
                    ],
                    'pipeline' => [
                        [
                            '$match' => [
                                '$expr' => [
                                    '$in' => ['$_id', '$$members']
                                ]
                            ]
                        ],
                        [
                            '$project' => [
                                '_id' => 1,
                                'name' => 1
                            ]
                        ]
                    ],
                    'as' => 'members'
                ]
            ]
        ])->toArray();
        
        /* 返すレスポンスデータを整形 */
        if(head($company_corsor)){
            $this->response['company'] = head($company_corsor);
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
    public function update(Request $request, $company_id)
    {
        return [ "response" => "return companies.update"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($company_id)
    {
        return [ "response" => "return companies.destroy"];
    }
}
