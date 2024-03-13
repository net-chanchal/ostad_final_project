<?php

namespace App\Http\Requests\Admin;

use App\Helpers\ConstantHelper;
use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class StoreJobAttributeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'type' => ['required', 'string', Rule::in(ConstantHelper::JOB_ATTRIBUTES_TYPE)]
        ];
    }
}
