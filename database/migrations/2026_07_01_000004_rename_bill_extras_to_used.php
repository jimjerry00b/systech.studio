<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->renameColumn('advance_extra', 'advance_used');
            $table->renameColumn('deposit_extra', 'deposit_used');
        });

        // The columns previously meant "amount added to the balance"; they now mean
        // "amount deducted from the balance to pay this bill". Old values are invalid
        // under the inverted semantics, so reset them.
        DB::table('bills')->update([
            'advance_used' => 0,
            'deposit_used' => 0,
        ]);
    }

    public function down(): void
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->renameColumn('advance_used', 'advance_extra');
            $table->renameColumn('deposit_used', 'deposit_extra');
        });
    }
};
