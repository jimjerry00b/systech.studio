<?php

namespace App\Services;

use App\Exceptions\ContactRateLimitedException;
use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class ContactMessageService
{
    public const MAX_PER_HOUR = 3;

    protected const DECAY_SECONDS = 3600;

    /**
     * Store a contact message and queue the admin notification email.
     *
     * Only successful submissions count towards the rate limit, so the
     * limiter is hit after the message has been stored.
     *
     * @throws ContactRateLimitedException
     */
    public function submit(array $data, ?string $ipAddress, ?string $userAgent): ContactMessage
    {
        $key = $this->throttleKey($ipAddress);

        if (RateLimiter::tooManyAttempts($key, self::MAX_PER_HOUR)) {
            $retryAfter = RateLimiter::availableIn($key);

            Log::channel('contact')->warning('Contact submission blocked by rate limit', [
                'ip' => $ipAddress,
                'retry_after_seconds' => $retryAfter,
            ]);

            throw new ContactRateLimitedException($retryAfter);
        }

        $message = ContactMessage::create([
            ...$data,
            'ip_address' => $ipAddress,
            'user_agent' => substr((string) $userAgent, 0, 255),
        ]);

        Log::channel('contact')->info('Contact message stored', [
            'contact_message_id' => $message->id,
            'email' => $message->email,
            'subject' => $message->subject,
            'ip' => $ipAddress,
        ]);

        Mail::to(config('mail.contact.to'))->queue(new ContactMessageReceived($message));

        Log::channel('contact')->info('Notification email queued', [
            'contact_message_id' => $message->id,
            'to' => config('mail.contact.to'),
        ]);

        RateLimiter::hit($key, self::DECAY_SECONDS);

        return $message;
    }

    protected function throttleKey(?string $ipAddress): string
    {
        return 'contact-form:'.($ipAddress ?? 'unknown');
    }
}
