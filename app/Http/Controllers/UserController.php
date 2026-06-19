<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Show all users (Admin only)
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // Create new user (optional - admin create)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user'
        ]);

        return back()->with('success', 'User created successfully');
    }

    //  Activate / Deactivate user
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        // if you have status column
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();

        return back()->with('success', 'User status updated');
    }

    //  Delete user
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'User deleted');
    }
}