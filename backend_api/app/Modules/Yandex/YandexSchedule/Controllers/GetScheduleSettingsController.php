<?php

namespace App\Modules\Yandex\YandexSchedule\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Yandex\YandexSchedule\Repositories\YandexScheduleRepository;
use Illuminate\Http\Request;


class  GetScheduleSettingsController extends Controller
{

    public function __construct()
    {
        $this->middleware('ability:superAdmin,access-admin-panel');
    }

    public function __invoke(Request $request)
    {
        $token = (new YandexScheduleRepository())->getApiKey();
        $to = (new YandexScheduleRepository())->getStationTo();
        $from = (new YandexScheduleRepository())->getStationFrom();

        return response(['token' => $token, 'to' => $to, 'from' => $from]);
    }

}
