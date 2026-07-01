@php
    $house = $advance->house;
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Advance Receipt — {{ $house->name }}</title>
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
        .info .label { color: #777; width: 140px; }

        .text-end { text-align: right; }
        .muted { color: #999; }

        .total-box { margin-top: 18px; border: 1px solid #e3e6f0; border-radius: 4px; }
        .total-box td { padding: 8px 12px; }
        .total-box .grand { font-size: 16px; font-weight: bold; color: #198754; }

        .stamp { display: inline-block; border: 2px solid #198754; color: #198754;
                 padding: 4px 14px; font-size: 15px; font-weight: bold; border-radius: 6px;
                 text-transform: uppercase; letter-spacing: 1px; }

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
                    <div class="doc-title">Advance / Deposit Receipt</div>
                </td>
                <td class="text-end" style="vertical-align: bottom;">
                    <div class="meta">Receipt No: <strong>#A{{ str_pad($advance->id, 5, '0', STR_PAD_LEFT) }}</strong></div>
                    <div class="meta">Date Received: <strong>{{ optional($advance->received_at)->format('d M Y') ?: '-' }}</strong></div>
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
            <td class="label">Payment Method</td><td>{{ $advance->method ?: '-' }}</td>
        </tr>
    </table>

    <h2>Details</h2>
    <table class="info">
        <tr>
            <td class="label">Credited To</td><td>{{ $advance->typeLabel() }}</td>
        </tr>
        <tr>
            <td class="label">Reference</td><td>{{ $advance->reference ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Note</td><td>{{ $advance->note ?: '-' }}</td>
        </tr>
    </table>

    <table class="total-box">
        <tr>
            <td>
                <span class="stamp">Received</span>
            </td>
            <td class="text-end">
                <span class="muted">Amount Received ({{ $advance->typeLabel() }})</span><br>
                <span class="grand">${{ number_format($advance->amount, 0) }}</span>
            </td>
        </tr>
    </table>

    <div class="footer">
        This is a system-generated receipt from {{ config('app.name') }} · No signature required · {{ now()->format('d M Y H:i') }}
    </div>

</body>
</html>
