@php
    $pendingDeletionRequests = \App\Models\User::where('role', 'vendor')
        ->where('deletion_request_status', 'pending')
        ->count();
@endphp

<aside class="w-64 min-h-screen bg-slate-950 text-white flex flex-col justify-between shadow-2xl">

    <!-- Top Section -->
    <div>

        <!-- Logo -->
        <div class="px-6 py-6 border-b border-slate-800">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-blue-600 text-white flex items-center justify-center font-extrabold text-xl shadow-lg shadow-blue-500/30">
                    V
                </div>

                <div>
                    <h1 class="text-2xl font-extrabold tracking-[0.20em] text-white">
                        VENDWISE
                    </h1>

                    <p class="text-xs text-slate-400 -mt-1">
                        Admin Control Center
                    </p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="mt-6 px-4 space-y-2">

            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200
               {{ request()->routeIs('admin.dashboard')
                    ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20 font-semibold'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">

                <span class="text-lg">📊</span>
                <span>Dashboard</span>
            </a>

            <!-- User Management -->
            <a href="{{ route('admin.users.index') }}"
               class="flex items-center justify-between px-4 py-3 rounded-2xl transition-all duration-200
               {{ request()->routeIs('admin.users.*')
                    ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20 font-semibold'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">

                <div class="flex items-center gap-3">
                    <span class="text-lg">👥</span>
                    <span>User Management</span>
                </div>

                @if($pendingDeletionRequests > 0)
                    <span class="min-w-[22px] h-[22px] px-2 flex items-center justify-center rounded-full text-xs font-bold
                        {{ request()->routeIs('admin.users.*') ? 'bg-white text-blue-600' : 'bg-orange-500 text-white' }}">
                        {{ $pendingDeletionRequests > 99 ? '99+' : $pendingDeletionRequests }}
                    </span>
                @endif
            </a>

            <!-- System Logs -->
            <a href="{{ route('admin.logs.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200
               {{ request()->routeIs('admin.logs.*')
                    ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20 font-semibold'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">

                <span class="text-lg">📑</span>
                <span>System Logs</span>
            </a>

            <!-- Support Inbox -->
            <a href="{{ route('admin.support.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200
               {{ request()->routeIs('admin.support.*')
                    ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20 font-semibold'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">

                <span class="text-lg">🎧</span>
                <span>Support Inbox</span>
            </a>

            <!-- System Settings -->
            <a href="{{ route('admin.settings.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200
               {{ request()->routeIs('admin.settings.*')
                    ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20 font-semibold'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">

                <span class="text-lg">⚙️</span>
                <span>System Settings</span>
            </a>

        </nav>

        <!-- Admin Info -->
        <div class="mx-4 mt-8 rounded-2xl bg-slate-900 border border-slate-800 p-4">
            <p class="text-xs uppercase tracking-wider text-slate-500">
                Admin Session
            </p>

            <div class="mt-3">
                <p class="font-semibold text-white">
                    {{ auth()->user()->name ?? 'Administrator' }}
                </p>

                <p class="text-sm text-slate-400">
                    System Administrator
                </p>
            </div>
        </div>

    </div>

    <!-- Bottom Section -->
    <div class="px-4 py-6 border-t border-slate-800">

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-red-400 hover:bg-red-500 hover:text-white transition-all duration-200">

                <span class="text-lg">➡</span>
                <span class="font-medium">Logout</span>
            </button>
        </form>

    </div>

</aside>