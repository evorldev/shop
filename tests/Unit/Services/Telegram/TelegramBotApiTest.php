<?php

namespace Tests\Unit\Services\Telegram;

use Illuminate\Support\Facades\Http;
use Services\Telegram\TelegramBotApi;
use Tests\TestCase;

class TelegramBotApiTest extends TestCase
{
    public function test_it_send_message_success()
    {
        Http::fake([
            TelegramBotApi::HOST . '*' => Http::response([
                'ok' => true,
            ])
        ]);

        $result = TelegramBotApi::sendMessage('', 1, 'Testing');

        $this->assertTrue($result);
    }
}
