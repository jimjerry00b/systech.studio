@extends('components.layouts.dashboard')
@section('title', 'Contact Messages')
@section('content')

    <div class="pagetitle">
        <h1>Contact Messages</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Contact Messages</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    @if (session('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center pt-3">
                            <h5 class="card-title p-0 m-0">Inbox <span>| {{ $messages->total() }} total</span></h5>
                            @if ($unreadCount > 0)
                                <span class="badge bg-warning text-dark">{{ $unreadCount }} unread</span>
                            @endif
                        </div>

                        <table class="table table-borderless mt-3">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">From</th>
                                    <th scope="col">Subject</th>
                                    <th scope="col">Received</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($messages as $message)
                                    <tr>
                                        <th scope="row">{{ $message->id }}</th>
                                        <td>
                                            <div class="{{ $message->read_at ? '' : 'fw-bold' }}">{{ $message->name }}</div>
                                            <a href="mailto:{{ $message->email }}" class="text-muted small">{{ $message->email }}</a>
                                            @if ($message->phone)
                                                <div class="text-muted small">{{ $message->phone }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="{{ $message->read_at ? '' : 'fw-bold' }}">{{ Str::limit($message->subject, 50) }}</div>
                                            <span class="text-muted small">{{ Str::limit($message->message, 70) }}</span>
                                        </td>
                                        <td>
                                            <div>{{ $message->created_at->format('d M Y, H:i') }}</div>
                                            <span class="text-muted small">{{ $message->created_at->diffForHumans() }}</span>
                                        </td>
                                        <td>
                                            @if ($message->read_at)
                                                <span class="badge bg-secondary">Read</span>
                                            @else
                                                <span class="badge bg-warning text-dark">New</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-sm btn-outline-secondary" title="View"
                                                data-bs-toggle="modal" data-bs-target="#messageModal{{ $message->id }}">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            @unless ($message->read_at)
                                                <form action="{{ route('contact-messages.read', $message) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-primary" title="Mark as read">
                                                        <i class="bi bi-envelope-open"></i>
                                                    </button>
                                                </form>
                                            @endunless
                                            <form action="{{ route('contact-messages.destroy', $message) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Delete this message?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">No contact messages yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        @if ($messages->hasPages())
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-2">
                                <span class="text-muted small">
                                    Showing {{ $messages->firstItem() }} to {{ $messages->lastItem() }} of {{ $messages->total() }} messages
                                </span>
                                {{ $messages->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Full message modals --}}
    @foreach ($messages as $message)
        <div class="modal fade" id="messageModal{{ $message->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $message->subject }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <dl class="row mb-3">
                            <dt class="col-sm-3">From</dt>
                            <dd class="col-sm-9">{{ $message->name }} &lt;{{ $message->email }}&gt;</dd>
                            @if ($message->phone)
                                <dt class="col-sm-3">Phone</dt>
                                <dd class="col-sm-9">{{ $message->phone }}</dd>
                            @endif
                            <dt class="col-sm-3">Received</dt>
                            <dd class="col-sm-9">{{ $message->created_at->format('d M Y, H:i') }} ({{ $message->created_at->diffForHumans() }})</dd>
                            @if ($message->ip_address)
                                <dt class="col-sm-3">IP address</dt>
                                <dd class="col-sm-9">{{ $message->ip_address }}</dd>
                            @endif
                        </dl>
                        <hr>
                        <p class="mb-0" style="white-space: pre-wrap;">{{ $message->message }}</p>
                    </div>
                    <div class="modal-footer">
                        <a href="mailto:{{ $message->email }}?subject=Re: {{ rawurlencode($message->subject) }}" class="btn btn-primary">
                            <i class="bi bi-reply me-1"></i> Reply
                        </a>
                        @unless ($message->read_at)
                            <form action="{{ route('contact-messages.read', $message) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="bi bi-envelope-open me-1"></i> Mark as read
                                </button>
                            </form>
                        @endunless
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
