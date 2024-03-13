<?php

namespace App\Http\Requests;

use App\Helpers\CoreHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;
use Illuminate\Validation\ValidationException;

class FormRequest extends BaseFormRequest
{
    /**
     * @param Validator $validator
     * @return mixed
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator): ValidationException
    {
        $errors = $validator->errors();
        $response = null;

        if ($errors->isNotEmpty()) {
            $errorText = '&#x2022;&nbsp;' . implode('<br>&#x2022;&nbsp;', $errors->all());
            $response = redirect()
                ->back()
                ->with('message', CoreHelper::error($errorText))
                ->withInput();
        }

        throw (new ValidationException($validator, $response))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}