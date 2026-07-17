<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContactRateLimitedException extends Exception
{
    public function __construct(public readonly int $retryAfterSeconds)
    {
        parent::__construct('Too many contact messages. Please try again later.');
    }

    public function render(Request $request): JsonResponse|RedirectResponse
    {
        $minutes = max(1, (int) ceil($this->retryAfterSeconds / 60));
        $message = "You've reached the limit of 3 messages per hour. Please try again in {$minutes} "
            .Str::plural('minute', $minutes).'.';

        if ($request->is('api/*') || $request->expectsJson()) {
            return response()
                ->json(['message' => $message], 429)
                ->header('Retry-After', $this->retryAfterSeconds);
        }

        return back()->withInput()->withErrors(['message' => $message]);
    }
}
