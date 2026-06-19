<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'admin_reply',
        'replied_at',
        'priority',
        'status',
    ];

    /**
     * Get the vendor who created the ticket
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}