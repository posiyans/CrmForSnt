<?php

namespace App\Modules\Rate\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Rate\Actions\DeleteRateTypeAction;
use App\Modules\Rate\Models\RateTypeModel;

/**
 * Удалить описание тарифа
 *
 */
class DeleteRateTypeController extends Controller
{

    public function __invoke(RateTypeModel $typeModel)
    {
        try {
            $rate = $typeModel->currentRate;
            if ($rate) {
                // todo сменить на проверку выставленных счетов по данному тарифу
                return response(['errors' => 'Нельзя удалить тариф со званачениями'], 450);
            }
            return (new DeleteRateTypeAction($typeModel))->run();
        } catch (\Exception $e) {
            return response(['errors' => $e->getMessage()], 450);
        }
    }

}
