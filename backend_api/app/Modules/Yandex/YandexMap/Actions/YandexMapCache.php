<?php

namespace App\Modules\Yandex\YandexMap\Actions;

use Cache;


class  YandexMapCache
{

    public static function getCacheName()
    {
        return 'YandexMapCoordinates';
    }

    public static function getCacheTagName()
    {
        return 'yandex';
    }

    public static function clearCache()
    {
        $tag = self::getCacheTagName();
        Cache::tags([$tag])->flush();
    }


}
