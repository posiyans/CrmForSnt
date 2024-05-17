<?php

namespace App\Modules\AdvancedOptions\Validators;

use Illuminate\Foundation\Http\FormRequest;


class CreateAdvancedOptionsValueValidator extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'value' => [],
            'pattern_id' => [
                'number'
            ]
        ];
    }

}