<?php

namespace App\Modules\Billing\Repositories;

use App\Modules\Billing\Models\BillingInvoiceModel;
use App\Modules\Stead\Models\SteadModel;

class InvoiceRepository
{

    private $query;

    public function __construct()
    {
        $this->query = BillingInvoiceModel::query();
    }

    /**
     * @param $id
     * @return \App\Modules\Billing\Models\BillingInvoice|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function byId($id)
    {
        return $this->query->where('id', $id)->firstOrFail();
    }

    public function forStead($stead_id = false)
    {
        if ($stead_id) {
            if (is_object($stead_id)) {
                $stead_id = $stead_id->id;
            }
            $this->query->where('commentable_type', SteadModel::class)->where('commentable_id', $stead_id);
        }
        return $this;
    }

    public function forRateGroup($group_id = false)
    {
        if ($group_id) {
            if (is_object($group_id)) {
                $group_id = $group_id->id;
            }
            $this->query->where('rate_group_id', $group_id);
        }
        return $this;
    }

    public function isPaid($isPaid = 1)
    {
        if ($isPaid === '1') {
            $this->query->where('is_paid', true);
        } elseif ($isPaid == '0') {
            $this->query->where('is_paid', false);
        }
        return $this;
    }

    public function forDate($date_start, $date_end)
    {
        if ($date_start) {
            $this->query->where('created_at', '>=', $date_start);
        }
        if ($date_end) {
            $this->query->where('created_at', '<=', $date_end);
        }
        return $this;
    }


    public function paginate($limit)
    {
        return $this->query
            ->orderBy('id', 'DESC')
            ->paginate($limit);
    }

    public function get()
    {
        return $this->query
            ->orderBy('id', 'DESC')
            ->get();
    }


}