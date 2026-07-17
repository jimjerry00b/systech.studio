<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ContactMessageController extends Controller
{
    public function index(): View
    {
        $messages = ContactMessage::orderByDesc('id')->paginate(10);
        $unreadCount = ContactMessage::whereNull('read_at')->count();

        return view('contact-messages.index', compact('messages', 'unreadCount'));
    }

    public function markRead(ContactMessage $contactMessage): RedirectResponse
    {
        if (! $contactMessage->read_at) {
            $contactMessage->update(['read_at' => now()]);
        }

        return back()->with('message', 'Message marked as read.');
    }

    public function destroy(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->delete();

        return back()->with('message', 'Message deleted.');
    }
}
