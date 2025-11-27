<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the old unique index on email if it exists
            try {
                $table->dropUnique('users_email_unique');
            } catch (\Throwable $e) {
                // ignore if index doesn't exist
            }
            // Add composite unique on (email, deleted_at) to allow reuse after soft delete
            $table->unique(['email', 'deleted_at'], 'users_email_deleted_at_unique');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop composite unique and restore single unique on email
            try {
                $table->dropUnique('users_email_deleted_at_unique');
            } catch (\Throwable $e) {
                // ignore
            }
            $table->unique('email', 'users_email_unique');
        });
    }
};
