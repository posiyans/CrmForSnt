<?php

namespace App\Modules\Yandex\YandexSchedule\Repositories;


use App\Modules\Setting\Actions\GetGlobalOption;
use Illuminate\Support\Facades\Log;

class YandexScheduleRepository
{

    private $optionName = 'yandex_schedule';


    public function getApiKey()
    {
        return GetGlobalOption::getOneValue($this->getApiKeyOptionName(), '');
    }

    public function getStationTo()
    {
        return GetGlobalOption::getOneValue($this->getStationToOptionName(), '');
    }

    public function getStationFrom()
    {
        return GetGlobalOption::getOneValue($this->getStationFromOptionName(), '');
    }

    public function getOptionName($field)
    {
        switch ($field) {
            case 'apiKey':
                return $this->getApiKeyOptionName();
            case 'to':
                return $this->getStationToOptionName();
            case 'from':
                return $this->getStationFromOptionName();
            default:
                Log::error('yandex schedule no find Field ' . $field);
        }
    }

    public function getApiKeyOptionName()
    {
        return $this->optionName . '_api_key';
    }

    public function getStationFromOptionName()
    {
        return $this->optionName . '_from';
    }

    public function getStationToOptionName()
    {
        return $this->optionName . '_to';
    }
}