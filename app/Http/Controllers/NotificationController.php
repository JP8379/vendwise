<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $notifications = $user->notifications()
            ->latest()
            ->get();

        $unreadNotifications = $user->unreadNotifications()
            ->latest()
            ->get();

        $readNotifications = $user->readNotifications()
            ->latest()
            ->get();

        $unreadCount = $unreadNotifications->count();
        $totalCount = $notifications->count();
        $readCount = $readNotifications->count();

        return view('notifications.index', compact(
            'notifications',
            'unreadNotifications',
            'readNotifications',
            'unreadCount',
            'totalCount',
            'readCount'
        ));
    }

    public function markAllAsRead(): RedirectResponse
    {
        auth()->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }
}