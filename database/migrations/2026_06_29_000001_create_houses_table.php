<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->string('name');                 // renter full name
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('unit');                  // e.g. "House A-12"
            $table->decimal('rent_amount', 10, 2)->default(0);   // fixed monthly rent
            $table->decimal('water_amount', 10, 2)->default(0);  // fixed monthly WASA water
            $table->decimal('security_deposit', 10, 2)->default(0);
            $table->string('electric_meter_number')->nullable();
            $table->string('electric_account_number')->nullable();
            $table->string('gas_meter_number')->nullable();
            $table->string('water_meter_number')->nullable();
            $table->string('water_account_number')->nullable();
            $table->date('lease_start')->nullable();
            $table->date('lease_end')->nullable();
            $table->string('status')->default('active'); // active, pending, expired
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};
