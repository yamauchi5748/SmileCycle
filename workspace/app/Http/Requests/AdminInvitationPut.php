<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use App\Models\Invitation;

class AdminInvitationPut extends FormRequest
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
            'invitation_id' => $this->admin_invitation
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'invitation_id' => ['required', 'uuid', 'exists:invitations,_id'],
            'add_attend_members' => ['array'],
            'add_attend_members.*' => ['uuid', 'exists:members,_id', Rule::unique('invitations', 'attend_members._id')->where('_id', $this->admin_invitation)],
            'add_images' => ['array'],
            'add_images.*' => ['image', 'mimes:jpeg,png,jpg,gif'], 
            'delete_attend_members' => ['array'],
            'delete_attend_members.*' => ['uuid', 'exists:members,_id', Rule::exists('invitations', 'attend_members._id')->where('_id', $this->admin_invitation)],
            'delete_images' => ['array'],
            'delete_images.*' => ['uuid', Rule::exists('invitations', 'images')->where('_id', $this->admin_invitation)]
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
