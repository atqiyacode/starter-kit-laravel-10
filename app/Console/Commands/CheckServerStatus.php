<?php

namespace App\Console\Commands;

use App\Jobs\SendTelegramMessage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Validator;
use function Laravel\Prompts\text;

class CheckServerStatus extends Command
{
    protected $signature = 'app:server-check {url?}';

    protected $description = 'Check if the server is online and send the status to Telegram.';

    public function handle()
    {
        $serverUrl = $this->argument('url') ?: text(
            label: 'What is Url link?',
            placeholder: 'https://example.com',
            default: 'https://',
        );

        $validator = Validator::make(['url' => $serverUrl], [
            'url' => 'required|url'
        ]);

        if ($validator->fails()) {
            $this->error('Invalid URL format.');
            return;
        }

        try {
            $response = Http::withOptions(['verify' => false])->get($serverUrl);
            $this->info("🕐 Please Wait ...");
            $this->info("------------------");

            if ($response->successful()) {
                $status = '🟢 Server is Online.';
                $this->sendStatusToTelegram($serverUrl, $status);
            } else {
                $status = '🔴 Server is offline.';
                $this->sendStatusToTelegram($serverUrl, $status);
            }
            $this->info("✅ Finish, Check Your Message");
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
