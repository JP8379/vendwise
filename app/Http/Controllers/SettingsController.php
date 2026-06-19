<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('settings.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:30',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->save();

        return back()->with('success', 'Profile information updated successfully.');
    }

    public function updateBusiness(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'business_name' => 'nullable|string|max:255',
            'business_type' => 'nullable|string|max:255',
            'tax_id' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
        ]);

        $user->business_name = $validated['business_name'] ?? null;
        $user->business_type = $validated['business_type'] ?? null;
        $user->tax_id = $validated['tax_id'] ?? null;
        $user->city = $validated['city'] ?? null;
        $user->country = $validated['country'] ?? null;
        $user->save();

        return back()->with('success', 'Business information updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()
                ->withInput()
                ->withErrors([
                    'current_password' => 'Please enter your correct current password.',
                ]);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password updated successfully.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'delete_password' => 'required',
        ], [
            'delete_password.required' => 'Please enter your password before continuing.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->delete_password, $user->password)) {
            return back()
                ->withInput()
                ->withErrors([
                    'delete_password' => 'Please enter the correct password to continue.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Final delete after admin approval
        |--------------------------------------------------------------------------
        */
        if ($user->deletion_request_status === 'approved') {
            Auth::logout();

            $user->delete();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/')
                ->with('success', 'Your account has been permanently deleted.');
        }

        /*
        |--------------------------------------------------------------------------
        | Prevent duplicate pending request
        |--------------------------------------------------------------------------
        */
        if ($user->deletion_request_status === 'pending') {
            return back()->with('warning', 'Your account deletion request is already pending admin approval.');
        }

        /*
        |--------------------------------------------------------------------------
        | Submit deletion request
        |--------------------------------------------------------------------------
        */
        $user->update([
            'deletion_request_status' => 'pending',
            'deletion_requested_at' => now(),
            'deletion_reviewed_at' => null,
            'deletion_rejection_reason' => null,
        ]);

        return back()->with('success', 'Account deletion request submitted successfully. Admin will review your request before any account action is taken.');
    }
}