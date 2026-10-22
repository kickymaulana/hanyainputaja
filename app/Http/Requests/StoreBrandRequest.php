<?php

namespace App\Http\Requests;

class StoreBrandRequest extends UppercaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['name' => ['required', 'string', 'max:100', 'unique:brands,name'], 'is_active' => ['sometimes', 'boolean']];
    }
}
