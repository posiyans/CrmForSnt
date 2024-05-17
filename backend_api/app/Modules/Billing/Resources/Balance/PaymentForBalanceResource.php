<?php

namespace App\Modules\Billing\Resources\Balance;

use App\Modules\Billing\Resources\PaymentResource;

class PaymentForBalanceResource extends PaymentResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);

        $data['type'] = [
            'uid' => 'payment',
            'label' => 'Платеж',
        ];
        $data['invoice'] = $this->invoice ? [
            'id' => $this->invoice->id
        ] : null;
        $data['title'] = $this->raw_data[4];
        $data['sort'] = strtotime($this->payment_date);
        $data['is_paid'] = $this->invoice ? $this->invoice->is_paid : false;
        return $data;
    }
}
