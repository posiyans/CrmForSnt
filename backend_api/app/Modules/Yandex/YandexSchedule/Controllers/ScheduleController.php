<?php

namespace App\Modules\Yandex\YandexSchedule\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Yandex\YandexSchedule\Repositories\YandexScheduleRepository;
use Cache;
use Illuminate\Http\Request;


class  ScheduleController extends Controller
{

    public function __invoke(Request $request)
    {
        $token = (new YandexScheduleRepository())->getApiKey();
        if ($token) {
            $data = date('Y-m-d');
            if (isset($request->type)) {
                if ($request->type == 1) {
                    $tomorrow = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
                    $data = date('Y-m-d', $tomorrow);
                }
                if ($request->type == 2) {
                    $data = false;
                }
            }
            $back = false;
            $key = 'yandexRasp' . $data;
            if (isset($request->back) && $request->back === 'true') {
                $back = true;
                $key = 'yandexRasp' . $data . '_';
            }
            $result = Cache::tags('yandex_schedule')->remember($key, 3600, function () use ($data, $back) {
                $token = (new YandexScheduleRepository())->getApiKey();
                $st1 = (new YandexScheduleRepository())->getStationTo();
                $st2 = (new YandexScheduleRepository())->getStationFrom();
                if ($token && $st1 && $st2) {
                    if ($back) {
                        $from = $st2;
                        $to = $st1;
                    } else {
                        $from = $st1;
                        $to = $st2;
                    }
                    $url = 'https://api.rasp.yandex.net/v3.0/search/?format=json&lang=ru_RU&page=1&transport_types=suburban';
                    if ($data) {
                        $url .= '&date=' . $data;
                    }
                    $url .= '&apikey=' . $token;
                    $url .= '&from=' . $from;
                    $url .= '&to=' . $to;
                    return file_get_contents($url);
                }
                return false;
            });
            return response($result);
        }

        return response(['status' => false, 'errors' => 'Данный модуль не настроен'], 450);
    }

}
