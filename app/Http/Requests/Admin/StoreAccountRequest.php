<?php

namespace App\Http\Requests\Admin;

use App\Helpers\ConstantHelper;
use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;

class StoreAccountRequest extends FormRequest
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
            'username' => 'nullable|string|max:255|alpha_dash|unique:accounts,username',
            'email' => 'required|email|unique:accounts,email',
            'phone' => 'nullable|string',
            'account_type' => 'required|string|in:Employer,Job Seeker',
            'gender' => 'nullable|string|in:Male,Female,Other',
            'date_of_birth' => 'nullable|date',
            'avatar_image' => [
                'nullable',
                File::image()->max(1024),
            ],
            'cover_image' => [
                'nullable',
                File::image()->max(1024),
            ],
            'is_public_profile' => 'required|in:0,1',
            'password' => ['required', 'string', Password::min(6)],
            'status' => 'nullable|string|in:Pending,Approved,Suspended',

            // Experience
            'experiences' => 'nullable|array',
            'experiences.*.company' => 'required|string',
            'experiences.*.position' => 'required|string',
            'experiences.*.from' => 'required|date',
            'experiences.*.to' => 'nullable|date',

            // Education
            'educations' => 'nullable|array',
            'educations.*.school' => 'required|string',
            'educations.*.degree' => 'required|string',
            'educations.*.from' => 'required|date',
            'educations.*.to' => 'nullable|date',

            'plugins' => 'nullable|array',
            'plugins.*' => 'in:' . implode(',', ConstantHelper::PLUGINS),
        ];
    }
}
