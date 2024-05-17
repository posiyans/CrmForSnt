<?php

namespace App\Modules\AdvancedOptions\Validators;

use App\Modules\AdvancedOptions\Repositories\AdvancedOptionsObjectRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class AddAdvancedOptionsValidator extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string'
            ],
            'object' => [
                'required',
                Rule::in(AdvancedOptionsObjectRepository::getObjectName())
            ],
            'type_value' => [
                'required',
                Rule::in(AdvancedOptionsObjectRepository::getTypeName($this->object))
            ],
            'options' => [
                'array'
            ],
            'type' => [
                Rule::in(AdvancedOptionsObjectRepository::getTypeOptions($this->object))
            ]
        ];
    }

}