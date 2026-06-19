<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->date('returned_date')->nullable()->after('end_date');
            $table->integer('late_days')->default(0)->after('total_days');
            $table->decimal('late_fee', 12, 2)->default(0)->after('total_cost');
            $table->decimal('total_final', 12, 2)->nullable()->after('late_fee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn(['returned_date', 'late_days', 'late_fee', 'total_final']);
        });
    }
};
