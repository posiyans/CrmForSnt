<?php

namespace App\Modules\Receipt\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Billing\Classes\CheckAccessToInvoice;
use App\Modules\Billing\Models\BillingInvoiceModel;
use App\Modules\Pdf\Classes\PrimaryReceiptPdfClass;

/**
 * Получить квитанцию на счет
 */
class GetReceiptForInvoiceController extends Controller
{


    public function __construct()
    {
        $this->middleware('ability:superAdmin|owner,invoice-show|invoice-edit');
    }

    public function __invoke(BillingInvoiceModel $invoice)
    {
        try {
            (new CheckAccessToInvoice($invoice))->forUser();
            $pdf = PrimaryReceiptPdfClass::forInvoices($invoice, true);
            $pdf->render();
            $file_name = 'Квитанция_' . $invoice->id;
            $file_name .= $invoice->stead ? '_уч_' . $invoice->stead->number : '';
            $file_name .= '.pdf';
            return $pdf->response($file_name);
        } catch (\Exception $e) {
            return response(['status' => false, 'errors' => $e->getMessage()], 401);
        }
    }

}
