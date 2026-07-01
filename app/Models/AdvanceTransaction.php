<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdvanceTransaction extends Model
{
    protected $fillable = [
        'house_id',
        'type',
        'amount',
        'method',
        'reference',
        'note',
        'received_at',
    ];

    protected function casts(): array
    {
        return [
            'amount'      => 'decimal:2',
            'received_at' => 'date',
        ];
    }

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }

    /** Human label for the transaction type. */
    public function typeLabel(): string
    {
        return $this->type === 'deposit' ? 'Security Deposit' : 'Advance Balance';
    }
}
