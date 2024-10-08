<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellRequest extends FormRequest
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
            'item_img' => ['required', 'image'],
            'category' => ['required', 'string' , 'max:191', 'regex:/^[^!"$%&=-~\|{}+:*?.\/#<>^;_]*$/'],
            'brand_name' => ['nullable', 'string' , 'max:191'],
            'condition' => ['required'],
            'item_name' => ['required', 'string' , 'max:191'],
            'description' => ['required', 'string' , 'max:191'],
            'price' => ['required', 'integer', 'min:120', 'max:9999999'],
        ];
    }

    public function messages(){
        return [
            'category.regex' => 'カテゴリーに特殊記号は使用できません。',
            'price.min' => '販売価格は、120円以上を指定してください。',
            'price.max' => '販売価格は、999万9999円以下を指定してください'
        ];
    }
}
