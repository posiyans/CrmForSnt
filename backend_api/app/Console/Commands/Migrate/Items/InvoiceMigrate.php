<?php

namespace App\Console\Commands\Migrate\Items;

use App\Models\MyModel;
use App\Modules\Stead\Models\SteadModel;
use Illuminate\Support\Facades\DB;

/**
 * конвертация счетов и платежей
 *
 */
class InvoiceMigrate
{

    public static function run()
    {
        echo 'конвертация счетов и платежей' . PHP_EOL;
        $invoice_groups = DB::connection('mysql_old')->table('billing_reestrs')->get();
        foreach ($invoice_groups as $item) {
            $fields = ['id', 'title', 'user_id', 'created_at', 'updated_at', 'deleted_at'];
            $newItem = new BillingInvoiceGroupModel();
            foreach ($fields as $key) {
                $newItem->$key = $item->$key;
            }
            $newItem->rate_group_id = $item->type;
            $newItem->options = json_decode($item->options, false);
            $newItem->save();
        }

        $invoices = DB::connection('mysql_old')->table('billing_invoices')->get();
        foreach ($invoices as $item) {
            $fields = ['id', 'title', 'price', 'user_id', 'created_at', 'updated_at', 'deleted_at'];
            $newItem = new BillingInvoiceModel();
            foreach ($fields as $key) {
                $newItem->$key = $item->$key;
            }

            $newItem->commentable_id = $item->stead_id;
            $newItem->commentable_type = SteadModel::class;
            $newItem->rate_group_id = $item->type;
            $newItem->invoice_group_id = $item->reestr_id;
            $newItem->is_paid = $item->paid;
            $newItem->options = ['description' => $item->description];
            $newItem->save();
        }

        $payments = DB::connection('mysql_old')->table('billing_payments')->get();
        foreach ($payments as $item) {
            $fields = ['id', 'description', 'price', 'payment_date', 'user_id', 'payment_type', 'raw_data', 'invoice_id', 'error', 'created_at', 'updated_at', 'deleted_at'];
            $newItem = new BillingPaymentModel();
            foreach ($fields as $key) {
                $newItem->$key = $item->$key;
            }
            $newItem->commentable_id = $item->stead_id;
            $newItem->commentable_type = SteadModel::class;
            $newItem->rate_group_id = $item->type;
            $newItem->save();
        }
    }
}

class BillingInvoiceGroupModel extends MyModel
{
    public $timestamps = false;
    protected $casts = [
        'options' => 'array',
    ];
}

class BillingInvoiceModel extends MyModel
{

    protected $casts = [
        'paid' => 'boolean',
        'price' => 'decimal:2',
        'options' => 'array',
    ];
    public $timestamps = false;
}

class BillingPaymentModel extends MyModel
{
    public $timestamps = false;

    protected $casts = [
        'error' => 'boolean',
        'price' => 'decimal:2',
    ];
}