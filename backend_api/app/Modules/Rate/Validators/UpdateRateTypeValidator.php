<?php

namespace App\Modules\Rate\Validators;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRateTypeValidator extends FormRequest
{


    public function authorize()
    {
        return Auth::user()->ability('superAdmin', ['rate-edit']);
    }


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
            'description' => [
                'required',
                'string'
            ],
        ];
    }

}