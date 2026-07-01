<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\House;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BillController extends Controller
{
    /**
     * Download a payment receipt (PDF) for a single paid bill.
     */
    public function receipt(Bill $bill)
    {
        $bill->load('house');

        $pdf = Pdf::loadView('bills.receipt', compact('bill'))
            ->setPaper('a4', 'portrait');

        $filename = 'receipt-' . Str::slug($bill->house->name) . '-' . $bill->period->format('Y-m') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Generate (store) a new monthly bill for a house.
     * Rent and water are fixed (pulled from the house); electricity varies.
     */
    public function store(Request $request, House $house)
    {
        $validated = $request->validate([
            'period' => ['required', 'date'],
            'electricity' => ['required', 'numeric', 'min:0'],
            'due_date' => ['nullable', 'date'],
        ]);

        // Normalise the period to the first day of its month.
        $period = \Illuminate\Support\Carbon::parse($validated['period'])->startOfMonth();

        $house->bills()->updateOrCreate(
            ['period' => $period],
            [
                'rent' => $house->rent_amount,
                'water' => $house->water_amount,
                'electricity' => $validated['electricity'],
                'due_date' => $validated['due_date'] ?? $period->copy()->addDays(20),
                'status' => 'unpaid',
            ]
        );

        return redirect()
            ->route('houses.show', $house)
            ->with('message', 'Monthly bill generated for ' . $period->format('F Y') . '.');
    }

    /**
     * Record a payment for a bill. The bill total is always covered. Part of it
     * may be paid by deducting from the renter's advance balance and/or security
     * deposit; the remainder is paid as cash/other. Deductions decrement the
     * corresponding house balance.
     */
    public function update(Request $request, Bill $bill)
    {
        $house     = $bill->house;
        $billTotal = (float) $bill->total;

        $validated = $request->validate([
            'advance_used' => ['nullable', 'numeric', 'min:0', 'max:' . (float) $house->advance_amount],
            'deposit_used' => ['nullable', 'numeric', 'min:0', 'max:' . (float) $house->security_deposit],
            'paid_date'    => ['nullable', 'date', 'before_or_equal:today'],
            'method'       => ['nullable', 'string', 'max:255'],
            'reference'    => ['nullable', 'string', 'max:255'],
        ], [
            'advance_used.max' => 'Amount from advance cannot exceed the available balance of $' . number_format($house->advance_amount, 0) . '.',
            'deposit_used.max' => 'Amount from deposit cannot exceed the available balance of $' . number_format($house->security_deposit, 0) . '.',
        ]);

        $advanceUsed = round((float) ($validated['advance_used'] ?? 0), 2);
        $depositUsed = round((float) ($validated['deposit_used'] ?? 0), 2);
        $paidAt      = ! empty($validated['paid_date'])
            ? \Illuminate\Support\Carbon::parse($validated['paid_date'])
            : now();

        if ($advanceUsed + $depositUsed > $billTotal) {
            return back()->withErrors([
                'advance_used' => 'Advance + deposit ($' . number_format($advanceUsed + $depositUsed, 0)
                    . ') cannot exceed the bill total of $' . number_format($billTotal, 0) . '.',
            ]);
        }

        $bill->update([
            'status'       => 'paid',
            'paid_amount'  => $billTotal,
            'advance_used' => $advanceUsed,
            'deposit_used' => $depositUsed,
            'method'       => $validated['method'] ?? null,
            'reference'    => $validated['reference'] ?? null,
            'paid_at'      => $paidAt,
        ]);

        if ($advanceUsed > 0) {
            $house->decrement('advance_amount', $advanceUsed);
        }
        if ($depositUsed > 0) {
            $house->decrement('security_deposit', $depositUsed);
        }

        $cash  = round($billTotal - $advanceUsed - $depositUsed, 2);
        $parts = [];
        if ($cash > 0)        $parts[] = '$' . number_format($cash, 0) . ' cash/other';
        if ($advanceUsed > 0) $parts[] = '$' . number_format($advanceUsed, 0) . ' from advance';
        if ($depositUsed > 0) $parts[] = '$' . number_format($depositUsed, 0) . ' from deposit';

        $flash = 'Bill for ' . $bill->period->format('F Y') . ' marked paid'
            . (count($parts) ? ' (' . implode(', ', $parts) . ')' : '') . '.';

        return redirect()
            ->route('houses.show', $house)
            ->with('message', $flash);
    }

    /**
     * Remove a bill.
     */
    public function destroy(Bill $bill)
    {
        $houseId = $bill->house_id;
        $bill->delete();

        return redirect()
            ->route('houses.show', $houseId)
            ->with('message', 'Bill deleted.');
    }
}
