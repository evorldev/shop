<?php

namespace Services\Telegram;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Services\Telegram\Exceptions\TelegramBotException;

class TelegramHandler extends AbstractProcessingHandler
{
    protected string $token;
    protected int $chatId;

    public function __construct(string $token, int $chatId, $level = Logger::DEBUG, bool $bubble = true)
    {
        parent::__construct($level, $bubble);

        $this->token = $token;
        $this->chatId = $chatId;
    }

    protected function write(array $record): void
    {
        if (! app()->isProduction()) {
            return;
        }

        try {
            TelegramBotApi::sendMessage(
                $this->token,
                $this->chatId,
                $record['formatted']
            );
        } catch (TelegramBotException $e) {
            // report();
        }
    }
}
