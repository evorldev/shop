<?php
 
namespace App\Logging\Telegram;

use App\Services\Telegram\TelegramBotApi;
use Monolog\Handler\AbstractProcessingHandler;
 
class TelegramLoggerHandler extends AbstractProcessingHandler
{
    protected string $token;

    protected int $chatId;

    public function __construct(array $config)
    {
        parent::__construct($config['level']);

        $this->token = $config['token'];
        $this->chatId = (int) $config['chat_id'];
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
