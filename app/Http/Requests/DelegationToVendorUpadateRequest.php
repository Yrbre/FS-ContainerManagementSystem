<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DelegationToVendorUpadateRequest extends FormRequest
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
            'location_id' => 'required|exists:locations,id',
            'contract_id' => 'required|exists:contracts,id',
            'vendor_id' => 'required|exists:vendors,id',
            'action_date' => 'required|date',
            'job_type' => 'required|string'
        ];
    }
}
