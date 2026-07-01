@use('Illuminate\Support\Facades\Storage')
@extends('components.layouts.dashboard')
@section('title', 'Show Renter')
@section('content')

    <div class="pagetitle">
        <h1>Show Renter</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Renters</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    @if (session('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @php
        $statusColors = ['active' => 'success', 'pending' => 'warning', 'expired' => 'danger'];
        $statusColor = $statusColors[$house->status] ?? 'secondary';

        $bills = $house->bills;
        $latestBill = $bills->first();
        $totalBilled = $bills->sum('total');
        $outstanding = $bills->where('status', 'unpaid')->sum('total');
        $unpaidCount = $bills->where('status', 'unpaid')->count();

        // Payment History = bills that have been paid.
        $paidBills = $bills->where('status', 'paid');
        $totalPaid = $paidBills->sum('total');
        $paidCount = $paidBills->count();
        $nextDue = $bills->where('status', 'unpaid')->sortBy('period')->first();

        // Bills settled wholly or partly from advance balance or security deposit.
        $deductionBills = $bills->filter(fn($b) =>
            $b->status === 'paid' && ((float) $b->advance_used > 0 || (float) $b->deposit_used > 0)
        );
        $totalApplied = $deductionBills->sum(fn($b) => (float) $b->advance_used + (float) $b->deposit_used);

        // Funds received (top-ups) into advance balance / security deposit.
        $advanceTransactions = $house->advanceTransactions;
        $totalReceived = $advanceTransactions->sum('amount');

        // WhatsApp summary covering every generated bill for this renter.
        $waSummaryPhone = $house->whatsappPhone();
        $waSummaryLines = [];
        foreach ($bills as $b) {
            $waSummaryLines[] = '- ' . $b->period->format('M Y')
                . ': Rent $' . number_format($b->rent, 0)
                . ' + Water $' . number_format($b->water, 0)
                . ' + Electricity $' . number_format($b->electricity, 0)
                . ' = $' . number_format($b->total, 0)
                . ' (' . ($b->status === 'paid' ? 'Paid' : 'Unpaid') . ')';
        }
        $waSummaryText = 'Hi ' . $house->name . ', here is your billing summary for ' . $house->unit . ":\n\n"
            . implode("\n", $waSummaryLines)
            . "\n\nTotal billed: $" . number_format($totalBilled, 0)
            . "\nTotal paid: $" . number_format($totalPaid, 0)
            . "\nOutstanding: $" . number_format($outstanding, 0)
            . ($outstanding > 0
                ? "\n\nKindly clear the outstanding amount. Thank you."
                : "\n\nAll bills are cleared — thank you!");
    @endphp

    <section class="section profile">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center pt-3 mb-3">
                            <h5 class="card-title p-0 m-0">Renter <span>| Details</span></h5>
                            <div>
                                <a href="{{ route('houses.index') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-arrow-left me-1"></i> Back
                                </a>
                                <a href="{{ route('houses.statement', $house) }}" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-file-earmark-pdf me-1"></i> Download PDF
                                </a>
                                <a href="{{ route('houses.edit', $house) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-pencil me-1"></i> Edit
                                </a>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-3 col-md-4 label fw-bold">Full Name</div>
                            <div class="col-lg-9 col-md-8">{{ $house->name }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-3 col-md-4 label fw-bold">Phone</div>
                            <div class="col-lg-9 col-md-8">{{ $house->phone ?: '—' }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-3 col-md-4 label fw-bold">Email</div>
                            <div class="col-lg-9 col-md-8">
                                @if ($house->email)
                                    <a href="mailto:{{ $house->email }}">{{ $house->email }}</a>
                                @else
                                    —
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-3 col-md-4 label fw-bold">Renter Photo</div>
                            <div class="col-lg-9 col-md-8">
                                @if ($house->photo)
                                    <a href="{{ Storage::disk('public')->url($house->photo) }}" target="_blank">
                                        <img src="{{ Storage::disk('public')->url($house->photo) }}" alt="Renter photo" class="rounded" style="height:100px; object-fit:cover;">
                                    </a>
                                @else
                                    —
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-3 col-md-4 label fw-bold">NID Card Copy</div>
                            <div class="col-lg-9 col-md-8">
                                @if ($house->nid_copy)
                                    <a href="{{ Storage::disk('public')->url($house->nid_copy) }}" target="_blank">
                                        <img src="{{ Storage::disk('public')->url($house->nid_copy) }}" alt="NID card" class="rounded" style="height:100px; object-fit:cover;">
                                    </a>
                                @else
                                    —
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-3 col-md-4 label fw-bold">House / Unit</div>
                            <div class="col-lg-9 col-md-8">{{ $house->unit }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-3 col-md-4 label fw-bold">Monthly Rent</div>
                            <div class="col-lg-9 col-md-8">${{ number_format($house->rent_amount, 0) }} / month</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-3 col-md-4 label fw-bold">Lease Start</div>
                            <div class="col-lg-9 col-md-8">{{ optional($house->lease_start)->format('d M Y') ?: '—' }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-3 col-md-4 label fw-bold">Lease End</div>
                            <div class="col-lg-9 col-md-8">{{ optional($house->lease_end)->format('d M Y') ?: '—' }}</div>
                        </div>

                        <hr>
                        <h6 class="text-muted text-uppercase small mb-3">Utilities</h6>

                        <div class="row mb-3">
                            <div class="col-lg-3 col-md-4 label fw-bold">Electric Meter Number</div>
                            <div class="col-lg-9 col-md-8">{{ $house->electric_meter_number ?: '—' }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-3 col-md-4 label fw-bold">Electric Account Number</div>
                            <div class="col-lg-9 col-md-8">{{ $house->electric_account_number ?: '—' }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-3 col-md-4 label fw-bold">Gas Meter Number</div>
                            <div class="col-lg-9 col-md-8">{{ $house->gas_meter_number ?: '—' }}</div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <div class="col-lg-3 col-md-4 label fw-bold">Status</div>
                            <div class="col-lg-9 col-md-8"><span class="badge bg-{{ $statusColor }}">{{ ucfirst($house->status) }}</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center pt-3 mb-1">
                            <h5 class="card-title p-0 m-0">Monthly Bills <span>| Total Due</span></h5>
                            <div class="d-flex gap-2">
                                @if ($house->phone && $bills->isNotEmpty())
                                    <a href="https://wa.me/{{ $waSummaryPhone }}?text={{ rawurlencode($waSummaryText) }}"
                                        target="_blank" rel="noopener"
                                        class="btn btn-outline-success btn-sm" title="Send full bill summary via WhatsApp">
                                        <i class="bi bi-whatsapp me-1"></i> Send Summary
                                    </a>
                                @endif
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#generateBillModal">
                                    <i class="bi bi-receipt me-1"></i> Generate Bill
                                </button>
                            </div>
                        </div>
                        <p class="text-muted small mb-3">Rent and WASA water are fixed each month; electricity varies by usage.</p>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small text-uppercase">This Month's Bill</div>
                                    <div class="fs-4 fw-bold">{{ $latestBill ? '$' . number_format($latestBill->total, 0) : '—' }}</div>
                                    <div class="text-muted small">{{ $latestBill ? $latestBill->period->format('F Y') : 'No bills yet' }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small text-uppercase">Total Billed</div>
                                    <div class="fs-4 fw-bold">${{ number_format($totalBilled, 0) }}</div>
                                    <div class="text-muted small">{{ $bills->count() }} {{ Str::plural('bill', $bills->count()) }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small text-uppercase">Outstanding</div>
                                    <div class="fs-4 fw-bold text-danger">${{ number_format($outstanding, 0) }}</div>
                                    <div class="text-muted small">{{ $unpaidCount }} unpaid {{ Str::plural('bill', $unpaidCount) }}</div>
                                </div>
                            </div>
                        </div>

                        <table id="billsTable" class="table table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Period</th>
                                    <th scope="col">Rent</th>
                                    <th scope="col">Water (WASA)</th>
                                    <th scope="col">Electricity</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bills as $bill)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $bill->period->format('F Y') }}</td>
                                        <td>${{ number_format($bill->rent, 0) }}</td>
                                        <td>${{ number_format($bill->water, 0) }}</td>
                                        <td>${{ number_format($bill->electricity, 0) }}</td>
                                        <td class="fw-bold">${{ number_format($bill->total, 0) }}</td>
                                        <td>
                                            @if ($bill->status === 'paid')
                                                <span class="badge bg-success">Paid</span>
                                            @else
                                                <span class="badge bg-warning">Unpaid</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            @if ($house->phone)
                                                @php
                                                    // Normalised to international format (country code, no leading 0).
                                                    $waPhone = $house->whatsappPhone();
                                                    $waText = 'Hi ' . $house->name . ",\n"
                                                        . 'Your bill for ' . $bill->period->format('F Y')
                                                        . ' is $' . number_format($bill->total, 0)
                                                        . ' (Rent $' . number_format($bill->rent, 0)
                                                        . ' + Water $' . number_format($bill->water, 0)
                                                        . ' + Electricity $' . number_format($bill->electricity, 0) . '). '
                                                        . ($bill->status === 'paid'
                                                            ? 'Payment received.'
                                                            : 'Kindly clear the outstanding amount.')
                                                        . "\nThank you.";
                                                @endphp
                                                <a href="https://wa.me/{{ $waPhone }}?text={{ rawurlencode($waText) }}"
                                                    target="_blank" rel="noopener"
                                                    class="btn btn-sm btn-outline-success" title="Send bill via WhatsApp">
                                                    <i class="bi bi-whatsapp"></i>
                                                </a>
                                            @endif
                                            @if ($bill->status !== 'paid')
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-primary js-record-payment"
                                                    title="Record payment"
                                                    data-action="{{ route('bills.update', $bill) }}"
                                                    data-total="{{ (float) $bill->total }}"
                                                    data-period="{{ $bill->period->format('F Y') }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#recordPaymentModal">
                                                    <i class="bi bi-cash-coin"></i>
                                                </button>
                                            @endif
                                            <form action="{{ route('bills.destroy', $bill) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this bill?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">No bills generated yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- NOTE: Advance Payments below is still a static placeholder.
                 It can be wired to a dedicated advances table in a follow-up. --}}
            <div class="col-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Payment History <span>| Paid Bills</span></h5>
                            <a href="{{ route('houses.statement', $house) }}" class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-file-earmark-pdf me-1"></i> Download PDF
                            </a>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small text-uppercase">Total Paid</div>
                                    <div class="fs-4 fw-bold text-success">${{ number_format($totalPaid, 0) }}</div>
                                    <div class="text-muted small">{{ $paidCount }} {{ Str::plural('payment', $paidCount) }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small text-uppercase">Outstanding Balance</div>
                                    <div class="fs-4 fw-bold text-danger">${{ number_format($outstanding, 0) }}</div>
                                    <div class="text-muted small">{{ $unpaidCount }} unpaid {{ Str::plural('bill', $unpaidCount) }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small text-uppercase">Next Due</div>
                                    <div class="fs-4 fw-bold">{{ $nextDue ? ($nextDue->due_date ? $nextDue->due_date->format('d M Y') : $nextDue->period->format('d M Y')) : '—' }}</div>
                                    <div class="text-muted small">{{ $nextDue ? $nextDue->period->format('F Y') . ' · $' . number_format($nextDue->total, 0) : 'Nothing due' }}</div>
                                </div>
                            </div>
                        </div>

                        <table id="paidBillsTable" class="table table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date Paid</th>
                                    <th scope="col">Period</th>
                                    <th scope="col">Bill Total</th>
                                    <th scope="col">Cash / Other</th>
                                    <th scope="col">From Advance</th>
                                    <th scope="col">From Deposit</th>
                                    <th scope="col">Method</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($paidBills as $bill)
                                    @php
                                        $advUsed  = (float) $bill->advance_used;
                                        $depUsed  = (float) $bill->deposit_used;
                                        $cashPaid = max(0, (float) $bill->total - $advUsed - $depUsed);
                                    @endphp
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ optional($bill->paid_at)->format('d M Y') ?: '—' }}</td>
                                        <td>{{ $bill->period->format('F Y') }}</td>
                                        <td class="fw-bold">${{ number_format($bill->total, 0) }}</td>
                                        <td>${{ number_format($cashPaid, 0) }}</td>
                                        <td>{!! $advUsed > 0 ? '<span class="text-primary fw-semibold">−$' . number_format($advUsed, 0) . '</span>' : '<span class="text-muted">—</span>' !!}</td>
                                        <td>{!! $depUsed > 0 ? '<span class="text-info fw-semibold">−$' . number_format($depUsed, 0) . '</span>' : '<span class="text-muted">—</span>' !!}</td>
                                        <td>{{ $bill->method ?: '—' }}</td>
                                        <td><span class="badge bg-success">Paid</span></td>
                                        <td class="text-end">
                                            <a href="{{ route('bills.receipt', $bill) }}"
                                                class="btn btn-sm btn-outline-danger" title="Download receipt PDF">
                                                <i class="bi bi-file-earmark-pdf"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-muted py-4">No payments yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Advance &amp; Deposit</h5>
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addFundsModal">
                                <i class="bi bi-plus-circle me-1"></i> Add Funds
                            </button>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small text-uppercase">Advance Balance</div>
                                    <div class="fs-4 fw-bold text-success">${{ number_format($house->advance_amount, 0) }}</div>
                                    <div class="text-muted small">Credit available</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small text-uppercase">Security Deposit</div>
                                    <div class="fs-4 fw-bold">${{ number_format($house->security_deposit, 0) }}</div>
                                    <div class="text-muted small">Refundable</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small text-uppercase">Total Received</div>
                                    <div class="fs-4 fw-bold text-success">${{ number_format($totalReceived, 0) }}</div>
                                    <div class="text-muted small">{{ $advanceTransactions->count() }} {{ Str::plural('top-up', $advanceTransactions->count()) }}</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small text-uppercase">Applied to Bills</div>
                                    <div class="fs-4 fw-bold text-info">${{ number_format($totalApplied, 0) }}</div>
                                    <div class="text-muted small">{{ $deductionBills->count() }} {{ Str::plural('bill', $deductionBills->count()) }} settled</div>
                                </div>
                            </div>
                        </div>

                        <h6 class="text-muted text-uppercase small mb-2">Funds Received</h6>
                        <table class="table table-borderless mb-4">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date Received</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Method</th>
                                    <th scope="col">Reference</th>
                                    <th scope="col">Note</th>
                                    <th scope="col" class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($advanceTransactions as $tx)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ optional($tx->received_at)->format('d M Y') ?: '—' }}</td>
                                        <td>
                                            @if ($tx->type === 'deposit')
                                                <span class="badge bg-info">Security Deposit</span>
                                            @else
                                                <span class="badge bg-primary">Advance</span>
                                            @endif
                                        </td>
                                        <td class="fw-semibold text-success">+${{ number_format($tx->amount, 0) }}</td>
                                        <td>{{ $tx->method ?: '—' }}</td>
                                        <td>{{ $tx->reference ?: '—' }}</td>
                                        <td>{{ $tx->note ?: '—' }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('advances.receipt', $tx) }}" class="btn btn-sm btn-outline-danger" title="Download receipt PDF">
                                                <i class="bi bi-file-earmark-pdf"></i>
                                            </a>
                                            <form action="{{ route('advances.destroy', $tx) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Remove this entry and reverse it from the balance?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">No advance or deposit payments received yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <h6 class="text-muted text-uppercase small mb-2">Applied to Bills</h6>
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">For Bill</th>
                                    <th scope="col">From Advance</th>
                                    <th scope="col">From Deposit</th>
                                    <th scope="col">Method</th>
                                    <th scope="col">Reference</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($deductionBills as $bill)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ optional($bill->paid_at)->format('d M Y') ?: '—' }}</td>
                                        <td>{{ $bill->period->format('F Y') }}</td>
                                        <td>
                                            @if ((float) $bill->advance_used > 0)
                                                <span class="fw-semibold text-primary">−${{ number_format($bill->advance_used, 0) }}</span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ((float) $bill->deposit_used > 0)
                                                <span class="fw-semibold text-info">−${{ number_format($bill->deposit_used, 0) }}</span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>{{ $bill->method ?: '—' }}</td>
                                        <td>{{ $bill->reference ?: '—' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">No advance/deposit deductions yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Record Payment Modal -->
    <div class="modal fade" id="recordPaymentModal" tabindex="-1" aria-hidden="true"
        data-advance-available="{{ (float) $house->advance_amount }}"
        data-deposit-available="{{ (float) $house->security_deposit }}"
        data-today="{{ now()->format('Y-m-d') }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="recordPaymentForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title">Record Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted small mb-1">
                            Period: <strong id="payModalPeriod"></strong>
                        </p>
                        <div class="d-flex justify-content-between align-items-center border rounded px-3 py-2 mb-3 bg-light">
                            <span class="fw-semibold">Bill Total</span>
                            <span class="fs-5 fw-bold" id="payModalTotal"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Payment Date</label>
                            <input type="date" name="paid_date" id="payDateInput"
                                class="form-control" value="{{ now()->format('Y-m-d') }}"
                                max="{{ now()->format('Y-m-d') }}">
                            <div class="form-text">Defaults to today; set a past date to backdate the payment.</div>
                        </div>

                        {{-- Section 1: Pay from Advance Balance --}}
                        <div class="border rounded p-3 mb-3">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="bi bi-wallet2 text-primary"></i>
                                <span class="fw-semibold">Pay from Advance Balance</span>
                                <span class="ms-auto small text-muted">Available: <strong id="payAdvanceAvail" class="text-primary"></strong></span>
                            </div>
                            <p class="text-muted small mb-2">Deducts from the renter's advance credit.</p>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="advance_used" id="payAdvanceInput"
                                    class="form-control" min="0" step="0.01" value="0" placeholder="0">
                                <button type="button" class="btn btn-outline-primary" id="payAdvanceMax">Use Max</button>
                            </div>
                        </div>

                        {{-- Section 2: Pay from Security Deposit --}}
                        <div class="border rounded p-3 mb-3">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="bi bi-safe text-info"></i>
                                <span class="fw-semibold">Pay from Security Deposit</span>
                                <span class="ms-auto small text-muted">Available: <strong id="payDepositAvail" class="text-info"></strong></span>
                            </div>
                            <p class="text-muted small mb-2">Deducts from the refundable deposit held.</p>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="deposit_used" id="payDepositInput"
                                    class="form-control" min="0" step="0.01" value="0" placeholder="0">
                                <button type="button" class="btn btn-outline-info" id="payDepositMax">Use Max</button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Payment Method <span class="text-muted small fw-normal">(for remaining cash)</span></label>
                            <select name="method" class="form-select">
                                <option value="">— Select —</option>
                                <option value="Cash">Cash</option>
                                <option value="M-Pesa">M-Pesa</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="Cheque">Cheque</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Reference / Transaction ID</label>
                            <input type="text" name="reference" class="form-control"
                                placeholder="Optional — e.g. M-Pesa confirmation code">
                        </div>

                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Remaining to Pay (Cash / Other)</span>
                            <span class="fs-4 fw-bold text-primary" id="payModalCollectTotal"></span>
                        </div>
                        <div class="form-text" id="payModalHint"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="paySubmitBtn">
                            <i class="bi bi-cash-coin me-1"></i> Confirm Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Funds Modal -->
    <div class="modal fade" id="addFundsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('advances.store', $house) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Advance / Deposit Funds</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted small mb-3">Record money received from the renter as advance credit or security deposit. The chosen balance is increased immediately.</p>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Add To <span class="text-danger">*</span></label>
                            <select name="type" class="form-select" required>
                                <option value="advance">Advance Balance</option>
                                <option value="deposit">Security Deposit</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Amount <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="amount" class="form-control" min="0.01" step="0.01"
                                    value="{{ old('amount') }}" placeholder="Enter amount received" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Date Received</label>
                            <input type="date" name="received_at" class="form-control"
                                value="{{ old('received_at', now()->format('Y-m-d')) }}" max="{{ now()->format('Y-m-d') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Payment Method</label>
                            <select name="method" class="form-select">
                                <option value="">— Select —</option>
                                <option value="Cash">Cash</option>
                                <option value="M-Pesa">M-Pesa</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="Cheque">Cheque</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Reference / Transaction ID</label>
                            <input type="text" name="reference" class="form-control" value="{{ old('reference') }}"
                                placeholder="Optional — e.g. M-Pesa confirmation code">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Note</label>
                            <input type="text" name="note" class="form-control" value="{{ old('note') }}"
                                placeholder="Optional — e.g. 2 months advance">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-plus-circle me-1"></i> Add Funds
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Generate Bill Modal -->
    <div class="modal fade" id="generateBillModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="generateBillForm" action="{{ route('houses.bills.store', $house) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Generate Monthly Bill</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="mb-3">
                            <label class="form-label">Billing Period</label>
                            <input type="month" name="period" class="form-control" value="{{ old('period', now()->format('Y-m')) }}" required>
                        </div>
                        <div class="row g-2">
                            <div class="col-6 mb-3">
                                <label class="form-label">Rent (fixed)</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" id="billRent" class="form-control" value="{{ (int) $house->rent_amount }}" readonly>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Water / WASA (fixed)</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" id="billWater" class="form-control" value="{{ (int) $house->water_amount }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Electricity (varies)</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" id="billElectric" name="electricity" class="form-control" min="0" step="0.01" value="{{ old('electricity') }}" placeholder="Enter this month's amount" required>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Total Bill</span>
                            <span class="fs-4 fw-bold text-primary" id="billTotal">$0</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Generate Bill</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Bill total recalculation
            const rent = document.getElementById('billRent');
            const water = document.getElementById('billWater');
            const electric = document.getElementById('billElectric');
            const total = document.getElementById('billTotal');

            function recalcBill() {
                const sum = (parseFloat(rent.value) || 0)
                          + (parseFloat(water.value) || 0)
                          + (parseFloat(electric.value) || 0);
                total.textContent = '$' + sum.toLocaleString(undefined, { maximumFractionDigits: 2 });
            }

            if (electric) {
                electric.addEventListener('input', recalcBill);
                recalcBill();
            }

            // Record Payment modal — populate via Bootstrap's show.bs.modal so it works
            // even after simple-datatables re-renders rows on pagination.
            const payModal        = document.getElementById('recordPaymentModal');
            const payAdvanceInput = document.getElementById('payAdvanceInput');
            const payDepositInput = document.getElementById('payDepositInput');
            const paySubmitBtn    = document.getElementById('paySubmitBtn');
            let   payBillTotal    = 0;
            let   payAdvanceAvail = 0;
            let   payDepositAvail = 0;

            const money = n => '$' + n.toLocaleString(undefined, { maximumFractionDigits: 0 });

            if (payModal) {
                payAdvanceAvail = parseFloat(payModal.dataset.advanceAvailable) || 0;
                payDepositAvail = parseFloat(payModal.dataset.depositAvailable) || 0;

                payModal.addEventListener('show.bs.modal', function (e) {
                    const btn    = e.relatedTarget;
                    payBillTotal = parseFloat(btn.dataset.total) || 0;

                    document.getElementById('recordPaymentForm').action  = btn.dataset.action;
                    document.getElementById('payModalPeriod').textContent = btn.dataset.period;
                    document.getElementById('payModalTotal').textContent  = money(payBillTotal);
                    document.getElementById('payAdvanceAvail').textContent = money(payAdvanceAvail);
                    document.getElementById('payDepositAvail').textContent = money(payDepositAvail);

                    payAdvanceInput.value = '0';
                    payDepositInput.value = '0';
                    payModal.querySelectorAll('select, input[name="reference"]').forEach(el => el.value = '');

                    const payDateInput = document.getElementById('payDateInput');
                    if (payDateInput) payDateInput.value = payModal.dataset.today;

                    recalcPayTotal();
                });
            }

            function recalcPayTotal() {
                const advance = parseFloat(payAdvanceInput.value) || 0;
                const deposit = parseFloat(payDepositInput.value) || 0;
                const remaining = Math.round((payBillTotal - advance - deposit) * 100) / 100;

                document.getElementById('payModalCollectTotal').textContent = money(Math.max(0, remaining));

                const hint = document.getElementById('payModalHint');
                let error = '';
                if (advance > payAdvanceAvail)      error = 'Advance exceeds available balance of ' + money(payAdvanceAvail) + '.';
                else if (deposit > payDepositAvail) error = 'Deposit exceeds available balance of ' + money(payDepositAvail) + '.';
                else if (advance + deposit > payBillTotal) error = 'Advance + deposit cannot exceed the bill total.';

                if (error) {
                    hint.className = 'form-text text-danger';
                    hint.textContent = error;
                    paySubmitBtn.disabled = true;
                } else {
                    hint.className = 'form-text text-muted';
                    hint.textContent = remaining > 0
                        ? money(remaining) + ' to be collected as cash / other.'
                        : 'Fully covered by advance / deposit — no cash needed.';
                    paySubmitBtn.disabled = false;
                }
            }

            if (payAdvanceInput) payAdvanceInput.addEventListener('input', recalcPayTotal);
            if (payDepositInput) payDepositInput.addEventListener('input', recalcPayTotal);

            const payAdvanceMax = document.getElementById('payAdvanceMax');
            const payDepositMax = document.getElementById('payDepositMax');

            if (payAdvanceMax) payAdvanceMax.addEventListener('click', function () {
                const deposit = parseFloat(payDepositInput.value) || 0;
                payAdvanceInput.value = Math.max(0, Math.min(payAdvanceAvail, payBillTotal - deposit)).toFixed(2);
                recalcPayTotal();
            });

            if (payDepositMax) payDepositMax.addEventListener('click', function () {
                const advance = parseFloat(payAdvanceInput.value) || 0;
                payDepositInput.value = Math.max(0, Math.min(payDepositAvail, payBillTotal - advance)).toFixed(2);
                recalcPayTotal();
            });

            // Monthly Bills table — Action column is not sortable/searchable
            if (document.getElementById('billsTable')) {
                new simpleDatatables.DataTable('#billsTable', {
                    perPage: 10,
                    perPageSelect: [5, 10, 20, 50],
                    columns: [{ select: 7, sortable: false, searchable: false }],
                });
            }

            // Payment History table — Action column is not sortable/searchable
            if (document.getElementById('paidBillsTable')) {
                new simpleDatatables.DataTable('#paidBillsTable', {
                    perPage: 10,
                    perPageSelect: [5, 10, 20, 50],
                    columns: [{ select: 9, sortable: false, searchable: false }],
                });
            }
        });
    </script>

@endsection
