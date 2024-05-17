<?php

namespace App\Modules\Billing\Classes;

use App\Modules\Billing\Models\BillingInvoiceModel;
use App\Modules\Stead\Actions\CheckAccessToStead;
use App\Modules\User\Models\UserModel;

/**
 * Проверить возможность доступа к счету
 *
 */
class CheckAccessToInvoice
{
    private $invoice;

    public function __construct(BillingInvoiceModel $invoice)
    {
        $this->invoice = $invoice;
    }

    public function forUser(UserModel|null $user = null): bool
    {
        if (!$user) {
            $user = \Auth::user();
        }
        if ($user->ability('superAdmin', ['invoice-show', 'invoice-edit'])) {
            return true;
        }
        if ($user->hasRole('owner')) {
            return (new CheckAccessToStead($this->invoice->stead))->forUser($user);
        }
        throw  new \Exception('Ошибка доступа');
    }

}
