<?php

namespace App\Http\Requests\Console;

use Illuminate\Foundation\Http\FormRequest;

class VendorUpdateRequest extends FormRequest
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
            'erp_code' => [
                'required',
                'string',
                function($attribute, $value, $fail) {
                    if($this->vendor->erp_code != $value && $this->vendor->where('erp_code', $value)->exists()) {
                        $fail('Kode ERP sudah digunakan.');
                    }
                }
            ],
            'name' => 'required|string',
            'address_1' => 'required|string',
            'address_2' => 'nullable|string',
            'address_3' => 'nullable|string',
        ];
    }
}
