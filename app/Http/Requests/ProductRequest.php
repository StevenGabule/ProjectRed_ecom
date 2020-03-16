<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'category_id' => 'required',
            'name' => 'required|min:6',
            'price' => 'required',
            'qty' => 'required',
            'unit' => 'required',
            'short_description' => 'required|max:150',
            'full_description' => 'required|max:250',
            'product_avatar' => 'required|image'
        ];
    }
}
