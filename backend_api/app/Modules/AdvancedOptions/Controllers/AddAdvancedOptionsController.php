<?php

namespace App\Modules\AdvancedOptions\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\AdvancedOptions\Actions\CheckPermissionForAdvancedOptions;
use App\Modules\AdvancedOptions\Actions\CreateAdvancedOptionsAction;
use App\Modules\AdvancedOptions\Validators\AddAdvancedOptionsValidator;
use Auth;

/**
 * добавить опцию
 *
 */
class AddAdvancedOptionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('ability:superAdmin,access-admin-panel');
    }

    public function __invoke(AddAdvancedOptionsValidator $request)
    {
        try {
            $user = Auth::user();
            CheckPermissionForAdvancedOptions::forObject($request->object, $user);
            $advancedOptions = (new CreateAdvancedOptionsAction())
                ->fill($request->validated())
                ->object($request->object)
                ->run();
            return response(['data' => $advancedOptions]);
        } catch (\Exception $e) {
            return response(['errors' => $e->getMessage()], 450);
        }
    }


}
