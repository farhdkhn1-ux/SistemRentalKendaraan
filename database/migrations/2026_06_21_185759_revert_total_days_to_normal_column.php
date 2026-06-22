<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE rentals
            MODIFY total_days INT NOT NULL
        ");
    }

    public function down(): void
    {
        //
    }
};