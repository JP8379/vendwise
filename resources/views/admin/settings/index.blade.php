@extends('admin.layouts.app')

@section('content')

    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">System Settings</h1>
        <p class="text-sm text-gray-500 mt-1">Control vendor access and registration behaviour.</p>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-5 flex items-center gap-3 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-green-700 text-sm font-medium">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf

        {{-- ===== USER CONTROL CARD ===== --}}
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 mb-5">

            <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-100">
                <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2h5M12 12a4 4 0 100-8 4 4 0 000 8z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-800">Vendor Access Control</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Manage how vendors register and their default account status.</p>
                </div>
            </div>

            <div class="space-y-5">

                {{-- Allow Vendor Registration toggle --}}
                <div class="flex items-center justify-between p-4 rounded-xl bg-gray-50 border border-gray-100">
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Allow Vendor Registration</p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            When enabled, new vendors can register and create an account.
                        </p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer ml-4 shrink-0">
                        <input type="checkbox" name="allow_vendor_registration" value="1" class="sr-only peer"
                               {{ ($settings->allow_vendor_registration ?? false) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer
                                    peer-checked:bg-blue-600 transition-all duration-200
                                    after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                    after:bg-white after:rounded-full after:h-5 after:w-5
                                    after:transition-all peer-checked:after:translate-x-full">
                        </div>
                    </label>
                </div>

                {{-- Default Vendor Status --}}
                <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Default Vendor Status
                    </label>
                    <p class="text-xs text-gray-400 mb-3">
                        Status automatically assigned to new vendor accounts upon registration.
                    </p>
                    <div class="flex gap-3">

                        {{-- Active option --}}
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="default_vendor_status" value="active" class="sr-only peer"
                                   {{ ($settings->default_vendor_status ?? 'active') == 'active' ? 'checked' : '' }}>
                            <div class="flex items-center gap-2 px-4 py-3 rounded-xl border-2 text-sm font-medium transition
                                        border-gray-200 text-gray-600
                                        peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700">
                                <span class="w-2 h-2 rounded-full bg-green-500 shrink-0"></span>
                                Active
                            </div>
                        </label>

                        {{-- Deactivated option --}}
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="default_vendor_status" value="deactivated" class="sr-only peer"
                                   {{ ($settings->default_vendor_status ?? '') == 'deactivated' ? 'checked' : '' }}>
                            <div class="flex items-center gap-2 px-4 py-3 rounded-xl border-2 text-sm font-medium transition
                                        border-gray-200 text-gray-600
                                        peer-checked:border-red-400 peer-checked:bg-red-50 peer-checked:text-red-600">
                                <span class="w-2 h-2 rounded-full bg-red-400 shrink-0"></span>
                                Deactivated
                            </div>
                        </label>

                    </div>
                </div>

            </div>
        </div>

        {{-- ===== SAVE BUTTON ===== --}}
        <div class="flex items-center justify-between bg-white border border-gray-200 rounded-2xl shadow-sm px-6 py-4">
            <p class="text-sm text-gray-400">Changes will apply immediately after saving.</p>
            <button type="submit"
                    class="px-6 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl
                           hover:bg-blue-700 transition shadow-sm shadow-blue-200">
                Save Settings
            </button>
        </div>

    </form>

@endsection