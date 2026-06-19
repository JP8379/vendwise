<!-- Sidebar -->
@php
    $sidebarUnreadCount = auth()->check()
        ? auth()->user()->unreadNotifications()->count()
        : 0;
    $userName    = auth()->user()->name  ?? 'User';
    $userEmail   = auth()->user()->email ?? '';
    $userInitial = strtoupper(substr($userName, 0, 1));
@endphp

{{-- ══ DESKTOP SIDEBAR (lg+) ══ --}}
<aside class="hidden lg:flex w-64 flex-col shrink-0"
       style="background: linear-gradient(180deg, #ffffff 0%, #f8faff 100%);
              border-right: 1px solid #e2e8f0;
              min-height: 100vh;">

    {{-- Logo --}}
    <div class="px-6 py-5" style="border-bottom: 1px solid #eef2ff;">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-blue-600 text-white flex items-center justify-center font-extrabold text-xl"
                 style="box-shadow: 0 4px 14px rgba(37,99,235,0.35);">V</div>
            <div>
                <h1 class="text-xl font-extrabold tracking-widest text-gray-900">VENDWISE</h1>
                <p class="text-xs text-gray-400 -mt-0.5">Vendor Panel</p>
            </div>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 px-4 py-5 space-y-1 overflow-y-auto">
        <p class="px-3 mb-2 text-xs font-bold text-gray-400 uppercase tracking-widest">Main Menu</p>

        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
           {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
            <span class="text-base w-5 text-center">📊</span><span>Dashboard</span>
        </a>
        <a href="{{ route('transactions.create') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
           {{ request()->routeIs('transactions.create') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
            <span class="text-base w-5 text-center">➕</span><span>Add Transaction</span>
        </a>
        <a href="{{ route('transactions.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
           {{ request()->routeIs('transactions.index') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
            <span class="text-base w-5 text-center">💳</span><span>Transactions</span>
        </a>
        <a href="{{ route('inventory.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
           {{ request()->routeIs('inventory.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
            <span class="text-base w-5 text-center">📦</span><span>Inventory</span>
        </a>
        <a href="{{ route('reports.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
           {{ request()->routeIs('reports.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
            <span class="text-base w-5 text-center">📈</span><span>Reports</span>
        </a>

        <div class="pt-3 pb-1">
            <p class="px-3 text-xs font-bold text-gray-400 uppercase tracking-widest">Support</p>
        </div>

        <a href="{{ route('notifications.index') }}"
           class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all
           {{ request()->routeIs('notifications.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
            <div class="flex items-center gap-3">
                <span class="text-base w-5 text-center">🔔</span><span>Notifications</span>
            </div>
            @if($sidebarUnreadCount > 0)
                <span class="min-w-[20px] h-5 px-1.5 flex items-center justify-center rounded-full text-xs font-bold
                    {{ request()->routeIs('notifications.*') ? 'bg-white text-blue-600' : 'bg-red-500 text-white' }}">
                    {{ $sidebarUnreadCount > 99 ? '99+' : $sidebarUnreadCount }}
                </span>
            @endif
        </a>
        <a href="{{ route('support.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
           {{ request()->routeIs('support.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
            <span class="text-base w-5 text-center">🎧</span><span>Support</span>
        </a>
        <a href="{{ route('settings.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
           {{ request()->routeIs('settings.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
            <span class="text-base w-5 text-center">⚙️</span><span>Settings</span>
        </a>
    </nav>

    {{-- User card + logout --}}
    <div class="px-4 pb-5 pt-3" style="border-top: 1px solid #eef2ff;">
        <div class="flex items-center gap-3 px-3 py-3 rounded-xl mb-2" style="background: #f0f4ff;">
            <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-bold shrink-0">{{ $userInitial }}</div>
            <div class="min-w-0">
                <p class="text-sm font-semibold text-gray-800 truncate">{{ $userName }}</p>
                <p class="text-xs text-gray-400 truncate">{{ $userEmail }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-red-500 hover:bg-red-50 hover:text-red-600 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h5a2 2 0 012 2v1"/>
                </svg>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>

{{-- ══ MOBILE SIDEBAR DRAWER (slides in from left) ══ --}}
<aside id="mobileSidebar"
       class="fixed top-0 left-0 h-full w-72 z-40 flex flex-col transform -translate-x-full transition-transform duration-300 ease-in-out lg:hidden"
       style="background: linear-gradient(180deg, #ffffff 0%, #f8faff 100%);
              border-right: 1px solid #e2e8f0;
              box-shadow: 4px 0 24px rgba(0,0,0,0.12);">

    {{-- Mobile header: logo + close button --}}
    <div class="px-4 py-4 flex items-center justify-between" style="border-bottom: 1px solid #eef2ff;">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center font-extrabold text-lg"
                 style="box-shadow: 0 4px 14px rgba(37,99,235,0.35);">V</div>
            <div>
                <h1 class="text-lg font-extrabold tracking-widest text-gray-900">VENDWISE</h1>
                <p class="text-xs text-gray-400 -mt-0.5">Vendor Panel</p>
            </div>
        </div>
        <button onclick="closeSidebar()"
                class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-gray-100 transition text-gray-500 text-lg font-bold">
            ✕
        </button>
    </div>

    {{-- Mobile Nav --}}
    <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
        <p class="px-3 mb-2 text-xs font-bold text-gray-400 uppercase tracking-widest">Main Menu</p>

        <a href="{{ route('dashboard') }}" onclick="closeSidebar()"
           class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-all
           {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
            <span class="text-base">📊</span><span>Dashboard</span>
        </a>
        <a href="{{ route('transactions.create') }}" onclick="closeSidebar()"
           class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-all
           {{ request()->routeIs('transactions.create') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
            <span class="text-base">➕</span><span>Add Transaction</span>
        </a>
        <a href="{{ route('transactions.index') }}" onclick="closeSidebar()"
           class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-all
           {{ request()->routeIs('transactions.index') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
            <span class="text-base">💳</span><span>Transactions</span>
        </a>
        <a href="{{ route('inventory.index') }}" onclick="closeSidebar()"
           class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-all
           {{ request()->routeIs('inventory.*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
            <span class="text-base">📦</span><span>Inventory</span>
        </a>
        <a href="{{ route('reports.index') }}" onclick="closeSidebar()"
           class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-all
           {{ request()->routeIs('reports.*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
            <span class="text-base">📈</span><span>Reports</span>
        </a>

        <div class="pt-3 pb-1">
            <p class="px-3 text-xs font-bold text-gray-400 uppercase tracking-widest">Support</p>
        </div>

        <a href="{{ route('notifications.index') }}" onclick="closeSidebar()"
           class="flex items-center justify-between px-3 py-3 rounded-xl text-sm font-medium transition-all
           {{ request()->routeIs('notifications.*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
            <div class="flex items-center gap-3"><span class="text-base">🔔</span><span>Notifications</span></div>
            @if($sidebarUnreadCount > 0)
                <span class="min-w-[20px] h-5 px-1.5 flex items-center justify-center rounded-full text-xs font-bold bg-red-500 text-white">
                    {{ $sidebarUnreadCount > 99 ? '99+' : $sidebarUnreadCount }}
                </span>
            @endif
        </a>
        <a href="{{ route('support.index') }}" onclick="closeSidebar()"
           class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-all
           {{ request()->routeIs('support.*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
            <span class="text-base">🎧</span><span>Support</span>
        </a>
        <a href="{{ route('settings.index') }}" onclick="closeSidebar()"
           class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-all
           {{ request()->routeIs('settings.*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
            <span class="text-base">⚙️</span><span>Settings</span>
        </a>
    </nav>

    {{-- Mobile user card + logout --}}
    <div class="px-4 pb-5 pt-3" style="border-top: 1px solid #eef2ff;">
        <div class="flex items-center gap-3 px-3 py-3 rounded-xl mb-2" style="background: #f0f4ff;">
            <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-bold shrink-0">{{ $userInitial }}</div>
            <div class="min-w-0">
                <p class="text-sm font-semibold text-gray-800 truncate">{{ $userName }}</p>
                <p class="text-xs text-gray-400 truncate">{{ $userEmail }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-red-500 hover:bg-red-50 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h5a2 2 0 012 2v1"/>
                </svg>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>