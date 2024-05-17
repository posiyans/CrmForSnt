<?php

namespace App\Modules\Stead\Actions;

use App\Modules\Stead\Models\SteadModel;
use App\Modules\User\Models\UserModel;

/**
 * проверить возможность доступа к данным (счета,  платежи и пр.) участка
 */
class CheckAccessToStead
{

    private $stead;

    public function __construct(SteadModel $stead)
    {
        $this->stead = $stead;
    }

    public function forUser(UserModel $user)
    {
        $userSteads = $user->owner->steads;
        // пока доступ имеют только собственники участка
        foreach ($userSteads as $userStead) {
            if ($userStead->id == $this->stead->id) {
                return true;
            }
        }
        return throw new \Exception('Ошибка доступа');
    }


}
