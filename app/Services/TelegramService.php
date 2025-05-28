<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TelegramService
{
    protected string $botToken;

    public function __construct()
    {
        $this->botToken = config('services.telegram.bot_token');
    }

    public function sendMessage(string $chatId, string $message): bool
    {
        //$url= "https://api.telegram.org/bot6050250438:AAFMUxeC57F7C9TxV5MBBLZDcKB7aUGXkgc/sendMessage?chat_id="
        $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";

        $response = Http::timeout(5) //max 5 segundos de espera
            ->retry(3, 1000) //intenta 3 veces con 1s de espera
            ->post($url, [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]);

        return $response->successful();
    }
}
