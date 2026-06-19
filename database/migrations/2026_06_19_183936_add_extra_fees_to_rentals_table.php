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
            $table->decimal('fee_lost_key', 12, 2)->default(0)->after('late_fee');
            $table->decimal('fee_scratch_dent', 12, 2)->default(0)->after('fee_lost_key');
            $table->decimal('fee_lost_stnk', 12, 2)->default(0)->after('fee_scratch_dent');
            $table->decimal('fee_lost_etoll', 12, 2)->default(0)->after('fee_lost_stnk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn(['fee_lost_key', 'fee_scratch_dent', 'fee_lost_stnk', 'fee_lost_etoll']);
        });
    }
};
