<?php

namespace App\Modules\AdvancedOptions\Validators;

use App\Modules\AdvancedOptions\Repositories\AdvancedOptionsObjectRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class GetAdvancedOptionsValidator extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'object' => [
                'required',
                Rule::in(AdvancedOptionsObjectRepository::getObjectName())
            ],
            'type' => [
                Rule::in(AdvancedOptionsObjectRepository::getTypeOptions($this->object))
            ]
        ];
    }

}