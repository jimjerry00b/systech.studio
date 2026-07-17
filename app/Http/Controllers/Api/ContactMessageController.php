<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactMessageRequest;
use App\Services\ContactMessageService;
use Illuminate\Http\JsonResponse;

class ContactMessageController extends Controller
{
    public function __construct(private ContactMessageService $contactMessages)
    {
    }

    public function store(StoreContactMessageRequest $request): JsonResponse
    {
        $message = $this->contactMessages->submit(
            $request->validated(),
            $request->ip(),
            $request->userAgent(),
        );

        return response()->json([
            'message' => 'Your message has been received. We\'ll get back to you within one business day.',
            'data' => [
                'id' => $message->id,
                'created_at' => $message->created_at,
            ],
        ], 201);
    }
}
