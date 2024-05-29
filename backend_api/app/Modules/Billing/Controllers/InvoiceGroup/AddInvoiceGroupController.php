<?php

namespace App\Modules\Billing\Controllers\InvoiceGroup;

use App\Http\Controllers\Controller;
use App\Modules\Billing\Actions\Invoice\CreateInvoiceAction;
use App\Modules\Billing\Actions\InvoiceGroup\CreateInvoiceGroupAction;
use App\Modules\Billing\Validators\Invoice\AddInvoiceGroupValidator;
use App\Modules\Stead\Repositories\SteadRepository;
use Illuminate\Support\Facades\DB;

/**
 * создать грууппу счетов
 *
 */
class AddInvoiceGroupController extends Controller
{

    public function __invoke(AddInvoiceGroupValidator $request)
    {
        try {
            DB::beginTransaction();
            $options = [
                'rate' => $request->rate,
                'steads' => $request->steads,
                'stead_type' => $request->stead_type,
                'invoice_date' => $request->invoice_date
            ];
            $steads = new SteadRepository();
            if ($request->stead_type == 'selected') {
                if (count($request->steads) == 0) {
                    throw new \Exception('Укажите хотя бы 1 участок');
                }
                $steads->findById($request->steads);
            }
            $steads = $steads->get();
            $invoiceGroup = (new CreateInvoiceGroupAction())
                ->title($request->title)
                ->rateGroup($request->rate_group_id)
                ->options($options)
                ->run();
            foreach ($steads as $stead) {
                CreateInvoiceAction::byInvoiceGroup($invoiceGroup, $stead);
            }

            if ($invoiceGroup->invoices->count() == 0) {
                throw new \Exception('Счет на оплату не выставлен');
            }
            DB::commit();
            return response([
                'data' =>
                    [
                        'total' => $invoiceGroup->invoices->count(),
                        'price' => round($invoiceGroup->invoices->sum('price'), 2),
                    ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response(['errors' => $e->getMessage()], 450);
        }
    }


}
