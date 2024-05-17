<?php

namespace App\Modules\Yandex\YandexSchedule\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Yandex\YandexSchedule\Classes\UpdateYandexScheduleSettingsClass;
use App\Modules\Yandex\YandexSchedule\Validators\YandexScheduleFieldValidator;
use Cache;

/**
 * Обновить настройки яндекс расписания
 */
class  UpdateScheduleSettingsController extends Controller
{

    public function __construct()
    {
        $this->middleware('ability:superAdmin,access-admin-panel');
    }

    public function __invoke(YandexScheduleFieldValidator $request)
    {
        return (new UpdateYandexScheduleSettingsClass($request->field))->value($request->value);
        Cache::tags('yandex_schedule')->flush();
        return response(['status' => true]);
    }

}
