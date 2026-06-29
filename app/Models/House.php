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
        'unit',
        'rent_amount',
        'water_amount',
        'security_deposit',
        'electric_meter_number',
        'electric_account_number',
        'gas_meter_number',
        'water_meter_number',
        'water_account_number',
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
}
