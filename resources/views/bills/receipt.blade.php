@php
    $house    = $bill->house;
    $advUsed  = (float) $bill->advance_used;
    $depUsed  = (float) $bill->deposit_used;
    $cashPaid = max(0, (float) $bill->total - $advUsed - $depUsed);
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Receipt — {{ $house->name }} — {{ $bill->period->format('F Y') }}</title>
    <style>
        @page { margin: 32px 36px; }
        * { font-family: DejaVu Sans, sans-serif; }
        body { color: #222; font-size: 12px; margin: 0; }

        .header { border-bottom: 2px solid #4154f1; padding-bottom: 10px; margin-bottom: 16px; }
        .header .brand { font-size: 22px; font-weight: bold; color: #4154f1; }
        .header .doc-title { font-size: 14px; color: #555; margin-top: 2px; }
        .header .meta { font-size: 10px; color: #777; }

        h2 { font-size: 12px; color: #4154f1; margin: 18px 0 6px; text-transform: uppercase;
             border-bottom: 1px solid #e3e6f0; padding-bottom: 3px; }

        table { width: 100%; border-collapse: collapse; }
        .info td { padding: 4px 6px; vertical-align: top; }
        .info .label { color: #777; width: 130px; }

        .data th { background: #f6f7fb; border: 1px solid #e3e6f0; padding: 6px; text-align: left; font-size: 10px; }
        .data td { border: 1px solid #e3e6f0; padding: 6px; }
        .data .text-end { text-align: right; }
        .data tfoot td { background: #f6f7fb; font-weight: bold; }

        .text-end { text-align: right; }
        .muted { color: #999; }
        .bold { font-weight: bold; }

        .paid-stamp { display: inline-block; border: 2px solid #198754; color: #198754;
                      padding: 4px 14px; font-size: 16px; font-weight: bold; border-radius: 6px;
                      text-transform: uppercase; letter-spacing: 1px; }

        .total-box { margin-top: 12px; border: 1px solid #e3e6f0; border-radius: 4px; }
        .total-box td { padding: 8px 12px; }
        .total-box .grand { font-size: 16px; font-weight: bold; color: #4154f1; }

        .footer { margin-top: 30px; padding-top: 8px; border-top: 1px solid #e3e6f0;
                  font-size: 9px; color: #999; text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <table>
            <tr>
                <td>
                    <div class="brand">{{ config('app.name') }}</div>
                    <div class="doc-title">Payment Receipt</div>
                </td>
                <td class="text-end" style="vertical-align: bottom;">
                    <div class="meta">Receipt No: <strong>#{{ str_pad($bill->id, 5, '0', STR_PAD_LEFT) }}</strong></div>
                    <div class="meta">Date Paid: <strong>{{ optional($bill->paid_at)->format('d M Y') ?: '-' }}</strong></div>
                    <div class="meta">Issued: {{ now()->format('d M Y H:i') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <h2>Received From</h2>
    <table class="info">
        <tr>
            <td class="label">Renter</td><td>{{ $house->name }}</td>
            <td class="label">House / Unit</td><td>{{ $house->unit }}</td>
        </tr>
        <tr>
            <td class="label">Phone</td><td>{{ $house->phone ?: '-' }}</td>
            <td class="label">Billing Period</td><td>{{ $bill->period->format('F Y') }}</td>
        </tr>
    </table>

    <h2>Bill Breakdown</h2>
    <table class="data">
        <thead>
            <tr>
                <th>Description</th>
                <th class="text-end">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>Rent</td><td class="text-end">${{ number_format($bill->rent, 0) }}</td></tr>
            <tr><td>Water (WASA)</td><td class="text-end">${{ number_format($bill->water, 0) }}</td></tr>
            <tr><td>Electricity</td><td class="text-end">${{ number_format($bill->electricity, 0) }}</td></tr>
        </tbody>
        <tfoot>
            <tr><td class="text-end">Bill Total</td><td class="text-end">${{ number_format($bill->total, 0) }}</td></tr>
        </tfoot>
    </table>

    <h2>Payment Details</h2>
    <table class="data">
        <thead>
            <tr>
                <th>Source</th>
                <th class="text-end">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Cash / Other{{ $bill->method ? ' (' . $bill->method . ')' : '' }}</td>
                <td class="text-end">${{ number_format($cashPaid, 0) }}</td>
            </tr>
            <tr>
                <td>From Advance Balance</td>
                <td class="text-end">{{ $advUsed > 0 ? '$' . number_format($advUsed, 0) : '—' }}</td>
            </tr>
            <tr>
                <td>From Security Deposit</td>
                <td class="text-end">{{ $depUsed > 0 ? '$' . number_format($depUsed, 0) : '—' }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr><td class="text-end">Total Paid</td><td class="text-end">${{ number_format($bill->total, 0) }}</td></tr>
        </tfoot>
    </table>

    @if ($bill->reference)
        <p style="margin-top: 10px;"><span class="muted">Reference / Transaction ID:</span> <strong>{{ $bill->reference }}</strong></p>
    @endif

    <table class="total-box" style="margin-top: 18px;">
        <tr>
            <td>
                <span class="paid-stamp">Paid</span>
            </td>
            <td class="text-end">
                <span class="muted">Amount Received</span><br>
                <span class="grand">${{ number_format($bill->total, 0) }}</span>
            </td>
        </tr>
    </table>

    <div class="footer">
        This is a system-generated receipt from {{ config('app.name') }} · No signature required · {{ now()->format('d M Y H:i') }}
    </div>

</body>
</html>
