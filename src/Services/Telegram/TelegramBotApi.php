<?php

namespace Services\Telegram;

use Illuminate\Support\Facades\Http;
use Services\Telegram\Exceptions\TelegramBotException;
use Throwable;

class TelegramBotApi implements TelegramBotApiContract
{
    const HOST = 'https://api.telegram.org/bot';
    const FORMAT_SEND_MESSAGE_URL = self::HOST . '%s/sendMessage';

    public static function fake(): TelegramBotApiFake
    {
        return app()->instance(
            TelegramBotApiContract::class,
            new TelegramBotApiFake()
        );
    }

    public static function sendMessage(string $token, int $chatId, string $text): bool
    {
        try {
            $response = Http::get(sprintf(self::FORMAT_SEND_MESSAGE_URL, $token), [
                'chat_id' => $chatId,
                'text' => $text,
            ])->throw()->json();

            return $response['ok'] ?? false;
        } catch (Throwable $th) {
            throw new TelegramBotException('sendMessage() crashed', 0, $th);

            // return false;
        }
    }
}
