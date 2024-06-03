<?php

namespace App\Modules\Stead\Validators;

use Illuminate\Foundation\Http\FormRequest;


class GetSteadListValidator extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'find' => [
                'string',
                'nullable'
            ],
            'steadsId' => [
                'array',
                'nullable'
            ],
            'page' => [
                'numeric',
                'nullable'
            ],
            'limit' => [
                'numeric',
                'nullable'
            ],
            'admin' => [
                'boolean'
            ],
            'xlsx' => [
                'nullable',
                'boolean'
            ]
        ];
    }


}