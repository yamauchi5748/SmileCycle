<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ChatRoomContentPost extends FormRequest
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
            'is_hurry' => ['required', 'boolean'],
            'message' => ['required_if:content_type,1', 'string', 'max:500', 'min:1'],
            'stamp_id' => ['required_if:content_type,2', 'uuid', 'exists:stamp_groups,stamps'],
            'content' => ['required_if:content_type,3', 'image', 'mimes:jpeg,png,jpg,gif'],
            'content' => ['required_if:content_type,4', 'video', 'mimetypes:video/avi,video/mpeg,video/quicktime'],
            'content_type' => ['required',  Rule::in(['1', '2', '3', '4'])]
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
