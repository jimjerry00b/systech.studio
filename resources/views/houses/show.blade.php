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
                                                <form action="{{ route('bills.update', $bill) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="paid">
                                                    <button type="submit" class="btn btn-sm btn-outline-primary" title="Mark as paid"><i class="bi bi-check-lg"></i></button>
                                                </form>
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
                        <h5 class="card-title">Payment History <span>| Paid Bills</span></h5>

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
                                    <th scope="col">Rent</th>
                                    <th scope="col">Water (WASA)</th>
                                    <th scope="col">Electricity</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Method</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($paidBills as $bill)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ optional($bill->paid_at)->format('d M Y') ?: '—' }}</td>
                                        <td>{{ $bill->period->format('F Y') }}</td>
                                        <td>${{ number_format($bill->rent, 0) }}</td>
                                        <td>${{ number_format($bill->water, 0) }}</td>
                                        <td>${{ number_format($bill->electricity, 0) }}</td>
                                        <td class="fw-bold">${{ number_format($bill->total, 0) }}</td>
                                        <td>{{ $bill->method ?: '—' }}</td>
                                        <td><span class="badge bg-success">Paid</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">No payments yet.</td>
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
                        <h5 class="card-title">Advance Payments</h5>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small text-uppercase">Advance Balance</div>
                                    <div class="fs-4 fw-bold text-success">${{ number_format($house->advance_amount, 0) }}</div>
                                    <div class="text-muted small">Credit available</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small text-uppercase">Months Covered</div>
                                    <div class="fs-4 fw-bold">2 months</div>
                                    <div class="text-muted small">Aug &ndash; Sep 2026</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small text-uppercase">Security Deposit</div>
                                    <div class="fs-4 fw-bold">${{ number_format($house->security_deposit, 0) }}</div>
                                    <div class="text-muted small">Refundable</div>
                                </div>
                            </div>
                        </div>

                        <table class="table table-borderless datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date Received</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Method</th>
                                    <th scope="col">Reference</th>
                                    <th scope="col">Applied To</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>03 Jun 2026</td>
                                    <td>$1,300</td>
                                    <td>M-Pesa</td>
                                    <td>QFG7H2K9LP</td>
                                    <td>Aug &ndash; Sep 2026</td>
                                    <td><span class="badge bg-info">Unapplied</span></td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>01 Jan 2026</td>
                                    <td>${{ number_format($house->security_deposit, 0) }}</td>
                                    <td>Bank Transfer</td>
                                    <td>TRX-410092</td>
                                    <td>Security Deposit</td>
                                    <td><span class="badge bg-secondary">Held</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>

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

            // Monthly Bills table — Action column is not sortable/searchable
            if (document.getElementById('billsTable')) {
                new simpleDatatables.DataTable('#billsTable', {
                    perPage: 10,
                    perPageSelect: [5, 10, 20, 50],
                    columns: [{ select: 7, sortable: false, searchable: false }],
                });
            }

            // Payment History table
            if (document.getElementById('paidBillsTable')) {
                new simpleDatatables.DataTable('#paidBillsTable', {
                    perPage: 10,
                    perPageSelect: [5, 10, 20, 50],
                });
            }
        });
    </script>

@endsection
