<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use App\Models\StampGroup;

class StampGroupPut extends FormRequest
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
        $this->stamp_group = StampGroup::where('_id', $this->stamp_group)->first();
        
        if(!$this->stamp_group){
            /* エラーデータをセット */
            $this->stamp_group = [
                '_id' => 'uuid'
            ];
        }

        return array_merge($this->request->all(), [
            'stamp_group_id' => $this->stamp_group['_id']
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
            'stamp_group_id' => ['required', 'uuid', 'exists:stamp_groups,_id'],
            'add_members' => ['array'],
            'add_members.*' => ['uuid', 'exists:members,_id', Rule::unique('stamp_groups', 'members')->where('_id', $this->stamp_group['_id'])],
            'add_stamps' => ['array'],
            'add_stamps.*' => ['image', 'mimes:jpeg,png,jpg,gif'], 
            'remove_members' => ['array'],
            'remove_members.*' => ['uuid', 'exists:members,_id'],
            'remove_stamps' => ['array'],
            'remove_stamps.*' => ['uuid', Rule::exists('stamp_groups', 'stamps')->where('_id', $this->stamp_group['_id'])]
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
