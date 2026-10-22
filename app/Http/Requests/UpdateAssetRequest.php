<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAssetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $asset = $this->route('asset');

        return [
            'asset_code' => ['required', 'string', 'max:100', Rule::unique('assets', 'asset_code')->ignore($asset)],
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')->where('is_active', true)],
            'description' => ['required', 'string', 'max:2000'],
            'location_id' => ['required', 'integer', Rule::exists('locations', 'id')->where('is_active', true)],
            'factory_id' => ['nullable', 'integer', Rule::exists('factories', 'id')->where('is_active', true)],
            'department_id' => ['required', 'integer', Rule::exists('departments', 'id')->where('is_active', true)],
            'user_name' => ['nullable', 'string', 'max:150'],
            'user_position' => ['nullable', 'string', 'max:150'],
            'position_id' => ['nullable', 'integer', Rule::exists('positions', 'id')->where('is_active', true)],
            'asset_status_id' => ['required', 'integer', Rule::exists('asset_statuses', 'id')->where('is_active', true)],
            'asset_condition_id' => ['required', 'integer', Rule::exists('asset_conditions', 'id')->where('is_active', true)],
            'serial_number' => ['nullable', 'string', 'max:150'],
            'brand' => ['nullable', 'string', 'max:100'],
            'acquisition_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
