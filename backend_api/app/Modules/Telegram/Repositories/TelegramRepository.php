<?php

namespace App\Modules\Telegram\Repositories;

use App\Modules\Setting\Actions\GetGlobalOption;

class TelegramRepository
{
    public static function getOptionsName()
    {
        return 'telegram_token';
    }

    public static function getBotToken()
    {
        return GetGlobalOption::getOneValue(self::getOptionsName(), '');
    }


}