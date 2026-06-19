<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'vendor');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('business_name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('business_type') && $request->business_type !== 'all') {
            $query->where('business_type', $request->business_type);
        }

        if ($request->filled('deletion_status') && $request->deletion_status !== 'all') {
            $query->where('deletion_request_status', $request->deletion_status);
        }

        $vendors = $query->latest()->paginate(10)->withQueryString();

        $totalUsers = User::where('role', 'vendor')->count();

        $activeUsers = User::where('role', 'vendor')
            ->where('status', 'active')
            ->count();

        $inactiveUsers = User::where('role', 'vendor')
            ->where('status', 'deactivated')
            ->count();

        $newUsers = User::where('role', 'vendor')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $pendingDeletionRequests = User::where('role', 'vendor')
            ->where('deletion_request_status', 'pending')
            ->count();

        $deletionRequests = User::where('role', 'vendor')
            ->where('deletion_request_status', 'pending')
            ->latest('deletion_requested_at')
            ->get();

        $businessTypes = User::where('role', 'vendor')
            ->whereNotNull('business_type')
            ->where('business_type', '!=', '')
            ->select('business_type')
            ->distinct()
            ->orderBy('business_type')
            ->pluck('business_type');

        return view('admin.users.index', compact(
            'vendors',
            'totalUsers',
            'activeUsers',
            'inactiveUsers',
            'newUsers',
            'pendingDeletionRequests',
            'deletionRequests',
            'businessTypes'
        ));
    }

    public function toggleStatus(User $user)
    {
        if ($user->role !== 'vendor') {
            return redirect()->back()->with('error', 'Only vendor accounts can be updated.');
        }

        $newStatus = $user->status === 'active' ? 'deactivated' : 'active';

        $user->update([
            'status' => $newStatus,
        ]);

        SystemLog::create([
            'admin_id' => auth()->id(),
            'action' => $newStatus === 'active' ? 'Account Activation' : 'Account Deactivation',
            'description' => $newStatus === 'active'
                ? 'Activated account for Vendor #' . str_pad($user->id, 3, '0', STR_PAD_LEFT)
                : 'Deactivated account for Vendor #' . str_pad($user->id, 3, '0', STR_PAD_LEFT),
        ]);

        return redirect()->back()->with('success', 'Vendor status updated successfully.');
    }

    public function approveDeletionRequest(User $user)
    {
        if ($user->role !== 'vendor') {
            return redirect()->back()->with('error', 'Only vendor accounts can be updated.');
        }

        if ($user->deletion_request_status !== 'pending') {
            return redirect()->back()->with('warning', 'This vendor does not have a pending deletion request.');
        }

        /*
        |--------------------------------------------------------------------------
        | Important Logic
        |--------------------------------------------------------------------------
        | Do NOT deactivate the vendor immediately.
        | Admin approval only gives permission for the vendor to complete final deletion.
        | The vendor must login, enter password again, and permanently delete the account.
        */
        $user->update([
            'status' => 'active',
            'deletion_request_status' => 'approved',
            'deletion_reviewed_at' => now(),
            'deletion_rejection_reason' => null,
        ]);

        SystemLog::create([
            'admin_id' => auth()->id(),
            'action' => 'Account Deletion Request Approved',
            'description' => 'Approved account deletion request for Vendor #' . str_pad($user->id, 3, '0', STR_PAD_LEFT) . '. Vendor must complete final deletion from Settings.',
        ]);

        return redirect()->back()->with('success', 'Account deletion request approved. The vendor can now complete final deletion from their Settings page.');
    }

    public function rejectDeletionRequest(Request $request, User $user)
    {
        if ($user->role !== 'vendor') {
            return redirect()->back()->with('error', 'Only vendor accounts can be updated.');
        }

        if ($user->deletion_request_status !== 'pending') {
            return redirect()->back()->with('warning', 'This vendor does not have a pending deletion request.');
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ], [
            'rejection_reason.required' => 'Please enter a reason for rejecting this deletion request.',
        ]);

        $user->update([
            'deletion_request_status' => 'rejected',
            'deletion_reviewed_at' => now(),
            'deletion_rejection_reason' => $validated['rejection_reason'],
        ]);

        SystemLog::create([
            'admin_id' => auth()->id(),
            'action' => 'Account Deletion Request Rejected',
            'description' => 'Rejected account deletion request for Vendor #' . str_pad($user->id, 3, '0', STR_PAD_LEFT),
        ]);

        return redirect()->back()->with('success', 'Account deletion request rejected successfully.');
    }
}