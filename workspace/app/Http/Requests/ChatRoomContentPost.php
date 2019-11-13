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
     * ルート引数は対象にならないのでマージする
     * @return 配列
     */
    public function validationData()
    {
        if ($this->image) {
            return array_merge($this->request->all(), [
                'chat_room_id' => $this->chat_room_id,
                'image' => $this->image,
            ]);
        }

        return array_merge($this->request->all(), [
            'chat_room_id' => $this->chat_room_id
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
            'chat_room_id' => ['required', 'uuid', 'exists:chat_rooms,_id'],
            'is_hurry' => ['required', 'boolean'],
            'content_type' => ['required', Rule::in(['1', '2', '3', '4'])],
            'message' => ['required_if:content_type,1', 'string', 'between:1,500'],
            'stamp_id' => ['required_if:content_type,2', 'uuid', 'exists:stamp_groups,stamps'],
            'image' => ['required_if:content_type,3', 'image', 'mimes:jpeg,png,jpg,gif'],
            'video' => ['required_if:content_type,4', 'mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime']
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
