<?php

namespace App\Modules\Billing\Resources\Balance;

use App\Modules\Billing\Resources\InvoiceResource;

class InvoiceForBalanceResource extends InvoiceResource
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
            'uid' => 'invoice',
            'label' => 'Счет',
        ];
        $data['sort'] = strtotime($this->created_at);
        return $data;
    }
}
