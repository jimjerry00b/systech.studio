<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HouseRentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $houses = House::whereIn('status', ['active', 'pending'])->latest()->get();

        return view('houses.index', compact('houses'));
    }

    public function inactive()
    {
        $houses = House::where('status', 'expired')->latest()->get();

        return view('houses.inactive', compact('houses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('houses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'nid_copy' => ['nullable', 'image', 'max:4096'],
            'unit' => ['required', 'string', 'max:255'],
            'rent_amount' => ['required', 'numeric', 'min:0'],
            'water_amount' => ['required', 'numeric', 'min:0'],
            'security_deposit' => ['nullable', 'numeric', 'min:0'],
            'advance_amount' => ['nullable', 'numeric', 'min:0'],
            'electric_meter_number' => ['nullable', 'string', 'max:255'],
            'electric_account_number' => ['nullable', 'string', 'max:255'],
            'gas_meter_number' => ['nullable', 'string', 'max:255'],
            'water_meter_number' => ['nullable', 'string', 'max:255'],
            'water_account_number' => ['nullable', 'string', 'max:255'],
            'lease_start' => ['nullable', 'date'],
            'lease_end' => ['nullable', 'date', 'after_or_equal:lease_start'],
            'status' => ['required', 'in:active,pending,expired'],
        ]);

        $validated['security_deposit'] = $validated['security_deposit'] ?? 0;
        $validated['advance_amount'] = $validated['advance_amount'] ?? 0;

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('renters/photos', 'public');
        }
        if ($request->hasFile('nid_copy')) {
            $validated['nid_copy'] = $request->file('nid_copy')->store('renters/nid', 'public');
        }

        $house = House::create($validated);

        return redirect()
            ->route('houses.show', $house)
            ->with('message', 'Renter “' . $house->name . '” added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(House $house)
    {
        $house->load('bills');

        return view('houses.show', compact('house'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(House $house)
    {
        return view('houses.edit', compact('house'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, House $house)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'nid_copy' => ['nullable', 'image', 'max:4096'],
            'unit' => ['required', 'string', 'max:255'],
            'rent_amount' => ['required', 'numeric', 'min:0'],
            'water_amount' => ['required', 'numeric', 'min:0'],
            'security_deposit' => ['nullable', 'numeric', 'min:0'],
            'advance_amount' => ['nullable', 'numeric', 'min:0'],
            'electric_meter_number' => ['nullable', 'string', 'max:255'],
            'electric_account_number' => ['nullable', 'string', 'max:255'],
            'gas_meter_number' => ['nullable', 'string', 'max:255'],
            'lease_start' => ['nullable', 'date'],
            'lease_end' => ['nullable', 'date', 'after_or_equal:lease_start'],
            'status' => ['required', 'in:active,pending,expired'],
        ]);

        $validated['security_deposit'] = $validated['security_deposit'] ?? 0;
        $validated['advance_amount'] = $validated['advance_amount'] ?? 0;

        if ($request->hasFile('photo')) {
            if ($house->photo) Storage::disk('public')->delete($house->photo);
            $validated['photo'] = $request->file('photo')->store('renters/photos', 'public');
        }
        if ($request->hasFile('nid_copy')) {
            if ($house->nid_copy) Storage::disk('public')->delete($house->nid_copy);
            $validated['nid_copy'] = $request->file('nid_copy')->store('renters/nid', 'public');
        }

        $house->update($validated);

        return redirect()
            ->route('houses.show', $house)
            ->with('message', 'Renter “' . $house->name . '” updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(House $house)
    {
        if ($house->photo) Storage::disk('public')->delete($house->photo);
        if ($house->nid_copy) Storage::disk('public')->delete($house->nid_copy);

        $house->delete();

        return redirect()
            ->route('houses.index')
            ->with('message', 'Renter removed.');
    }
}
