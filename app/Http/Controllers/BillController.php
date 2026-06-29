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
     * Mark a bill as paid (or update its payment details).
     */
    public function update(Request $request, Bill $bill)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:paid,unpaid'],
            'method' => ['nullable', 'string', 'max:255'],
            'reference' => ['nullable', 'string', 'max:255'],
        ]);

        $bill->update([
            'status' => $validated['status'],
            'method' => $validated['method'] ?? $bill->method,
            'reference' => $validated['reference'] ?? $bill->reference,
            'paid_at' => $validated['status'] === 'paid' ? now() : null,
        ]);

        return redirect()
            ->route('houses.show', $bill->house_id)
            ->with('message', 'Bill updated.');
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
