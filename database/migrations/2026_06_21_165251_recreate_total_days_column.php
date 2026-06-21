<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn('total_days');
        });

        Schema::table('rentals', function (Blueprint $table) {
            $table->integer('total_days')->after('end_date');
        });
    }

    public function down(): void
    {
        //
    }
};