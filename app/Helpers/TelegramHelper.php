<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class TelegramHelper
{
    public static function sendMessage(string $chatId, string $message): bool
    {
        $token = config('services.telegram.bot_token');

        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        $response = Http::post($url, [
            'chat_id' => $chatId,
            'text' => $message,
        ]);

        return $response->ok();
    }
}
