<?php

namespace App\Modules\Telegram\vendor\Monolog\Handler;

use Monolog\Handler\Curl;
use Monolog\Handler\MissingExtensionException;
use Monolog\Handler\TelegramBotHandler as TelegramBotHandlerOriginal;
use Monolog\Logger;
use RuntimeException;

class TelegramBotHandler extends TelegramBotHandlerOriginal
{
    protected const BOT_API = 'https://api.telegram.org/bot';
    protected $apiKey;
    protected $channel;
    protected $parseMode;

    /**
     * Disables link previews for links in the message.
     * @var ?bool
     */
    protected $disableWebPagePreview;

    /**
     * Sends the message silently. Users will receive a notification with no sound.
     * @var ?bool
     */
    protected $disableNotification;

    private $reply_to_message_id;


    public function __construct(
        string $apiKey,
        string $channel,
        string $reply_to_message_id = '',
        $level = Logger::DEBUG,
        bool $bubble = true,
        string $parseMode = null,
        bool $disableWebPagePreview = null,
        bool $disableNotification = null,
        bool $splitLongMessages = false,
        bool $delayBetweenMessages = false
    ) {
        if (!extension_loaded('curl')) {
            throw new MissingExtensionException('The curl extension is needed to use the TelegramBotHandler');
        }

        parent::__construct($level, $bubble);

        $this->apiKey = $apiKey;
        $this->channel = $channel;
        $this->setParseMode($parseMode);
        $this->disableWebPagePreview($disableWebPagePreview);
        $this->disableNotification($disableNotification);
        $this->splitLongMessages($splitLongMessages);
        $this->delayBetweenMessages($delayBetweenMessages);
        $this->reply_to_message_id = $reply_to_message_id;
    }

    protected function sendCurl(string $message): void
    {
//        dd($this->replay_to_message);

        $ch = curl_init();
        $url = self::BOT_API . $this->apiKey . '/SendMessage';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            http_build_query([
                'text' => $message,
                'chat_id' => $this->channel,
                'reply_to_message_id' => $this->reply_to_message_id,
                'parse_mode' => $this->parseMode,
                'disable_web_page_preview' => $this->disableWebPagePreview,
                'disable_notification' => $this->disableNotification,
            ])
        );

        $result = Curl\Util::execute($ch);
        if (!is_string($result)) {
            throw new RuntimeException('Telegram API error. Description: No response');
        }
        $result = json_decode($result, true);

        if ($result['ok'] === false) {
            throw new RuntimeException('Telegram API error. Description: ' . $result['description']);
        }
    }

}
