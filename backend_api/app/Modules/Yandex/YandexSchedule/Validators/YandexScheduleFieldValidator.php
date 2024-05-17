<?php

namespace App\Modules\Yandex\YandexSchedule\Validators;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class YandexScheduleFieldValidator extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'value' => [
                'string',
                'nullable'
            ],
            'field' => [
                'required',
                Rule::in(['apiKey', 'to', 'from'])
            ]
        ];
    }

}