<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * For VendWise FYP local testing:
     * The reset link is shown directly on the page instead of being sent by email.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'This account does not exist. Please check your email address or register first.',
                ]);
        }

        $token = Password::broker()->createToken($user);

        $resetLink = route('password.reset', [
            'token' => $token,
            'email' => $user->email,
        ]);

        return back()
            ->withInput($request->only('email'))
            ->with('status', 'Password reset link generated successfully.')
            ->with('reset_link', $resetLink);
    }
}