<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OutOfStockNotification extends Notification
{
    use Queueable;

    protected string $productName;

    public function __construct(string $productName)
    {
        $this->productName = $productName;
    }

    public function via($notifiable): array
    {
        // For now, use database only.
        // Email can be added later when mail setup is ready.
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'title' => 'Out of Stock',
            'message' => $this->productName . ' is out of stock. Please restock immediately.',
            'type' => 'out_of_stock',
            'icon' => '🚨',
            'color' => 'red',
            'action_text' => 'View Inventory',
            'action_url' => route('inventory.index'),
        ];
    }
}