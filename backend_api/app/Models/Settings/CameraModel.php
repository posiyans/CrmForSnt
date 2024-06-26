<?php

namespace App\Models\Settings;

use App\Modules\Setting\Models\GlobalOptionModel;
use Illuminate\Support\Facades\Cache;

class CameraModel
{
    public $id;
    public $url;
    public $name;
    public $ttl;
    static protected $cache_prefix = 'Camera_image_id_';


    public function __construct($option)
    {
        $this->id = $option['id'];
        $this->url = $option['value']['url'] ?? '';
        $this->name = $option['value']['name'] ?? '';
        $this->ttl = (int)$option['value']['ttl'] ?? 3600;
        $this->access = $option['value']['access'] ?? 'all';
        $this->cache_name = static::$cache_prefix . $this->id;
        // $this->img = $this->updateCache();
    }

    public static function getListForUser()
    {
        $camers = self::getAllCamers();
        $data = [];
        foreach ($camers as $camera) {
            $data[] = [
                'id' => $camera->id,
                'name' => $camera->name
            ];
        }
        return $data;
    }

    public static function find($id)
    {
        $optionName = 'siteCameraSetting';
        $item = GlobalOptionModel::where('id', $id)->where('name', $optionName)->first();
        if ($item) {
            return new CameraModel($item);
        }
        return false;
    }

    public function getImgPath()
    {
        return $this->updateCache();
    }

    public function save()
    {
        $optionName = 'siteCameraSetting';
        if ($this->id) {
            $item = GlobalOptionModel::where('id', $this->id)->where('name', $optionName)->first();
            if ($item) {
                $item->value = $this;
                Cache::tags('Camera')->forget($this->cache_name);
                return $item->save();
            }
        }

        return false;
    }

    public static function getImagePath($id)
    {
        $cache_name = static::$cache_prefix . $id;
        return Cache::get($cache_name, false);
    }

    public static function getAllCamers()
    {
        $optionName = 'siteCameraSetting';
        $items = GlobalOptionModel::getOptionList($optionName);
        $data = [];
        foreach ($items as $item) {
            $data[] = new CameraModel($item);
        }
        return $data;
    }

    public static function updateAllCache($force = false)
    {
        $camers = self::getAllCamers();
        foreach ($camers as $camer) {
            $camer->updateCache($force);
        }
    }

    public function updateCache($force = false)
    {
        if ($force) {
            Cache::tags('Camera')->forget($this->cache_name);
        }
        $cache = $this->getCache();
        if ($cache) {
            return $cache;
        }
        return Cache::tags('Camera')->remember($this->cache_name, $this->ttl, function () {
            $file = $this->rtspToJpeg();
            return $file;
        });
    }


    public function getCache()
    {
        if (Cache::tags('Camera')->has($this->cache_name)) {
            return Cache::tags('Camera')->get($this->cache_name);
        }
        return false;
    }


}
