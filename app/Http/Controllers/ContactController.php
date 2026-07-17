<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Services\ContactMessageService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function __construct(private ContactMessageService $contactMessages)
    {
    }

    public function index(): View
    {
        return view('pages.contact');
    }

    public function store(StoreContactMessageRequest $request): RedirectResponse
    {
        $this->contactMessages->submit(
            $request->validated(),
            $request->ip(),
            $request->userAgent(),
        );

        return redirect()
            ->route('contact')
            ->with('status', 'Thanks for reaching out! We\'ll get back to you within one business day.');
    }
}
