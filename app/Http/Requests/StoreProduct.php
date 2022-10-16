<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduct extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'product_name' =>'required|max:255',
            'price_after' =>'required|numeric',
        ];
    }
    public function messages()
    {
        return [
            'product_name.required' =>'من فضلك ادخل اسم المنتج ',
            'price_after.required' =>'من فضلك ادخل اسم المنتج '
        ];
    }
}
