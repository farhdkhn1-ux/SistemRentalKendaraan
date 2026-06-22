<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('rentals', function (Blueprint $table) {

        if (!Schema::hasColumn('rentals', 'user_id')) {
            $table->unsignedBigInteger('user_id')->nullable()->after('vehicle_id');
        }

        if (!Schema::hasColumn('rentals', 'ktp_file')) {
            $table->string('ktp_file')->nullable()->after('phone');
        }

        if (!Schema::hasColumn('rentals', 'sim_file')) {
            $table->string('sim_file')->nullable()->after('ktp_file');
        }

        if (!Schema::hasColumn('rentals', 'airport_pickup')) {
            $table->boolean('airport_pickup')->default(false)->after('sim_file');
        }

        if (!Schema::hasColumn('rentals', 'with_driver')) {
            $table->boolean('with_driver')->default(false)->after('airport_pickup');
        }

        if (!Schema::hasColumn('rentals', 'keyless')) {
            $table->boolean('keyless')->default(false)->after('with_driver');
        }

        if (!Schema::hasColumn('rentals', 'addon_fees')) {
            $table->decimal('addon_fees', 12, 2)->default(0)->after('keyless');
        }

        if (!Schema::hasColumn('rentals', 'pickup_location')) {
            $table->string('pickup_location')->nullable()->after('addon_fees');
        }
    });
}

    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropForeign(['user_id']);

            $table->dropColumn([
                'user_id',
                'ktp_file',
                'sim_file',
                'airport_pickup',
                'with_driver',
                'keyless',
                'addon_fees',
                'pickup_location',
            ]);
        });
    }
};