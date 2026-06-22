<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->string('payment_proof')->nullable()->after('sim_file');
            $table->decimal('dp_amount', 12, 2)->nullable()->after('total_cost');
            $table->decimal('remaining_amount', 12, 2)->nullable()->after('dp_amount');
            $table->enum('payment_status', ['pending', 'paid'])->default('pending')->after('remaining_amount');
        });
    }

    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn([
                'payment_proof',
                'dp_amount',
                'remaining_amount',
                'payment_status'
            ]);
        });
    }
};