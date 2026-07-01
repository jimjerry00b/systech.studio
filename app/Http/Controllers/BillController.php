<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\House;
use Illuminate\Http\Request;

class BillController extends Controller
{
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
     * Record a payment for a bill.
     * Paid amount must be >= bill total; any excess is added to the house's security deposit.
     */
    public function update(Request $request, Bill $bill)
    {
        $billTotal = (float) $bill->total;

        $validated = $request->validate([
            'paid_amount' => ['required', 'numeric', 'min:' . $billTotal],
            'method'      => ['nullable', 'string', 'max:255'],
            'reference'   => ['nullable', 'string', 'max:255'],
        ], [
            'paid_amount.min' => 'Payment must cover the full bill amount of $' . number_format($billTotal, 0) . '.',
        ]);

        $overpayment = round((float) $validated['paid_amount'] - $billTotal, 2);

        $bill->update([
            'status'      => 'paid',
            'paid_amount' => $validated['paid_amount'],
            'method'      => $validated['method'] ?? $bill->method,
            'reference'   => $validated['reference'] ?? $bill->reference,
            'paid_at'     => now(),
        ]);

        $flash = 'Payment of $' . number_format($validated['paid_amount'], 0) . ' recorded.';

        if ($overpayment > 0) {
            $bill->house->increment('security_deposit', $overpayment);
            $flash .= ' Overpayment of $' . number_format($overpayment, 0) . ' added to security deposit.';
        }

        return redirect()
            ->route('houses.show', $bill->house_id)
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
