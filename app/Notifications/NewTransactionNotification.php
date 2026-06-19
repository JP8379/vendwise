<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewTransactionNotification extends Notification
{
    use Queueable;

    protected $type;
    protected $category;
    protected $amount;

    public function __construct($type, $category, $amount)
    {
        $this->type = $type;
        $this->category = $category;
        $this->amount = $amount;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Transaction Added',
            'message' => 'You added a new ' . ucfirst($this->type) . ' transaction for ' . $this->category . ' (RM ' . number_format($this->amount, 2) . ').',
        ];
    }
}