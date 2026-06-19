<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'business_name',
        'email',
        'phone',
        'phone_number',
        'password',
        'role',
        'status',

        // Business profile fields
        'business_type',
        'tax_id',
        'city',
        'country',

        // Account deletion request fields
        'deletion_request_status',
        'deletion_requested_at',
        'deletion_reviewed_at',
        'deletion_rejection_reason',

        // New user flag
        'is_new',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'deletion_requested_at' => 'datetime',
            'deletion_reviewed_at' => 'datetime',
        ];
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is active.
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Get unread notifications count for sidebar badge.
     */
    public function unreadNotificationsCount()
    {
        return $this->unreadNotifications()->count();
    }
}