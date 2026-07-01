<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('advance_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('house_id')->constrained()->cascadeOnDelete();
            $table->string('type');                     // advance | deposit
            $table->decimal('amount', 10, 2);
            $table->string('method')->nullable();
            $table->string('reference')->nullable();
            $table->string('note')->nullable();
            $table->date('received_at');
            $table->timestamps();

            $table->index(['house_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advance_transactions');
    }
};
