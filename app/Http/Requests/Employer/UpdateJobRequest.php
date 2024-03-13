<?php

namespace App\Http\Requests\Employer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // job_posts
            'title' => 'required|string',
            'job_category_id' => [
                'required',
                Rule::exists('job_categories', 'id'),
                'integer'
            ],
            'vacancy' => 'required|integer',
            'deadline' => 'required|date',

            // job_post_salaries
            'min_salary' => 'required|integer',
            'max_salary' => 'nullable|integer',

            // job_post_locations
            'country_id' => [
                'nullable',
                Rule::exists('countries', 'id'),
            ],
            'state_id' => [
                'nullable',
                Rule::exists('states', 'id'),
            ],
            'city_id' => [
                'nullable',
                Rule::exists('cities', 'id'),
            ],

            // job_post_attributes
            'job_attributes.Experience' => ['required', Rule::exists('job_attributes', 'id')],
            'job_attributes.Job Role' => ['required', Rule::exists('job_attributes', 'id')],
            'job_attributes.Education' => ['required', Rule::exists('job_attributes', 'id')],
            'job_attributes.Job Type' => ['required', Rule::exists('job_attributes', 'id')],

            // job_post_attribute_others
            'job_attributes.tags' => 'nullable|string',
            'job_attributes.benefits' => 'nullable|string',
            'job_attributes.skills' => 'nullable|string',
        ];
    }
}
