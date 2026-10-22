<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateProcessorRequest extends UppercaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['name' => ['required', 'string', 'max:100', Rule::unique('processors', 'name')->ignore($this->route('processor'))], 'is_active' => ['sometimes', 'boolean']];
    }
}
