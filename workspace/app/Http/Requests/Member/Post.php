<?php

namespace App\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;

class Post extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:64', 'unique:members'],
            'ruby' => ['required', 'string', 'max:128'],
            'post' => ['required', 'string', 'max:32'],
            'tel' => ['required', 'string', 'regex:^(070|080|090)-\d{4}-\d{4}$'],
            'company_id' => ['required', 'uuid', 'exists:companies,id'],
            'department_name' => ['required', 'string'],
            'mail' => ['required', 'string', 'email', 'max:256'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
}
