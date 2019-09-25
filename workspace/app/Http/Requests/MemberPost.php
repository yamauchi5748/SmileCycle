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
            'name' => ['required', 'string', 'max:15', 'min:2', 'unique:members,name'],
            'ruby' => ['required', 'string', 'max:30', 'min:2'],
            'post' => ['required', 'string', 'max:50', 'min:1'],
            'telephone_number' => ['required', 'string', 'regex:/^(070|080|090)-\d{4}-\d{4}$/'],
            'company_id' => ['required', 'uuid', 'exists:companies,_id'],
            'department_name' => ['required', Rule::in(['東京笑門会', '鎌倉笑門会', '大阪笑門会', '愛媛笑門会'])],
            'mail' => ['required', 'email', 'max:256'],
            'password' => ['required', 'string', 'min:8', 'max:100', 'confirmed'],
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
        $response['data']    = [
            'auth' => true,
            'result' => false
        ];
        $response['status']  = 'NG';
        $response['summary'] = 'Failed validation.';
        $response['errors']  = $validator->errors()->toArray();

        throw new HttpResponseException(
            response()->json($response, 422)
        );
    }
}
