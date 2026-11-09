<?php

namespace App\Http\Requests\Console;

use Illuminate\Foundation\Http\FormRequest;

class AdminCreateRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:admins',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|same:password',
            'role' => 'required',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];
    }
}
