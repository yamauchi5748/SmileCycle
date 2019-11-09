<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class MemberPost extends FormRequest
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
        return [
            'name' => ['required', 'string', 'between:2,15', 'unique:members,name'],
            'ruby' => ['required', 'string', 'between:2,30'],
            'post' => ['required', 'string', 'between:1,50'],
            'telephone_number' => ['required', 'string', 'regex:/^(070|080|090)-\d{4}-\d{4}$/'],
            'company_id' => ['required', 'uuid', 'exists:companies,_id'],
            'department_name' => ['required', Rule::in(['東京笑門会', '鎌倉笑門会', '大阪笑門会', '愛媛笑門会'])],
            'mail' => ['required', 'email', 'max:256'],
            'secretary_name' => ['required_with:secretary_mail','string', 'between:2,15'],
            'secretary_mail' => ['required_with:secretary_name', 'email'],
            'password' => ['required', 'string', 'regex:/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]*\z/', 'between:8,100', 'confirmed'],
        ];
    }

    public function messages()
    {
        return [];
    }

    /**
     * [override] バリデーション失敗時ハンドリング
     *
     * @param Validator $validator
     * @throw HttpResponseException
     * @see FormRequest::failedValidation()
     */
    protected function failedValidation(Validator $validator)
    {
        $response['auth'] = true;
        $response['result'] = false;
        $response['message'] = $validator->errors()->toArray();

        throw new HttpResponseException(
            response()->json($response, 422)
        );
    }
}
