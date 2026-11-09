<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigUpdateRequest extends FormRequest
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
            // 'name' => 'required|string|unique:configs,name|max:50',
            'name' => [
                'required',
                'string',
                'max:50',
                function ($attribute, $value, $fail) {
                    if ($this->config->name != $value && $this->config->where('name', $value)->exists()) {
                        $fail('Config name already exists.');
                    }
                },
            ],
            'status' => 'required',
        ];
    }
}
