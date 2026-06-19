<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LowStockNotification extends Notification
{
    use Queueable;

    protected string $productName;
    protected int $stockQuantity;

    public function __construct(string $productName, int $stockQuantity)
    {
        $this->productName = $productName;
        $this->stockQuantity = $stockQuantity;
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
            'title' => 'Low Stock Alert',
            'message' => $this->productName . ' is running low. Only ' . $this->stockQuantity . ' left.',
            'type' => 'low_stock',
            'icon' => '⚠️',
            'color' => 'orange',
            'action_text' => 'View Inventory',
            'action_url' => route('inventory.index'),
        ];
    }
}