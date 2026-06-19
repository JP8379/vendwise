<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SupportTicket;
use App\Models\SystemLog;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalVendors = User::where('role', 'vendor')->count();

        $activeVendors = User::where('role', 'vendor')
            ->where('status', 'active')
            ->count();

        $deactivatedVendors = User::where('role', 'vendor')
            ->where('status', 'deactivated')
            ->count();

        $pendingTickets = SupportTicket::where('status', 'pending')->count();

        $resolvedTickets = SupportTicket::where('status', 'resolved')->count();

        $todayLogs = SystemLog::whereDate('created_at', today())->count();

        $recentVendors = User::where('role', 'vendor')
            ->latest()
            ->take(5)
            ->get();

        $recentLogs = SystemLog::with('admin')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalVendors',
            'activeVendors',
            'deactivatedVendors',
            'pendingTickets',
            'resolvedTickets',
            'todayLogs',
            'recentVendors',
            'recentLogs'
        ));
    }
}