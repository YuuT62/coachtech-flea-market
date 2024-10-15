<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DestinationRequest extends FormRequest
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
            'postcode' => ['required', 'string', 'regex:/^[0-9]{3}-[0-9]{4}$/', ],
            'address' => ['required', 'string', 'max:191', 'regex:@^(.{2,3}?[都道府県])(.+?郡.+?[町村]|.+?市.+?区|.+?[市区町村])(.+)@u'],
            'building' => ['string', 'max:191', 'nullable'],
        ];
    }

    public function messages(){
        return [
            'postcode.regex' => '郵便番号はXXX-XXXXの形式で入力してください。',
            'address.regex' => '都道府県、市区町村を入力してください。'
        ];
    }
}
