<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'user_icon' => ['image','nullable'],
            'name' => ['required', 'string', 'max:191'],
            'postcode' => ['required', 'string', 'regex:/^[0-9]{3}-[0-9]{4}$/', ],
            'address' => ['required', 'string', 'max:191', 'regex:@^(.{2,3}?[都道府県])(.+?郡.+?[町村]|.+?市.+?区|.+?[市区町村])(.+)@u'],
            'building' => ['nullable', 'string', 'max:191'],
        ];
    }

    public function messages(){
        return [
            'user_icon.mimes' => '画像ファイルを選択してください。',
            'postcode.regex' => 'XXX-XXXXの形式で入力してください。',
            'address.regex' => '都道府県、市区町村を入力してください。'
        ];
    }
}
