<?php

namespace App\Modules\Yandex\YandexSchedule\Classes;


use App\Modules\Setting\Actions\SetGlobalOption;
use App\Modules\Yandex\YandexSchedule\Repositories\YandexScheduleRepository;

class UpdateYandexScheduleSettingsClass
{

    private $field;

    public function __construct($filed)
    {
        $this->field = $filed;
    }

    public function value($value)
    {
        $keyname = (new YandexScheduleRepository())->getOptionName($this->field);
        return SetGlobalOption::setOneValue($keyname, $value);
    }


}
