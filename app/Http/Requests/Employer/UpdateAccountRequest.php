<?php

namespace App\Http\Requests\Employer;

use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;

class UpdateAccountRequest extends FormRequest
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
        $accountId = Auth::guard('account')->id();

        return [
            'name' => 'required|string',
            'username' => 'nullable|string|max:255|alpha_dash|unique:accounts,username,' . $accountId,
            'phone' => 'nullable|string',
            'avatar_image' => [
                'nullable',
                File::image()->max(1024),
            ],
            'cover_image' => [
                'nullable',
                File::image()->max(1024),
            ],
            'is_public_profile' => 'required|in:0,1',
            'password' => [
                'nullable',
                'string',
                Password::min(6),
                'confirmed',
            ],
        ];
    }
}
