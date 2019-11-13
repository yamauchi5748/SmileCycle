<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use App\Models\Member;

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
     * ルート引数は対象にならないのでマージする
     * @return 配列
     */
    public function validationData()
    {
        return array_merge($this->request->all(), [
            'member_id' => $this->member
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $member = Member::where('_id', $this->member)->first();
        return [
            'member_id' => ['required' ,'uuid', 'exists:members,_id'],
            'name' => ['required' ,'string', 'between:2,15', Rule::unique('members')->ignore($member)],
            'ruby' => ['required' ,'string', 'between:2,30'],
            'post' => ['required' ,'string', 'between:1,50'],
            'telephone_number' => ['required' ,'string', 'regex:/^(070|080|090)-\d{4}-\d{4}$/'],
            'company_id' => ['required' ,'uuid', 'exists:companies,_id'],
            'department_name' => ['required', Rule::in(['東京笑門会', '鎌倉笑門会', '大阪笑門会', '愛媛笑門会'])],
            'mail' => ['required', 'email', 'max:256'],
            'secretary_name' => ['required_with:secretary_mail','string', 'between:2,15'],
            'secretary_mail' => ['required_with:secretary_name', 'email'],
            'password' => ['string', 'min:8', 'confirmed']
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
