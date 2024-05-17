<?php

namespace App\Modules\Receipt\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Billing\Repositories\InvoiceRepository;
use App\Modules\Pdf\Classes\PrimaryReceiptPdfClass;
use App\Modules\Rate\Repositories\RateGroupRepository;
use App\Modules\Receipt\Validators\GetReceiptForSteadValidator;
use App\Modules\Stead\Models\SteadModel;

/**
 *
 * Получить квитанцию на участок
 */
class GetReceiptForSteadController extends Controller
{


    public function __invoke(SteadModel $stead, GetReceiptForSteadValidator $request)
    {
        try {
            $rate_group = (new RateGroupRepository())->byId($request->rate_group_id);
            $invoices = (new InvoiceRepository())->forStead($stead)->forRateGroup($rate_group)->paginate(1);
            if ($invoices->count() > 0) {
                $invoice = $invoices[0];
                return PrimaryReceiptPdfClass::forInvoices($invoice)->render()->response();
            }
        } catch (\Exception $e) {
        }
        return response(['status' => false, 'errors' => 'Счет не найден'], 450);
    }

}
