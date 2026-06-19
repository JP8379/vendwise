<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable();
            }

            if (!Schema::hasColumn('users', 'business_name')) {
                $table->string('business_name')->nullable();
            }

            if (!Schema::hasColumn('users', 'business_type')) {
                $table->string('business_type')->nullable();
            }

            if (!Schema::hasColumn('users', 'tax_id')) {
                $table->string('tax_id')->nullable();
            }

            if (!Schema::hasColumn('users', 'city')) {
                $table->string('city')->nullable();
            }

            if (!Schema::hasColumn('users', 'country')) {
                $table->string('country')->nullable();
            }

        });
    }

    public function down(): void
    {
        // Optional: leave empty (safe)
    }
};