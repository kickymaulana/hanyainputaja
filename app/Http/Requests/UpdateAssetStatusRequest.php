<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAssetStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['name' => ['required', 'string', 'max:100', Rule::unique('asset_statuses', 'name')->ignore($this->route('asset_status'))], 'is_active' => ['sometimes', 'boolean']];
    }
}
