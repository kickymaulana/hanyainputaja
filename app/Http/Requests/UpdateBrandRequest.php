<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateBrandRequest extends UppercaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['name' => ['required', 'string', 'max:100', Rule::unique('brands', 'name')->ignore($this->route('brand'))], 'is_active' => ['sometimes', 'boolean']];
    }
}
