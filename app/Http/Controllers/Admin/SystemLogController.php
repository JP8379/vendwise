<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemLog;
use Illuminate\Http\Request;

class SystemLogController extends Controller
{
    public function index(Request $request)
    {
        $query = SystemLog::with('admin')->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('action', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('action') && $request->action !== 'all') {
            $query->where('action', $request->action);
        }

        $logs = $query->paginate(10)->withQueryString();

        $totalLogs = SystemLog::count();

        $todayLogs = SystemLog::whereDate('created_at', today())->count();

        $activationLogs = SystemLog::where('action', 'like', '%Activation%')->count();

        $deactivationLogs = SystemLog::where('action', 'like', '%Deactivation%')->count();

        $actions = SystemLog::select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        return view('admin.logs.index', compact(
            'logs',
            'totalLogs',
            'todayLogs',
            'activationLogs',
            'deactivationLogs',
            'actions'
        ));
    }
}