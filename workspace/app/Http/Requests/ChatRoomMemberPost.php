<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use App\Models\ChatRoom;

class ChatRoomMemberPost extends FormRequest
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
        $request = request();
        $this->room = ChatRoom::where('_id', $request->chat_room_id)->first();
        
        if(!$this->room){
            /* roomにエラーデータをセット */
            $this->room = [
                '_id' => 'uuid'
            ];
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
            'add_members' => ['required', 'array'],
            'add_members.*' => ['uuid', 'exists:members,_id', Rule::unique('chat_rooms', 'members._id')->where('_id', $this->room['_id'])],
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
