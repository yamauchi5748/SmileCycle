<?php

namespace App\Http\Controllers\API\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AdminAuthController;

class CompanyController extends AdminAuthController
{
    /**
     * Display the specified resource.
     *
     * @param  int  $company_id
     * @return \Illuminate\Http\Response
     */
    public function show($company_id)
    {
        return [ "response" => "return admin.companies.show"];
    }
}
