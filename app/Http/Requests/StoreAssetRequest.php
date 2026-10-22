<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class StoreAssetRequest extends UppercaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')->where('is_active', true)],
            'description' => ['required', 'string', 'max:2000'],
            'location_id' => ['required', 'integer', Rule::exists('locations', 'id')->where('is_active', true)],
            'department_id' => ['required', 'integer', Rule::exists('departments', 'id')->where('is_active', true)],
            'brand_id' => ['nullable', 'integer', Rule::exists('brands', 'id')->where('is_active', true)],
            'processor_id' => ['nullable', 'integer', Rule::exists('processors', 'id')->where('is_active', true)],
            'memory_id' => ['nullable', 'integer', Rule::exists('memories', 'id')->where('is_active', true)],
            'user_name' => ['nullable', 'string', 'max:150'],
            'position_id' => ['nullable', 'integer', Rule::exists('positions', 'id')->where('is_active', true)],
            'asset_condition_id' => ['required', 'integer', Rule::exists('asset_conditions', 'id')->where('is_active', true)],
            'serial_number' => ['nullable', 'string', 'max:150'],
            'acquisition_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
