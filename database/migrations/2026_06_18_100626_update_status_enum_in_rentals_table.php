<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE rentals MODIFY COLUMN status ENUM('pending','active','returned','cancelled') DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE rentals MODIFY COLUMN status ENUM('active','returned','cancelled') DEFAULT 'active'");
    }
};