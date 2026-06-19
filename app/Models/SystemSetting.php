<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $fillable = [
        'system_name',
        'system_email',
        'currency',
        'timezone',
        'allow_vendor_registration',
        'default_vendor_status',
        'email_notifications',
        'system_notifications',
    ];
}