<?php

namespace App\Modules\Receipt\Validators;

use App\Modules\Rate\Models\RateGroupModel;
use Illuminate\Foundation\Http\FormRequest;

class GetReceiptForSteadValidator extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rate_group_id' => [
                'required',
                'exists:' . RateGroupModel::class . ',id',
            ]
        ];
    }

}