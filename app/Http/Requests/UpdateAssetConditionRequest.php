<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAssetConditionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['name' => ['required', 'string', 'max:100', Rule::unique('asset_conditions', 'name')->ignore($this->route('asset_condition'))], 'is_active' => ['sometimes', 'boolean']];
    }
}
