<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'customer_name' => 'required|max:80',
            'customer_email' => 'required|max:120|email',
            'customer_mobile' => 'required|digits_between:4,15|numeric',
            'product_id' => 'required|integer',
            'price' => 'required|numeric',
        ];
    }
}
