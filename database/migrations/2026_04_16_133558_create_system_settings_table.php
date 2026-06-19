<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('system_name')->default('VendWise');
            $table->string('system_email')->nullable();
            $table->string('currency')->default('RM');
            $table->string('timezone')->default('Asia/Kuala_Lumpur');
            $table->boolean('allow_vendor_registration')->default(true);
            $table->string('default_vendor_status')->default('active');
            $table->boolean('email_notifications')->default(false);
            $table->boolean('system_notifications')->default(true);
            $table->timestamps();
        });

        DB::table('system_settings')->insert([
            'system_name' => 'VendWise',
            'system_email' => 'admin@vendwise.com',
            'currency' => 'RM',
            'timezone' => 'Asia/Kuala_Lumpur',
            'allow_vendor_registration' => true,
            'default_vendor_status' => 'active',
            'email_notifications' => false,
            'system_notifications' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};