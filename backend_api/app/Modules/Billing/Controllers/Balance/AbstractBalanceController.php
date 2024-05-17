<?php

namespace App\Modules\Billing\Controllers\Balance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


abstract class AbstractBalanceController extends Controller
{

    protected $stead_id = null;

    public function __construct()
    {
        $this->middleware('ability:superAdmin|owner,payment-edit|payment-show|invoice-edit|invoice-show|bookkeeping-show');
    }


    protected function checkAccess(Request $request)
    {
        $user = \Auth::user();
        $permissions = ['payment-edit', 'payment-show', 'invoice-edit', 'invoice-show', 'bookkeeping-show'];
        if ($user->ability('superAdmin', $permissions) || $user->owner->steads->where('id', $request->stead_id)->isNotEmpty()) {
            $this->stead_id = $request->stead_id;
        } else {
            throw new \Exception('Ошибка доступа');
        }
    }


}
