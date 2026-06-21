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
        Schema::table('vehicles', function (Blueprint $table) {
            $table->enum('transmission', ['Manual', 'Matic'])->default('Manual')->after('color');
            $table->integer('luggage_capacity')->default(2)->after('transmission');
            $table->string('pick_up_location', 100)->default('Bandara Minangkabau')->after('luggage_capacity');
            $table->text('features')->nullable()->after('pick_up_location');
            $table->string('photo', 255)->nullable()->after('features');
            $table->date('stnk_expiration')->nullable()->after('status');
            $table->date('insurance_expiration')->nullable()->after('stnk_expiration');
            $table->date('service_schedule')->nullable()->after('insurance_expiration');
            $table->decimal('seasonal_price', 10, 2)->nullable()->after('daily_rate');
            $table->date('seasonal_start')->nullable()->after('seasonal_price');
            $table->date('seasonal_end')->nullable()->after('seasonal_start');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn([
                'transmission',
                'luggage_capacity',
                'pick_up_location',
                'features',
                'photo',
                'stnk_expiration',
                'insurance_expiration',
                'service_schedule',
                'seasonal_price',
                'seasonal_start',
                'seasonal_end'
            ]);
        });
    }
};
