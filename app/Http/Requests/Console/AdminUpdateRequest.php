<?php

namespace App\Http\Requests\Console;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateRequest extends FormRequest
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
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                // // uniquer with function
                // function ($attribute, $value, $fail) {
                //     if($this->admin->email != $value && Admin::where('email', $value)->exists())
                //         $fail('Email already exists.');
                //     }

                ],
            'username' => [
                'required',
                'string',
                // uniquer with function
                function ($attribute, $value, $fail) {
                    if($this->admin->username != $value && Admin::where('username', $value)->exists())
                        $fail('Username already exists.');
                    }
                ],
            'password' => 'nullable|string|min:8',
            'confirm_password' => 'nullable|same:password',
            'role' => 'required',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];
    }
}
