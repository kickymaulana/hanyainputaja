<?php

namespace App\Http\Requests;

class StoreAssetConditionRequest extends UppercaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['name' => ['required', 'string', 'max:100', 'unique:asset_conditions,name'], 'is_active' => ['sometimes', 'boolean']];
    }
}
