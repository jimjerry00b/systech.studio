<?php

namespace App\Providers;

use App\Models\ContactMessage;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Event::listen(function (MessageSent $event) {
            $contactMessage = $event->data['contactMessage'] ?? null;

            if ($contactMessage instanceof ContactMessage) {
                Log::channel('contact')->info('Notification email sent', [
                    'contact_message_id' => $contactMessage->id,
                    'to' => config('mail.contact.to'),
                ]);
            }
        });
    }
}
