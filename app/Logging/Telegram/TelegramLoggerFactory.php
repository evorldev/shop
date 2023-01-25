<?php
 
namespace App\Logging\Telegram;

use Monolog\Logger;
 
final class TelegramLoggerFactory
{
    public function __invoke(array $config): Logger
    {
        $loger = new Logger('telegram');
        $loger->pushHandler(new TelegramLoggerHandler($config));

        return $loger;
    }
}
