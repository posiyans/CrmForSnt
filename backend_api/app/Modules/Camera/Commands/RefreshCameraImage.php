<?php

namespace App\Modules\Camera\Commands;

use App\Modules\Camera\Actions\RefreshCameraImageAction;
use Illuminate\Console\Command;

class RefreshCameraImage extends Command
{
    /**
     * Имя и подпись консольной команды.
     *
     * @var string
     */
    protected $signature = 'camera:refresh-image {camera_id? : id камеры если нужно одну }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновить изображение с камеры';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $camera_id = (int)$this->argument('camera_id');
        echo 'Обновление изображений с камер' . PHP_EOL;
        echo $camera_id . PHP_EOL;
        if ($camera_id) {
            echo 'Камера_ ' . $camera_id . PHP_EOL;
            $file = (new RefreshCameraImageAction($camera_id))->run();
            echo $file . PHP_EOL;
        } else {
            echo 'Все камеры' . PHP_EOL;
            RefreshCameraImageAction::all();
        }
    }
}
