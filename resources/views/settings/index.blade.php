<x-app-layout>
    <div class="flex min-h-screen bg-gradient-to-br from-blue-50 via-slate-50 to-indigo-100">
        <x-sidebar />
        <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-30 hidden lg:hidden" onclick="closeSidebar()"></div>

        <main class="flex-1 min-w-0">

            <header class="bg-white border-b border-gray-200 px-4 sm:px-8 py-4 flex items-center gap-4">
                <button class="lg:hidden flex flex-col justify-center items-center w-9 h-9 gap-1.5 rounded-lg hover:bg-gray-100 transition shrink-0" onclick="openSidebar()">
                    <span class="w-5 h-0.5 bg-gray-700 rounded"></span>
                    <span class="w-5 h-0.5 bg-gray-700 rounded"></span>
                    <span class="w-5 h-0.5 bg-gray-700 rounded"></span>
                </button>
                <div>
                    <h1 class="text-xl sm:text-3xl font-bold text-slate-900">Settings</h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-0.5 hidden sm:block">Manage your account, business details, and password.</p>
                </div>
            </header>

            <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-6 sm:py-10 space-y-6 sm:space-y-8">

                {{-- Messages --}}
                @if(session('success'))
                    <div class="rounded-2xl bg-green-50 border border-green-200 px-4 sm:px-5 py-3 sm:py-4 text-green-700 text-sm">{{ session('success') }}</div>
                @endif
                @if(session('warning'))
                    <div class="rounded-2xl bg-orange-50 border border-orange-200 px-4 sm:px-5 py-3 sm:py-4 text-orange-700 text-sm">{{ session('warning') }}</div>
                @endif
                @if(session('error'))
                    <div class="rounded-2xl bg-red-50 border border-red-200 px-4 sm:px-5 py-3 sm:py-4 text-red-700 text-sm">{{ session('error') }}</div>
                @endif
                @if($errors->any())
                    <div class="rounded-2xl bg-red-50 border border-red-200 px-4 sm:px-5 py-3 sm:py-4 text-red-700 text-sm">
                        <p class="font-semibold mb-2">Please check the following:</p>
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                {{-- Profile Information --}}
                <div class="rounded-3xl border border-white/70 bg-white/95 backdrop-blur p-5 sm:p-8 shadow-sm">
                    <div class="mb-5 sm:mb-6">
                        <h2 class="text-lg sm:text-2xl font-bold text-slate-900">Profile Information</h2>
                        <p class="mt-1 text-xs sm:text-sm text-slate-500">Update your personal account information.</p>
                    </div>
                    <form method="POST" action="{{ route('settings.profile.update') }}">
                        @csrf
                        <div class="grid gap-4 sm:gap-6 sm:grid-cols-2">
                            <div>
                                <label class="mb-1.5 block text-xs sm:text-sm font-medium text-slate-700">Full Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                    class="w-full rounded-2xl border border-slate-300 px-4 py-2.5 sm:py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="mb-1.5 block text-xs sm:text-sm font-medium text-slate-700">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                    class="w-full rounded-2xl border border-slate-300 px-4 py-2.5 sm:py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div class="mt-4 sm:mt-6">
                            <label class="mb-1.5 block text-xs sm:text-sm font-medium text-slate-700">Phone Number</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone ?? $user->phone_number ?? '') }}"
                                class="w-full rounded-2xl border border-slate-300 px-4 py-2.5 sm:py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                            @error('phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <button type="submit" class="mt-5 sm:mt-6 rounded-2xl bg-blue-600 px-5 sm:px-6 py-2.5 sm:py-3 text-sm text-white font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-200">Save Changes</button>
                    </form>
                </div>

                {{-- Business Details --}}
                <div class="rounded-3xl border border-white/70 bg-white/95 backdrop-blur p-5 sm:p-8 shadow-sm">
                    <div class="mb-5 sm:mb-6">
                        <h2 class="text-lg sm:text-2xl font-bold text-slate-900">Business Details</h2>
                        <p class="mt-1 text-xs sm:text-sm text-slate-500">Manage your vendor business information.</p>
                    </div>
                    <form method="POST" action="{{ route('settings.business.update') }}">
                        @csrf
                        <div class="mb-4 sm:mb-6">
                            <label class="mb-1.5 block text-xs sm:text-sm font-medium text-slate-700">Business Name</label>
                            <input type="text" name="business_name" value="{{ old('business_name', $user->business_name) }}"
                                class="w-full rounded-2xl border border-slate-300 px-4 py-2.5 sm:py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                            @error('business_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div class="mb-4 sm:mb-6">
                            <label class="mb-1.5 block text-xs sm:text-sm font-medium text-slate-700">Business Type</label>
                            <input type="text" name="business_type" value="{{ old('business_type', $user->business_type) }}"
                                class="w-full rounded-2xl border border-slate-300 px-4 py-2.5 sm:py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                            @error('business_type')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div class="mb-4 sm:mb-6">
                            <label class="mb-1.5 block text-xs sm:text-sm font-medium text-slate-700">Tax ID</label>
                            <input type="text" name="tax_id" value="{{ old('tax_id', $user->tax_id) }}"
                                class="w-full rounded-2xl border border-slate-300 px-4 py-2.5 sm:py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                            @error('tax_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div class="grid gap-4 sm:gap-6 sm:grid-cols-2">
                            <div>
                                <label class="mb-1.5 block text-xs sm:text-sm font-medium text-slate-700">City</label>
                                <input type="text" name="city" value="{{ old('city', $user->city ?? '') }}"
                                    class="w-full rounded-2xl border border-slate-300 px-4 py-2.5 sm:py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('city')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="mb-1.5 block text-xs sm:text-sm font-medium text-slate-700">Country</label>
                                <input type="text" name="country" value="{{ old('country', $user->country ?? '') }}"
                                    class="w-full rounded-2xl border border-slate-300 px-4 py-2.5 sm:py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('country')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <button type="submit" class="mt-5 sm:mt-6 rounded-2xl bg-blue-600 px-5 sm:px-6 py-2.5 sm:py-3 text-sm text-white font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-200">Update Business Info</button>
                    </form>
                </div>

                {{-- Change Password --}}
                <div class="rounded-3xl border border-white/70 bg-white/95 backdrop-blur p-5 sm:p-8 shadow-sm">
                    <div class="mb-5 sm:mb-6">
                        <h2 class="text-lg sm:text-2xl font-bold text-slate-900">Change Password</h2>
                        <p class="mt-1 text-xs sm:text-sm text-slate-500">Update your password to keep your account secure.</p>
                    </div>
                    <form method="POST" action="{{ route('settings.password.update') }}">
                        @csrf
                        <div class="mb-4 sm:mb-6">
                            <label class="mb-1.5 block text-xs sm:text-sm font-medium text-slate-700">Current Password</label>
                            <input type="password" name="current_password"
                                class="w-full rounded-2xl border border-slate-300 px-4 py-2.5 sm:py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                            @error('current_password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div class="grid gap-4 sm:gap-6 sm:grid-cols-2">
                            <div>
                                <label class="mb-1.5 block text-xs sm:text-sm font-medium text-slate-700">New Password</label>
                                <input type="password" name="new_password"
                                    class="w-full rounded-2xl border border-slate-300 px-4 py-2.5 sm:py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @error('new_password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="mb-1.5 block text-xs sm:text-sm font-medium text-slate-700">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation"
                                    class="w-full rounded-2xl border border-slate-300 px-4 py-2.5 sm:py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                            </div>
                        </div>
                        <button type="submit" class="mt-5 sm:mt-6 rounded-2xl bg-blue-600 px-5 sm:px-6 py-2.5 sm:py-3 text-sm text-white font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-200">Change Password</button>
                    </form>
                </div>

                {{-- Danger Zone --}}
                @php $deletionStatus = $user->deletion_request_status ?? 'none'; @endphp
                <div class="rounded-3xl border border-red-200 bg-white/95 backdrop-blur shadow-sm overflow-hidden">
                    <div class="bg-red-50 border-b border-red-100 px-5 sm:px-8 py-5 sm:py-6">
                        <div class="flex items-center gap-3 sm:gap-4">
                            <div class="w-11 h-11 sm:w-14 sm:h-14 rounded-2xl bg-red-100 flex items-center justify-center text-xl sm:text-2xl shrink-0">⚠️</div>
                            <div>
                                <h2 class="text-lg sm:text-2xl font-bold text-red-600">Danger Zone</h2>
                                <p class="text-xs sm:text-sm text-red-500 mt-0.5">Request account deletion. Admin approval is required.</p>
                            </div>
                        </div>
                    </div>

                    <div class="px-5 sm:px-8 py-6 sm:py-8">
                        @if($deletionStatus === 'pending')
                            <div class="rounded-2xl bg-orange-50 border border-orange-200 p-4 sm:p-5">
                                <h3 class="font-bold text-orange-700 text-sm sm:text-base">Deletion Request Pending</h3>
                                <p class="mt-2 text-xs sm:text-sm leading-relaxed text-orange-700">Your account deletion request is waiting for admin approval. You cannot submit another request while this is pending.</p>
                                @if($user->deletion_requested_at)
                                    <p class="mt-2 text-xs text-orange-600">Requested on: {{ $user->deletion_requested_at->format('d/m/Y h:i A') }}</p>
                                @endif
                            </div>

                        @elseif($deletionStatus === 'approved')
                            <div class="rounded-2xl bg-green-50 border border-green-200 p-4 sm:p-5 mb-5">
                                <h3 class="font-bold text-green-700 text-sm sm:text-base">Deletion Request Approved</h3>
                                <p class="mt-2 text-xs sm:text-sm leading-relaxed text-green-700">Your deletion request has been approved. You may now permanently delete your account.</p>
                            </div>
                            <form method="POST" action="{{ route('settings.destroy') }}" class="space-y-4 sm:space-y-6">
                                @csrf @method('DELETE')
                                <div>
                                    <label class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1.5">Confirm Your Password</label>
                                    <input type="password" name="delete_password" placeholder="Enter your current password"
                                        class="w-full max-w-md rounded-2xl border border-slate-300 px-4 py-2.5 sm:py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
                                    @error('delete_password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                                    <button type="submit" onclick="return confirm('Are you sure? This cannot be undone.')"
                                        class="px-5 sm:px-6 py-2.5 sm:py-3 rounded-2xl bg-red-600 text-white text-sm font-semibold hover:bg-red-700 transition shadow-lg shadow-red-200">
                                        Permanently Delete My Account
                                    </button>
                                    <a href="{{ route('dashboard') }}" class="text-center px-5 sm:px-6 py-2.5 sm:py-3 rounded-2xl border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-50 transition">Cancel</a>
                                </div>
                            </form>

                        @elseif($deletionStatus === 'rejected')
                            <div class="rounded-2xl bg-red-50 border border-red-200 p-4 sm:p-5 mb-5">
                                <h3 class="font-bold text-red-700 text-sm sm:text-base">Previous Request Rejected</h3>
                                <p class="mt-2 text-xs sm:text-sm leading-relaxed text-red-700">Your previous deletion request was rejected by admin.</p>
                                @if($user->deletion_rejection_reason)
                                    <p class="mt-2 text-xs sm:text-sm text-red-700"><strong>Reason:</strong> {{ $user->deletion_rejection_reason }}</p>
                                @endif
                                <p class="mt-2 text-xs text-red-600">You may submit a new request below if needed.</p>
                            </div>
                            <form method="POST" action="{{ route('settings.destroy') }}" class="space-y-4 sm:space-y-6">
                                @csrf @method('DELETE')
                                <div>
                                    <label class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1.5">Confirm Your Password</label>
                                    <input type="password" name="delete_password" placeholder="Enter your current password"
                                        class="w-full max-w-md rounded-2xl border border-slate-300 px-4 py-2.5 sm:py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
                                    @error('delete_password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                                    <button type="submit" onclick="return confirm('Submit another deletion request?')"
                                        class="px-5 sm:px-6 py-2.5 sm:py-3 rounded-2xl bg-red-600 text-white text-sm font-semibold hover:bg-red-700 transition shadow-lg shadow-red-200">
                                        Request Account Deletion Again
                                    </button>
                                    <a href="{{ route('dashboard') }}" class="text-center px-5 sm:px-6 py-2.5 sm:py-3 rounded-2xl border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-50 transition">Cancel</a>
                                </div>
                            </form>

                        @else
                            <div class="bg-red-50 border border-red-100 rounded-2xl p-4 sm:p-5 mb-5">
                                <p class="text-xs sm:text-sm leading-relaxed text-slate-600">Your account will not be deleted immediately. An admin will review your request and decide whether to approve or reject it.</p>
                            </div>
                            <form method="POST" action="{{ route('settings.destroy') }}" class="space-y-4 sm:space-y-6">
                                @csrf @method('DELETE')
                                <div>
                                    <label class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1.5">Confirm Your Password</label>
                                    <input type="password" name="delete_password" placeholder="Enter your current password"
                                        class="w-full max-w-md rounded-2xl border border-slate-300 px-4 py-2.5 sm:py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
                                    @error('delete_password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                    <p class="mt-1 text-xs text-slate-500">Please enter your correct password before sending the deletion request.</p>
                                </div>
                                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                                    <button type="submit" onclick="return confirm('Submit account deletion request? Admin approval is required.')"
                                        class="px-5 sm:px-6 py-2.5 sm:py-3 rounded-2xl bg-red-600 text-white text-sm font-semibold hover:bg-red-700 transition shadow-lg shadow-red-200">
                                        Request Account Deletion
                                    </button>
                                    <a href="{{ route('dashboard') }}" class="text-center px-5 sm:px-6 py-2.5 sm:py-3 rounded-2xl border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-50 transition">Cancel</a>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>

            </div>
        </main>
    </div>
    <script>
        function openSidebar()  { document.getElementById('mobileSidebar').classList.remove('-translate-x-full'); document.getElementById('sidebarOverlay').classList.remove('hidden'); }
        function closeSidebar() { document.getElementById('mobileSidebar').classList.add('-translate-x-full');    document.getElementById('sidebarOverlay').classList.add('hidden'); }
    </script>
</x-app-layout>