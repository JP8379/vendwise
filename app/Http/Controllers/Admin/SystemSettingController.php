<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use App\Models\SystemLog;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
    public function index()
    {
        $settings = SystemSetting::first();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'system_name' => 'required|string|max:255',
            'system_email' => 'nullable|email|max:255',
            'currency' => 'required|string|max:10',
            'timezone' => 'required|string|max:100',
            'default_vendor_status' => 'required|in:active,deactivated',
        ]);

        $settings = SystemSetting::first();

        $settings->update([
            'system_name' => $request->system_name,
            'system_email' => $request->system_email,
            'currency' => $request->currency,
            'timezone' => $request->timezone,
            'allow_vendor_registration' => $request->has('allow_vendor_registration'),
            'default_vendor_status' => $request->default_vendor_status,
            'email_notifications' => $request->has('email_notifications'),
            'system_notifications' => $request->has('system_notifications'),
        ]);

        SystemLog::create([
            'admin_id' => auth()->id(),
            'action' => 'System Settings Updated',
            'description' => 'Updated system settings.',
        ]);

        return redirect()->back()->with('success', 'System settings updated successfully.');
    }
}