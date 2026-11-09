<?php

namespace App\Http\Requests\Console;

use Illuminate\Foundation\Http\FormRequest;

class ContractCreateRequest extends FormRequest
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

        $rules = [
            'code' => 'required|string|max:255|unique:contracts,code',
            'vendor_id' => 'required|integer|exists:vendors,id',
            'type' => 'required|string',
            'status' => 'required|string',
            'subject' => 'required|string|max:255',
            'active_date_start' => 'required|date',
            'active_date_end' => [
                'required',
                'date',
                'after_or_equal:active_date_start'
            ],
            'warranty_date_start' => 'nullable|date',
            'warranty_date_end' => [
                'nullable',
                'date',
                'after_or_equal:warranty_date_start'
            ],
            'warranty_in_month' => 'nullable|integer',
            'warranty_in_days' => 'nullable|integer',
        ];
        
        if($this->request->has('upgrade_price')) {
            $rules['upgrade_price'] = 'required|integer';
        }

        return $rules;
    }
}
