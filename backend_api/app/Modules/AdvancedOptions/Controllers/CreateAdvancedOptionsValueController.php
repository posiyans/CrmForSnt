<?php

namespace App\Modules\AdvancedOptions\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\AdvancedOptions\Actions\CheckPermissionForAdvancedOptions;
use App\Modules\AdvancedOptions\Actions\CreateAdvancedOptionsValueAction;
use App\Modules\AdvancedOptions\Models\AdvancedOptionsModel;
use App\Modules\AdvancedOptions\Validators\CreateAdvancedOptionsValueValidator;
use Auth;

/**
 * Добавить значение для опции
 *
 */
class CreateAdvancedOptionsValueController extends Controller
{

    public function __construct()
    {
        $this->middleware('ability:superAdmin,access-admin-panel');
    }

    public function __invoke(AdvancedOptionsModel $options, CreateAdvancedOptionsValueValidator $request)
    {
        try {
            $user = Auth::user();
            $className = $options->commentable_type;
            CheckPermissionForAdvancedOptions::forClass($className, $user);
            $className::findOrFail($request->parent_id); // проверям на наличие данной модели
            $value = (new CreateAdvancedOptionsValueAction($options, $request->parent_id))
                ->value($request->value)
                ->run();

            return response(['data' => $value]);
        } catch (\Exception $e) {
            return response(['errors' => $e->getMessage()], 450);
        }
    }


}
