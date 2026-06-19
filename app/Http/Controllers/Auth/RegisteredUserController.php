<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SystemSetting;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $settings = SystemSetting::first();

        if ($settings && !$settings->allow_vendor_registration) {
            abort(403, 'Vendor registration is currently disabled.');
        }

        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $settings = SystemSetting::first();

        if ($settings && !$settings->allow_vendor_registration) {
            return redirect()->route('login')
                ->with('error', 'Vendor registration is currently disabled by admin.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'business_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $defaultStatus = $settings?->default_vendor_status ?? 'active';

        $user = User::create([
            'name' => $request->name,
            'business_name' => $request->business_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'vendor',
            'status' => $defaultStatus,
        ]);

        event(new Registered($user));

        if ($defaultStatus !== 'active') {
            return redirect()->route('login')
                ->with('status', 'Registration successful. Your account is waiting for admin activation.');
        }

        return redirect()->route('login')
            ->with('status', 'Account created successfully. Please login to continue.');
    }
}