<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateMemoryRequest extends UppercaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['name' => ['required', 'string', 'max:100', Rule::unique('memories', 'name')->ignore($this->route('memory'))], 'is_active' => ['sometimes', 'boolean']];
    }
}
