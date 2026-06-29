<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('house_id')->constrained()->cascadeOnDelete();
            $table->date('period');                              // first day of the billed month
            $table->decimal('rent', 10, 2)->default(0);          // fixed
            $table->decimal('water', 10, 2)->default(0);         // fixed (WASA)
            $table->decimal('electricity', 10, 2)->default(0);   // varies each month
            $table->decimal('total', 10, 2)->default(0);         // rent + water + electricity
            $table->date('due_date')->nullable();
            $table->string('status')->default('unpaid');         // unpaid, paid
            $table->string('method')->nullable();                // payment method once paid
            $table->string('reference')->nullable();
            $table->date('paid_at')->nullable();
            $table->timestamps();

            $table->unique(['house_id', 'period']); // one bill per house per month
            $table->index(['house_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
