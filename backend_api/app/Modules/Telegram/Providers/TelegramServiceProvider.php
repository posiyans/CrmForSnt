<?php

namespace App\Modules\Telegram\Providers;

use App\Modules\Telegram\Repositories\TelegramRepository;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use NotificationChannels\Telegram\Telegram;
use NotificationChannels\Telegram\TelegramChannel;

class TelegramServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Telegram::class, static function () {
            return new Telegram(
                TelegramRepository::getBotToken(),
                app(HttpClient::class),
                config('services.telegram-bot-api.base_uri')
            );
        });

        Notification::resolved(static function (ChannelManager $service) {
            $service->extend('telegram', static function ($app) {
                return $app->make(TelegramChannel::class);
            });
        });
    }

}
