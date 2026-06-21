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
            $table->string('ktp_file', 255)->nullable()->after('phone');
            $table->string('sim_file', 255)->nullable()->after('ktp_file');
            $table->boolean('airport_pickup')->default(false)->after('sim_file');
            $table->boolean('with_driver')->default(false)->after('airport_pickup');
            $table->boolean('keyless')->default(false)->after('with_driver');
            $table->decimal('addon_fees', 10, 2)->default(0.00)->after('keyless');
            $table->string('pickup_location', 255)->nullable()->after('addon_fees');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn([
                'ktp_file',
                'sim_file',
                'airport_pickup',
                'with_driver',
                'keyless',
                'addon_fees',
                'pickup_location'
            ]);
        });
    }
};
