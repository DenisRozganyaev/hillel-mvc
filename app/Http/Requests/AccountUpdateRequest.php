<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => ['required', 'string', 'min:2'],
            "surname" => ['required', 'string', 'min:3'],
            "email" => ['required', 'email'],
            "phone" => ['required', 'string', 'min:2'],
            "birthdate" => ['required', 'date', 'min:2'],
            "balance" => ['required', 'numeric'],
        ];
    }
}
