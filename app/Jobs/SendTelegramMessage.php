<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendTelegramMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;
    protected $chatId;

    public function __construct($message, $chatId)
    {
        $this->message = $message;
        $this->chatId = $chatId;
    }

    public function handle()
    {
        try {
            $response = Http::post(env('TELEGRAM_API_URL', 'https://api.telegram.org') . '/bot' . env('TELEGRAM_BOT_TOKEN') . '/sendMessage', [
                'chat_id' => $this->chatId,
                'text' => $this->message,
                'parse_mode' => 'HTML'
            ]);

            if ($response->successful()) {
                Log::info('Telegram message sent successfully: ' . $this->message);
            } else {
                Log::error('Failed to send Telegram message: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Error sending Telegram message: ' . $e->getMessage());
        }
    }
}
