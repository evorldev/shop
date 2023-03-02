<?php

namespace Services\Telegram\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Services\Telegram\Exceptions\TelegramBotException;
use Services\Telegram\TelegramBotApi;

class TelegramBotApiWriteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected string $token,
        protected string $chatId,
        protected string $message
    ) {}

    public function handle()
    {
        try {
            TelegramBotApi::sendMessage(
                $this->token,
                $this->chatId,
                $this->message
            );
        } catch (TelegramBotException $e) {
            //TODO:
            // report();
        }
    }
}
