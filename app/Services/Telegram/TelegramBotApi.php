<?php

namespace App\Services\Telegram;

use Exception;
use Illuminate\Support\Facades\Http;

final class TelegramBotApi
{
    public const HOST = 'https://api.telegram.org/bot';

    public static function sendMessage(string $token, int $chatId, string $text): bool
    {
        try {
            $response = Http::get(self::HOST . $token . '/sendMessage', [
                'chat_id' => $chatId,
                'text' => $text,
            ])->json();

            if ($response['ok'] === true) {
                return true;
            }

            throw new Exception($response['description'], $response['error_code']);
        } catch (Exception $e) {
            logger()
                ->channel('single')
                ->error('TelegramBotApi::sendMessage: [' . $e->getCode() . '] ' . $e->getMessage());

            return false;
        }
    }
}
