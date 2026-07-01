<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class House extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'photo',
        'nid_copy',
        'unit',
        'rent_amount',
        'water_amount',
        'security_deposit',
        'advance_amount',
        'electric_meter_number',
        'electric_account_number',
        'gas_meter_number',
        'lease_start',
        'lease_end',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'rent_amount' => 'decimal:2',
            'water_amount' => 'decimal:2',
            'security_deposit' => 'decimal:2',
            'advance_amount' => 'decimal:2',
            'lease_start' => 'date',
            'lease_end' => 'date',
        ];
    }

    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class)->orderByDesc('period');
    }

    /** Total amount billed across all bills. */
    public function totalBilled(): float
    {
        return (float) $this->bills->sum('total');
    }

    /** Outstanding (unpaid) amount across all bills. */
    public function outstanding(): float
    {
        return (float) $this->bills->where('status', 'unpaid')->sum('total');
    }

    /**
     * Renter phone formatted for a wa.me / WhatsApp link: digits only,
     * in international format (country code, no leading zero). Returns an
     * empty string when no phone is set.
     */
    public function whatsappPhone(): string
    {
        $digits = preg_replace('/\D+/', '', (string) $this->phone);

        if ($digits === '') {
            return '';
        }

        $countryCode = (string) config('whatsapp.country_code', '880');

        // Already in international form (starts with the country code).
        if (str_starts_with($digits, $countryCode)) {
            return $digits;
        }

        // Local form (e.g. 01712...) -> drop leading zero(s), prepend code.
        return $countryCode . ltrim($digits, '0');
    }
}
