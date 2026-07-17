<x-mail::message>
# New contact message

**From:** {{ $contactMessage->name }} &lt;{{ $contactMessage->email }}&gt;

@if ($contactMessage->phone)
**Phone:** {{ $contactMessage->phone }}
@endif

**Subject:** {{ $contactMessage->subject }}

**Received:** {{ $contactMessage->created_at->format('d M Y, H:i') }}

<x-mail::panel>
{{ $contactMessage->message }}
</x-mail::panel>

Reply directly to this email to answer {{ $contactMessage->name }}.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
