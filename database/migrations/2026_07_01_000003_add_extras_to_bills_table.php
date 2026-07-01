<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->decimal('advance_extra', 10, 2)->default(0)->after('paid_amount');
            $table->decimal('deposit_extra', 10, 2)->default(0)->after('advance_extra');
        });
    }

    public function down(): void
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->dropColumn(['advance_extra', 'deposit_extra']);
        });
    }
};
