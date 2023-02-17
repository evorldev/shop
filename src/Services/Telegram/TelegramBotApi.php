<?php

namespace Services\Telegram;

use Illuminate\Support\Facades\Http;
use Services\Telegram\Exceptions\TelegramBotException;
use Throwable;

final class TelegramBotApi
{
    const FORMAT_SEND_MESSAGE_URL = 'https://api.telegram.org/bot%s/sendMessage';

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
