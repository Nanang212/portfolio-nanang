<?php

namespace App\Jobs;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendContactNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public ContactMessage $message) {}

    public function handle(): void
    {
        $this->sendEmail();
        $this->sendWhatsApp();
    }

    private function sendEmail(): void
    {
        try {
            Mail::raw(
                "📬 Pesan baru dari portfolio!\n\n" .
                "Nama    : {$this->message->name}\n" .
                "Email   : {$this->message->email}\n" .
                "Subjek  : {$this->message->subject}\n\n" .
                "Pesan:\n{$this->message->message}\n\n" .
                "---\nDikirim dari portfolio Nanang Aditya",
                function ($mail) {
                    $mail->to(config('mail.from.address'))
                         ->subject("📬 Portfolio Contact: {$this->message->subject}");
                }
            );
        } catch (\Throwable $e) {
            Log::error('Contact email failed: ' . $e->getMessage());
        }
    }

    private function sendWhatsApp(): void
    {
        $phone  = config('services.whatsapp.phone');
        $apiKey = config('services.whatsapp.callmebot_apikey');

        if (!$phone || !$apiKey) {
            return; // Skip if not configured
        }

        try {
            $text = urlencode(
                "📬 *Pesan Baru - Portfolio*\n\n" .
                "*Nama:* {$this->message->name}\n" .
                "*Email:* {$this->message->email}\n" .
                "*Subjek:* {$this->message->subject}\n\n" .
                "*Pesan:*\n{$this->message->message}"
            );

            Http::timeout(10)->get("https://api.callmebot.com/whatsapp.php", [
                'phone'  => $phone,
                'text'   => $text,
                'apikey' => $apiKey,
            ]);
        } catch (\Throwable $e) {
            Log::error('WhatsApp notification failed: ' . $e->getMessage());
        }
    }
}
