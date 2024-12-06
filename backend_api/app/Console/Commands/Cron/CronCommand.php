<?php

namespace App\Console\Commands\Cron;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CronCommand extends Command
{
    /**
     * Имя и подпись консольной команды.
     *
     * @var string
     */
    protected $signature = 'cron:cron-start-actions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Команда для запуска по cron';

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
        echo 'Cron Action' . PHP_EOL;
        // todo удалить
        // CameraModel::updateAllCache();
        Artisan::call('camera:refresh-image');
    }
}
