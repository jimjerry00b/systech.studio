<?php

namespace App\Http\Controllers;

use App\Models\AdvanceTransaction;
use App\Models\House;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdvanceTransactionController extends Controller
{
    /**
     * Record a top-up to the renter's advance balance or security deposit.
     */
    public function store(Request $request, House $house)
    {
        $validated = $request->validate([
            'type'        => ['required', 'in:advance,deposit'],
            'amount'      => ['required', 'numeric', 'min:0.01'],
            'received_at' => ['nullable', 'date', 'before_or_equal:today'],
            'method'      => ['nullable', 'string', 'max:255'],
            'reference'   => ['nullable', 'string', 'max:255'],
            'note'        => ['nullable', 'string', 'max:255'],
        ]);

        $amount = round((float) $validated['amount'], 2);

        $house->advanceTransactions()->create([
            'type'        => $validated['type'],
            'amount'      => $amount,
            'method'      => $validated['method'] ?? null,
            'reference'   => $validated['reference'] ?? null,
            'note'        => $validated['note'] ?? null,
            'received_at' => $validated['received_at'] ?? now()->toDateString(),
        ]);

        // Keep the running balance in sync.
        if ($validated['type'] === 'deposit') {
            $house->increment('security_deposit', $amount);
            $target = 'security deposit';
        } else {
            $house->increment('advance_amount', $amount);
            $target = 'advance balance';
        }

        return redirect()
            ->route('houses.show', $house)
            ->with('message', '$' . number_format($amount, 0) . ' added to ' . $target . '.');
    }

    /**
     * Delete a top-up and reverse it from the running balance.
     */
    public function destroy(AdvanceTransaction $advance)
    {
        $house  = $advance->house;
        $amount = (float) $advance->amount;

        if ($advance->type === 'deposit') {
            $house->update(['security_deposit' => max(0, (float) $house->security_deposit - $amount)]);
        } else {
            $house->update(['advance_amount' => max(0, (float) $house->advance_amount - $amount)]);
        }

        $advance->delete();

        return redirect()
            ->route('houses.show', $house)
            ->with('message', 'Advance/deposit entry removed.');
    }

    /**
     * Download a PDF receipt for a single top-up transaction.
     */
    public function receipt(AdvanceTransaction $advance)
    {
        $advance->load('house');

        $pdf = Pdf::loadView('advances.receipt', compact('advance'))
            ->setPaper('a4', 'portrait');

        $filename = 'advance-receipt-' . Str::slug($advance->house->name) . '-' . $advance->id . '.pdf';

        return $pdf->download($filename);
    }
}
