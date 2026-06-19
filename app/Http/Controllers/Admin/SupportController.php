<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SystemLog;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index(Request $request)
    {
        $query = SupportTicket::with('user')->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('message', 'like', '%' . $search . '%')
                  ->orWhere('admin_reply', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%')
                          ->orWhere('business_name', 'like', '%' . $search . '%')
                          ->orWhere('email', 'like', '%' . $search . '%');
                  });
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $tickets = $query->paginate(10)->withQueryString();

        $totalTickets = SupportTicket::count();

        $pendingTickets = SupportTicket::where('status', 'pending')->count();

        $resolvedTickets = SupportTicket::where('status', 'resolved')->count();

        $todayTickets = SupportTicket::whereDate('created_at', today())->count();

        return view('admin.support.index', compact(
            'tickets',
            'totalTickets',
            'pendingTickets',
            'resolvedTickets',
            'todayTickets'
        ));
    }

    /**
     * Admin reply to support ticket
     */
    public function reply(Request $request, $id)
    {
        $request->validate([
            'admin_reply' => 'required|string|max:2000',
        ]);

        $ticket = SupportTicket::findOrFail($id);

        $ticket->update([
            'admin_reply' => $request->admin_reply,
            'replied_at' => now(),
            'status' => 'resolved',
        ]);

        SystemLog::create([
            'admin_id' => auth()->id(),
            'action' => 'Support Reply',
            'description' => 'Replied to ticket #' . $ticket->id .
                ' for Vendor #' . str_pad($ticket->user_id, 3, '0', STR_PAD_LEFT),
        ]);

        return redirect()->back()->with('success', 'Reply sent successfully.');
    }

    /**
     * Resolve ticket manually
     */
    public function resolve($id)
    {
        $ticket = SupportTicket::findOrFail($id);

        if ($ticket->status === 'resolved') {
            return redirect()->back()->with('error', 'This ticket has already been resolved.');
        }

        $ticket->update([
            'status' => 'resolved',
        ]);

        SystemLog::create([
            'admin_id' => auth()->id(),
            'action' => 'Support Resolved',
            'description' => 'Resolved ticket #' . $ticket->id .
                ' for Vendor #' . str_pad($ticket->user_id, 3, '0', STR_PAD_LEFT),
        ]);

        return redirect()->back()->with('success', 'Ticket resolved successfully.');
    }
}