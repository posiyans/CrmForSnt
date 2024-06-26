<?php

namespace App\Modules\Stead\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Stead\Actions\UpdateSteadFieldAction;
use App\Modules\Stead\Models\SteadModel;
use App\Modules\Stead\Validators\UpdateSteadInfoValidator;
use App\Modules\Yandex\YandexMap\Actions\YandexMapCache;


class UpdateSteadInfoController extends Controller
{

    public function __invoke(SteadModel $stead, UpdateSteadInfoValidator $request)
    {
        try {
            (new UpdateSteadFieldAction($stead))->field($request->field, $request->value)->run();
            $this->postUpdateAction();
            return $stead;
        } catch (\Exception $e) {
            return response(['errors' => $e->getMessage()], 450);
        }
    }


    private function postUpdateAction()
    {
        YandexMapCache::clearCache();
    }


}
