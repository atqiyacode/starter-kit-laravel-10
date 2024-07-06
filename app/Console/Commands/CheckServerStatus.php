<?php

namespace App\Console\Commands;

use App\Jobs\SendTelegramMessage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CheckServerStatus extends Command
{
    protected $signature = 'app:server-check';

    protected $description = 'Check if the server is online and send the status to Telegram.';

    public function handle()
    {

        $serverUrl = 'https://ibr.tricitta.co.id'; // Replace with your server URL

        try {
            $response = Http::withOptions(['verify' => false])->get($serverUrl);

            if ($response->successful()) {
                $status = '🔴 Server is offline.';
                $this->sendStatusToTelegram($serverUrl, $status);
            } else {
                $status = '🟢 Server is Online.';
                $this->sendStatusToTelegram($serverUrl, $status);
            }
        } catch (\Exception $e) {
            $status = 'Error checking server status: ' . $e->getMessage();
        }
    }

    private function sendStatusToTelegram($serverUrl, $status)
    {
        $message = $status . " : <b>" . $serverUrl . "</b> ";

        SendTelegramMessage::dispatch($message, env('TELEGRAM_BOT_USER'));
    }
}
