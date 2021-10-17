<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && is_admin(auth()->user());
    }

    public function messages()
    {
        return [
            'title.required' => __('validation.products.create.errors.required'), //'The product should contain a title',
            'title.min' => 'Title should be more than 5 symbols',
            'title.unique' => 'Title should be unique'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'min:5', 'unique:products'],
            'description' => ['required', 'string', 'min:20'],
            'short_description' => ['required', 'string', 'min:20', 'max:150'],
            'SKU' => ['required', 'min:2', 'unique:products'],
            'price' => ['required', 'numeric', 'min:1'],
            'discount' => ['required', 'numeric', 'max:90'],
            'in_stock' => ['required', 'numeric'],
            'thumbnail' => ['required', 'image:jpeg,png'],
            'images.*' => ['image:jpeg,png'],
            'category' => ['required', 'numeric']
        ];
    }
}
