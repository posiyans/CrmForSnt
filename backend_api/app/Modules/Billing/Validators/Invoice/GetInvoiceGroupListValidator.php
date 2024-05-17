<?php

namespace App\Modules\Billing\Validators\Invoice;

use App\Modules\Rate\Models\RateGroupModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class GetInvoiceGroupListValidator extends FormRequest
{
    public function authorize()
    {
        return Auth::user()->ability('superAdmin', ['invoice-edit']);
    }

    public function rules()
    {
        return [
            'page' => [
                'numeric',
                'required'
            ],
            'limit' => [
                'numeric',
                'required'
            ],
            'rate_group_id' => [
                'nullable',
                'exists:' . RateGroupModel::class . ',id',
            ],
        ];
    }

    public function attributes()
    {
        return [];
    }


}