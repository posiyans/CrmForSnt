<?php

namespace App\Modules\Billing\Controllers\Balance;

use App\Modules\Billing\Repositories\InvoiceRepository;
use App\Modules\Billing\Repositories\PaymentRepository;
use App\Modules\Billing\Resources\Balance\InvoiceForBalanceResource;
use App\Modules\Billing\Resources\Balance\PaymentForBalanceResource;
use App\Modules\Billing\Resources\PaymentAndInvoiceXlsxFileResource;
use App\Modules\Billing\Validators\Balance\GetPaymentAndInvoiceListValidator;

/**
 * получить список счетов и платежей
 *
 */
class GetPaymentAndInvoiceListController extends AbstractBalanceController
{


    public function __invoke(GetPaymentAndInvoiceListValidator $request)
    {
        try {
            $this->checkAccess($request);
            $page = $request->page;
            $limit = $request->limit;

            $result = collect();
            if (!$request->type || $request->type == 'invoice' || $request->type == 'group') {
                $result = $result->merge(
                    InvoiceForBalanceResource::collection(
                        (new InvoiceRepository())
                            ->forStead($this->stead_id)
                            ->forRateGroup($request->rate_group_id)
                            ->forDate($request->date_start, $request->date_end)
                            ->get()
                    )
                );
            }

            if (!$request->type || $request->type == 'payment' || $request->type == 'group') {
                $result = $result->merge(
                    PaymentForBalanceResource::collection(
                        (new PaymentRepository())
                            ->forStead($this->stead_id)
                            ->forRateGroup($request->rate_group_id)
                            ->forDate($request->date_start, $request->date_end)
                            ->get()
                    )
                );
            }

            $is_paid = $request->is_paid;

            if ($request->type == 'group') {
                $result = $result->filter(function ($value, $key) {
                    $typeUid = $value['type']['uid'];
                    if ($typeUid == 'payment') {
                        return !$value['invoice'];
                    } else {
                        return true;
                    }
                });
            }
            if ($is_paid) {
                $result = $result->filter(function ($value, $key) use ($is_paid) {
                    if ($is_paid == 'paid') {
                        return $value['is_paid'] === true;
                    } else {
                        return $value['is_paid'] === false;
                    }
                });
            }
            $result = $result->sortByDesc('sort')->values();


            if ($request->xlsx) {
                $tmpfname = tempnam(sys_get_temp_dir(), "balance_stead");
                (new PaymentAndInvoiceXlsxFileResource())->render($result, $tmpfname);
                return response()->download($tmpfname, 'Баланс_' . date("Y-m-d_H-i-s") . '.xlsx');
            } else {
                return [
                    'data' => $result->forPage($page, $limit)->values(),
                    'meta' => [
                        'total' => $result->count()
                    ]
                ];
            }
        } catch (\Exception $e) {
            return response(['errors' => $e->getMessage()], 450);
        }
    }


}
