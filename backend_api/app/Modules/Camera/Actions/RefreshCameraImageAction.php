<?php

namespace App\Modules\Camera\Actions;

use App\Modules\Camera\Repositories\CameraRepository;
use Illuminate\Support\Facades\Cache;

/**
 * обновить картинку с камеры
 *
 */
class RefreshCameraImageAction
{
    private $camera_id;

    public function __construct($id)
    {
        $this->camera_id = $id;
    }

    /**
     * обновить принудительно сейчас
     *
     * @param $force
     * @return $this
     */
    public function force($force = true)
    {
        if ($force) {
            $cacheName = CameraRepository::getCacheName($this->camera_id);
            Cache::tags('Camera')->forget($cacheName);
        }
        return $this;
    }


    public function run()
    {
        $file = CameraRepository::getImagePath($this->camera_id);
        return $file;
    }


    public static function all($force = false)
    {
        $camers = (new CameraRepository())->all();
        foreach ($camers as $camera) {
            print_r($camera);
            (new RefreshCameraImageAction($camera->id))
                ->force($force)
                ->run();
        }
    }

}
