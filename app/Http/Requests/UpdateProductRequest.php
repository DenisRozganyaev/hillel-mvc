<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
        $productId = $this->route('product')->id;

        return [
            'title' => ['required', 'string', 'min:5', Rule::unique('products', 'title')->ignore($productId)],
            'description' => ['required', 'string', 'min:20'],
            'short_description' => ['required', 'string', 'min:20', 'max:150'],
            'SKU' => ['required', 'min:2', Rule::unique('products', 'SKU')->ignore($productId)],
            'price' => ['required', 'numeric', 'min:1'],
            'discount' => ['required', 'numeric', 'max:90'],
            'in_stock' => ['required', 'numeric'],
            'thumbnail' => ['nullable', 'image:jpeg,png'],
            'images.*' => ['image:jpeg,png'],
            'category_id' => ['required', 'numeric']
        ];
    }
}
