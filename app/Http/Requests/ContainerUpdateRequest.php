<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ContainerUpdateRequest extends FormRequest
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
            'code' => 'required',
            'fixed_asset_number' => 'nullable',
            'vendor_id' => 'required|exists:vendors,id',
            'buy_date' => 'nullable|date',
            'last_upgrade_vendor_id' => 'nullable|exists:vendors,id',
            'last_upgrade_date' => 'nullable|date',
            'last_maintenance_vendor_id' => 'nullable|exists:vendors,id',
            'last_maintenance_date' => 'nullable|date',
            'contract_id' => 'nullable|exists:contracts,id',
            'company_id' => 'required|exists:companies,id',
            'length' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'width' => 'nullable|numeric',
            'description' => 'nullable',
            'photos' => 'nullable|array',
            'container_status_id' => 'required|exists:container_statuses,id',
            'warranty_date_start' => 'nullable|date',
            'warranty_date_end' => 'nullable|date',
            'down_location_id' => 'nullable',
        ];
    }
}
