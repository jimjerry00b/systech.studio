<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bill extends Model
{
    protected $fillable = [
        'house_id',
        'period',
        'rent',
        'water',
        'electricity',
        'total',
        'due_date',
        'status',
        'method',
        'reference',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'period' => 'date',
            'due_date' => 'date',
            'paid_at' => 'date',
            'rent' => 'decimal:2',
            'water' => 'decimal:2',
            'electricity' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        // Always keep the total authoritative: rent + water + electricity.
        static::saving(function (Bill $bill) {
            $bill->total = (float) $bill->rent + (float) $bill->water + (float) $bill->electricity;
        });
    }

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }

    public function scopeUnpaid(Builder $query): Builder
    {
        return $query->where('status', 'unpaid');
    }

    public function scopePaid(Builder $query): Builder
    {
        return $query->where('status', 'paid');
    }
}
