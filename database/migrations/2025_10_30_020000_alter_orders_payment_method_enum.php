<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Change enum from ['cash','qris'] to ['cash','transfer']
        DB::statement("ALTER TABLE `orders` MODIFY `payment_method` ENUM('cash','transfer') NOT NULL DEFAULT 'cash'");
    }

    public function down(): void
    {
        // Revert back to ['cash','qris'] if needed
        DB::statement("ALTER TABLE `orders` MODIFY `payment_method` ENUM('cash','qris') NOT NULL DEFAULT 'cash'");
    }
};
