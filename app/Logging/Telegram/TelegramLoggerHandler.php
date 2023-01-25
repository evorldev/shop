<?php
 
namespace App\Logging\Telegram;

use App\Services\Telegram\TelegramBotApi;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
 
class TelegramLoggerHandler extends AbstractProcessingHandler
{
    protected string $token;

    protected int $chatId;

    public function __construct(array $config)
    {
        $level = Logger::toMonologLevel($config['level']);

        parent::__construct($level);

        $this->token = $config['token'];
        $this->chatId = $config['chat_id'];
    }

    protected function write(array $record): void
    {
        TelegramBotApi::sendMessage(
            $this->token,
            $this->chatId,
            $record['formatted']
        );
    }
}
