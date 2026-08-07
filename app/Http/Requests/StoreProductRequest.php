<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'name' => 'required|string|max:255',

            'description' => 'nullable|string',

            'price' => 'required|numeric|min:1',

            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        ];
    }

    public function messages(): array
    {
        return [

            'name.required' => 'Product name is required.',

            'price.required' => 'Price is required.',

            'price.numeric' => 'Price must be numeric.',

            'price.min' => 'Price must be greater than zero.',

        ];
    }
}
