<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class MemberPut extends FormRequest
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
            'name' => ['string', 'max:64', 'unique:members'],
            'ruby' => ['string', 'max:128'],
            'post' => ['string', 'max:32'],
            'telephone_number' => ['string', 'regex:/^(070|080|090)-\d{4}-\d{4}$/'],
            'company_id' => ['uuid', 'exists:companies,_id'],
            'department_name' => ['string'],
            'mail' => ['string', 'email', 'max:256'],
            'password' => ['string', 'min:8', 'confirmed'],
            'profile_image' => ['image', 'mimes:jpeg,png,jpg,gif']
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
