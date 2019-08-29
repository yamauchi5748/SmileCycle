<?php

namespace App\Http\Controllers\API\admin;

use App\Company;
use Illuminate\Http\Request;
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
    public function store(Request $request)
    {
        /** 会社を作成 **/
        $this->response["company"] = Company::create(
            [
                /* 各データを設定 */
                'id' => (string) Str::uuid(),
                'name' => $request->name,
                'address' => $request->address,
                'fax' => $request->fax,
                'tel' => $request->tel
            ]
        );

        return $this->response;
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
    public function update(Request $request, $company_id)
    {
        return [ "response" => "return admin.companies.update"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($company_id)
    {
        return [ "response" => "return admin.companies.destroy"];
    }
}
