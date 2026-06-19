<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('deletion_request_status')->default('none')->after('status');
            $table->timestamp('deletion_requested_at')->nullable()->after('deletion_request_status');
            $table->timestamp('deletion_reviewed_at')->nullable()->after('deletion_requested_at');
            $table->text('deletion_rejection_reason')->nullable()->after('deletion_reviewed_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'deletion_request_status',
                'deletion_requested_at',
                'deletion_reviewed_at',
                'deletion_rejection_reason',
            ]);
        });
    }
};