<?php

namespace App\Modules\AdvancedOptions\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\AdvancedOptions\Actions\CheckPermissionForAdvancedOptions;
use App\Modules\AdvancedOptions\Repositories\AdvancedOptionsRepository;
use App\Modules\AdvancedOptions\Resources\AdvancedOptionsResource;
use App\Modules\AdvancedOptions\Validators\GetAdvancedOptionsValidator;
use Auth;

/**
 *
 * получить список доп опций для обьекта
 *
 */
class GetAdvancedOptionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('ability:superAdmin,access-admin-panel');
    }

    public function __invoke(GetAdvancedOptionsValidator $request)
    {
        try {
            $user = Auth::user();
            CheckPermissionForAdvancedOptions::forObject($request->object, $user);
            $objectName = $request->object;
            $type = $request->type ?? '';
            $options = (new AdvancedOptionsRepository())
                ->forObject($objectName, $type)
                ->get();
            return response(['data' => AdvancedOptionsResource::collection($options)]);
        } catch (\Exception $e) {
            return response(['errors' => $e->getMessage()], 450);
        }
    }


}
