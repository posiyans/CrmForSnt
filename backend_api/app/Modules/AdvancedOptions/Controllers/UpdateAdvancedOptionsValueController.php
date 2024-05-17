<?php

namespace App\Modules\AdvancedOptions\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\AdvancedOptions\Actions\CheckPermissionForAdvancedOptions;
use App\Modules\AdvancedOptions\Actions\UpdateAdvancedOptionsValueAction;
use App\Modules\AdvancedOptions\Models\AdvancedOptionsValueModel;
use App\Modules\AdvancedOptions\Validators\CreateAdvancedOptionsValueValidator;
use Auth;

/**
 * Изменить значение для опции
 *
 */
class UpdateAdvancedOptionsValueController extends Controller
{

    public function __construct()
    {
        $this->middleware('ability:superAdmin,access-admin-panel');
    }

    public function __invoke(AdvancedOptionsValueModel $option, CreateAdvancedOptionsValueValidator $request)
    {
        try {
            $user = Auth::user();
            CheckPermissionForAdvancedOptions::forClass($option->advanced_options->commentable_type, $user);
            $value = (new UpdateAdvancedOptionsValueAction($option))->value($request->value)->run();
            return response(['data' => $value]);
        } catch (\Exception $e) {
            return response(['errors' => $e->getMessage()], 450);
        }
    }


}
