@extends('components.layouts.dashboard')
@section('title', 'Inactive Renters')
@section('content')

    <div class="pagetitle">
        <h1>Inactive Renters</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('houses.index') }}">House Rents</a></li>
                <li class="breadcrumb-item active">Inactive</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center pt-3">
                            <h5 class="card-title p-0 m-0">Old / Inactive Renters <span>| Expired Leases</span></h5>
                            <a href="{{ route('houses.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-arrow-left me-1"></i> Back to Active
                            </a>
                        </div>

                        <table class="table table-borderless datatable mt-3">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Renter</th>
                                    <th scope="col">Contact</th>
                                    <th scope="col">House / Rent</th>
                                    <th scope="col">Lease Period</th>
                                    <th scope="col" class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($houses as $house)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $house->name }}</td>
                                        <td>
                                            <div>{{ $house->phone ?: '—' }}</div>
                                            @if ($house->email)
                                                <a href="mailto:{{ $house->email }}" class="text-muted small">{{ $house->email }}</a>
                                            @endif
                                        </td>
                                        <td>
                                            <div>{{ $house->unit }}</div>
                                            <span class="text-muted small">৳{{ number_format($house->rent_amount, 0) }} / month</span>
                                        </td>
                                        <td>
                                            <div>{{ optional($house->lease_start)->format('d M Y') ?: '—' }}</div>
                                            <span class="text-muted small">{{ optional($house->lease_end)->format('d M Y') ?: '—' }}</span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('houses.show', $house) }}" class="btn btn-sm btn-outline-secondary" title="View"><i class="bi bi-eye"></i></a>
                                            <a href="{{ route('houses.edit', $house) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                            <form action="{{ route('houses.destroy', $house) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this renter?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">No inactive renters found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
