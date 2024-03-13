<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UpdateBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $slug = $this->input('slug') ?? $this->input('title');

        $this->merge([
            'slug' => Str::slug($slug),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $id = $this->route('blog')->id;

        return [
            'blog_category_id' => [
                'required',
                Rule::exists('blog_categories', 'id'),
            ],
            'account_id' => [
                'nullable',
                Rule::exists('accounts', 'id'),
            ],
            'title' => 'required|string',
            'slug' => [
                'required',
                'string',
                Rule::unique('blogs', 'slug')->ignore($id),
            ],
            'posted_on' => 'nullable|date_format:Y-m-d\TH:i:s',
            'posted_by' => 'nullable|string',
            'image' => [
                'nullable',
                File::image()->max(1024),
            ],
            'short_description' => 'required|string',
            'description' => 'required|string',
        ];
    }
}
