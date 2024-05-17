<?php

namespace App\Modules\AdvancedOptions\Validators;

use Illuminate\Foundation\Http\FormRequest;


class UpdateAdvancedOptionsValueValidator extends FormRequest
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
        ];
    }

}