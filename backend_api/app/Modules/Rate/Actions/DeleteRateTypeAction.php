<?php

namespace App\Modules\Rate\Actions;

use App\Modules\Rate\Models\RateTypeModel;

/**
 * Удалить описание тариф
 */
class DeleteRateTypeAction
{
    protected $rate_type;

    public function __construct(RateTypeModel $rate_type)
    {
        $this->rate_type = $rate_type;
    }


    public function run()
    {
        if ($this->rate_type->logAndDelete('Удаление тарифа')) {
            return true;
        }
        throw new \Exception('Ошибка удаления тарифа');
    }


}
