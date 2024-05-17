<?php

namespace App\Modules\Receipt\Validators;

use App\Modules\Billing\Models\BillingInvoiceModel;
use Illuminate\Foundation\Http\FormRequest;

class GetReceiptForInvoiceValidator extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'invoice_id' => [
                'required',
                'exists:' . BillingInvoiceModel::class . ',id',
            ],
        ];
    }

}