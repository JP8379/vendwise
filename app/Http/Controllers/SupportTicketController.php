<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    public function index()
    {
        $tickets = SupportTicket::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('support.index', compact('tickets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
            'priority' => 'required|in:low,medium,high',
        ]);

        SupportTicket::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'message' => $request->message,
            'priority' => $request->priority,
            'status' => 'pending',
        ]);

        return redirect()->route('support.index')
            ->with('success', 'Support ticket submitted successfully.');
    }
}