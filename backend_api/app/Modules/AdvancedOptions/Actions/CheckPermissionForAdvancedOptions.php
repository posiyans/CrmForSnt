<?php

namespace App\Modules\AdvancedOptions\Actions;

use App\Modules\AdvancedOptions\Controllers\Auth;
use App\Modules\AdvancedOptions\Repositories\AdvancedOptionsObjectRepository;
use App\Modules\User\Models\UserModel;

/**
 * добавить опцию
 *
 */
class CheckPermissionForAdvancedOptions
{


    public static function forObject($objectName, UserModel $user)
    {
        $permission = AdvancedOptionsObjectRepository::getTypePermissions($objectName);
        if ($user->ability('superAdmin', $permission)) {
            return true;
        }
        return throw new \Exception('Ошибка доступа');
    }

    public static function forClass($className, UserModel $user)
    {
        $objectName = AdvancedOptionsObjectRepository::getObjectByClassName($className);
        return self::forObject($objectName, $user);
    }

}
