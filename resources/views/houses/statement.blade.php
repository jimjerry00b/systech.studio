@php
    $bills        = $house->bills;
    $totalBilled  = $bills->sum('total');
    $outstanding  = $bills->where('status', 'unpaid')->sum('total');
    $unpaidCount  = $bills->where('status', 'unpaid')->count();

    $paidBills    = $bills->where('status', 'paid');
    $totalPaid    = $paidBills->sum('total');
    $paidCount    = $paidBills->count();

    $deductionBills = $bills->filter(fn($b) =>
        $b->status === 'paid' && ((float) $b->advance_used > 0 || (float) $b->deposit_used > 0)
    );

    $advanceTransactions = $house->advanceTransactions;
    $totalReceived = $advanceTransactions->sum('amount');

    $statusLabels = ['active' => 'Active', 'pending' => 'Pending', 'expired' => 'Expired'];
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Account Statement — {{ $house->name }}</title>
    <style>
        @page { margin: 28px 32px; }
        * { font-family: DejaVu Sans, sans-serif; }
        body { color: #222; font-size: 11px; margin: 0; }

        .header { border-bottom: 2px solid #4154f1; padding-bottom: 8px; margin-bottom: 14px; }
        .header .brand { font-size: 20px; font-weight: bold; color: #4154f1; }
        .header .doc-title { font-size: 13px; color: #555; margin-top: 2px; }
        .header .meta { font-size: 10px; color: #777; margin-top: 2px; }

        h2 { font-size: 12px; color: #4154f1; margin: 16px 0 6px; text-transform: uppercase;
             border-bottom: 1px solid #e3e6f0; padding-bottom: 3px; }

        table { width: 100%; border-collapse: collapse; }

        .info td { padding: 3px 6px; vertical-align: top; }
        .info .label { color: #777; width: 130px; }

        .cards td { width: 20%; padding: 4px; }
        .card { border: 1px solid #e3e6f0; border-radius: 4px; padding: 6px 8px; }
        .card .k { font-size: 8px; color: #888; text-transform: uppercase; }
        .card .v { font-size: 14px; font-weight: bold; }

        .data th { background: #f6f7fb; border: 1px solid #e3e6f0; padding: 5px 6px; text-align: left; font-size: 10px; }
        .data td { border: 1px solid #e3e6f0; padding: 5px 6px; }
        .data tfoot td { background: #f6f7fb; font-weight: bold; }

        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .muted { color: #999; }
        .green { color: #198754; }
        .red { color: #dc3545; }
        .blue { color: #4154f1; }
        .teal { color: #0dcaf0; }
        .bold { font-weight: bold; }

        .badge { padding: 1px 6px; border-radius: 8px; font-size: 9px; color: #fff; }
        .badge-green { background: #198754; }
        .badge-amber { background: #ffc107; color: #222; }

        .footer { margin-top: 20px; padding-top: 8px; border-top: 1px solid #e3e6f0;
                  font-size: 9px; color: #999; text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <table>
            <tr>
                <td>
                    <div class="brand">{{ config('app.name') }}</div>
                    <div class="doc-title">Renter Account Statement</div>
                </td>
                <td class="text-end" style="vertical-align: bottom;">
                    <div class="meta">Generated: {{ now()->format('d M Y, H:i') }}</div>
                    <div class="meta">Statement for: <strong>{{ $house->name }}</strong></div>
                </td>
            </tr>
        </table>
    </div>

    <h2>Renter Details</h2>
    <table class="info">
        <tr>
            <td class="label">Full Name</td><td>{{ $house->name }}</td>
            <td class="label">House / Unit</td><td>{{ $house->unit }}</td>
        </tr>
        <tr>
            <td class="label">Phone</td><td>{{ $house->phone ?: '-' }}</td>
            <td class="label">Email</td><td>{{ $house->email ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Monthly Rent</td><td>${{ number_format($house->rent_amount, 0) }}</td>
            <td class="label">Water / WASA</td><td>${{ number_format($house->water_amount, 0) }}</td>
        </tr>
        <tr>
            <td class="label">Lease Start</td><td>{{ optional($house->lease_start)->format('d M Y') ?: '-' }}</td>
            <td class="label">Lease End</td><td>{{ optional($house->lease_end)->format('d M Y') ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Status</td><td>{{ $statusLabels[$house->status] ?? ucfirst($house->status) }}</td>
            <td class="label"></td><td></td>
        </tr>
    </table>

    <h2>Account Summary</h2>
    <table class="cards">
        <tr>
            <td>
                <div class="card"><div class="k">Total Billed</div>
                    <div class="v">${{ number_format($totalBilled, 0) }}</div></div>
            </td>
            <td>
                <div class="card"><div class="k">Total Paid</div>
                    <div class="v green">${{ number_format($totalPaid, 0) }}</div></div>
            </td>
            <td>
                <div class="card"><div class="k">Outstanding</div>
                    <div class="v red">${{ number_format($outstanding, 0) }}</div></div>
            </td>
            <td>
                <div class="card"><div class="k">Advance Balance</div>
                    <div class="v green">${{ number_format($house->advance_amount, 0) }}</div></div>
            </td>
            <td>
                <div class="card"><div class="k">Security Deposit</div>
                    <div class="v">${{ number_format($house->security_deposit, 0) }}</div></div>
            </td>
        </tr>
    </table>

    <h2>Monthly Bills</h2>
    <table class="data">
        <thead>
            <tr>
                <th>#</th>
                <th>Period</th>
                <th class="text-end">Rent</th>
                <th class="text-end">Water</th>
                <th class="text-end">Electricity</th>
                <th class="text-end">Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bills as $bill)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $bill->period->format('F Y') }}</td>
                    <td class="text-end">${{ number_format($bill->rent, 0) }}</td>
                    <td class="text-end">${{ number_format($bill->water, 0) }}</td>
                    <td class="text-end">${{ number_format($bill->electricity, 0) }}</td>
                    <td class="text-end bold">${{ number_format($bill->total, 0) }}</td>
                    <td>
                        @if ($bill->status === 'paid')
                            <span class="badge badge-green">Paid</span>
                        @else
                            <span class="badge badge-amber">Unpaid</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center muted">No bills generated yet.</td></tr>
            @endforelse
        </tbody>
        @if ($bills->isNotEmpty())
            <tfoot>
                <tr>
                    <td colspan="5" class="text-end">Total Billed</td>
                    <td class="text-end">${{ number_format($totalBilled, 0) }}</td>
                    <td></td>
                </tr>
            </tfoot>
        @endif
    </table>

    <h2>Payment History</h2>
    <table class="data">
        <thead>
            <tr>
                <th>#</th>
                <th>Date Paid</th>
                <th>Period</th>
                <th class="text-end">Bill Total</th>
                <th class="text-end">Cash / Other</th>
                <th class="text-end">From Advance</th>
                <th class="text-end">From Deposit</th>
                <th>Method</th>
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
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ optional($bill->paid_at)->format('d M Y') ?: '-' }}</td>
                    <td>{{ $bill->period->format('F Y') }}</td>
                    <td class="text-end bold">${{ number_format($bill->total, 0) }}</td>
                    <td class="text-end">${{ number_format($cashPaid, 0) }}</td>
                    <td class="text-end">{!! $advUsed > 0 ? '<span class="blue bold">-$' . number_format($advUsed, 0) . '</span>' : '<span class="muted">-</span>' !!}</td>
                    <td class="text-end">{!! $depUsed > 0 ? '<span class="teal bold">-$' . number_format($depUsed, 0) . '</span>' : '<span class="muted">-</span>' !!}</td>
                    <td>{{ $bill->method ?: '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center muted">No payments yet.</td></tr>
            @endforelse
        </tbody>
        @if ($paidBills->isNotEmpty())
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end">Total Paid</td>
                    <td class="text-end">${{ number_format($totalPaid, 0) }}</td>
                    <td colspan="4"></td>
                </tr>
            </tfoot>
        @endif
    </table>

    <h2>Advance &amp; Deposit — Funds Received</h2>
    <table class="data">
        <thead>
            <tr>
                <th>#</th>
                <th>Date Received</th>
                <th>Type</th>
                <th class="text-end">Amount</th>
                <th>Method</th>
                <th>Reference</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($advanceTransactions as $tx)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ optional($tx->received_at)->format('d M Y') ?: '-' }}</td>
                    <td>{{ $tx->typeLabel() }}</td>
                    <td class="text-end">${{ number_format($tx->amount, 0) }}</td>
                    <td>{{ $tx->method ?: '-' }}</td>
                    <td>{{ $tx->reference ?: '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center muted">No advance/deposit payments received yet.</td></tr>
            @endforelse
        </tbody>
        @if ($advanceTransactions->isNotEmpty())
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end">Total Received</td>
                    <td class="text-end">${{ number_format($totalReceived, 0) }}</td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        @endif
    </table>

    <h2>Advance &amp; Deposit — Applied to Bills</h2>
    <table class="data">
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>For Bill</th>
                <th class="text-end">From Advance</th>
                <th class="text-end">From Deposit</th>
                <th>Method</th>
                <th>Reference</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($deductionBills as $bill)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ optional($bill->paid_at)->format('d M Y') ?: '-' }}</td>
                    <td>{{ $bill->period->format('F Y') }}</td>
                    <td class="text-end">{!! (float) $bill->advance_used > 0 ? '<span class="blue bold">-$' . number_format($bill->advance_used, 0) . '</span>' : '<span class="muted">-</span>' !!}</td>
                    <td class="text-end">{!! (float) $bill->deposit_used > 0 ? '<span class="teal bold">-$' . number_format($bill->deposit_used, 0) . '</span>' : '<span class="muted">-</span>' !!}</td>
                    <td>{{ $bill->method ?: '-' }}</td>
                    <td>{{ $bill->reference ?: '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center muted">No advance/deposit deductions yet.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        This is a system-generated statement from {{ config('app.name') }} · {{ now()->format('d M Y H:i') }}
    </div>

</body>
</html>
