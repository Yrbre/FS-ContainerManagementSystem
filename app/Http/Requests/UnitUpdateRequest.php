<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitUpdateRequest extends FormRequest
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
            // 'name' => 'required|string|unique:units,name|max:50',
            'name' => [
                'required',
                'string',
                'max:50',
                function ($attribute, $value, $fail) {
                    if ($this->unit->name != $value && $this->unit->where('name', $value)->exists()) {
                        $fail('Unit name already exists.');
                    }
                },
            ],
            'symbol' => 'nullable|string|max:50',
        ];
    }
}
