<x-app-layout>
    <div class="flex min-h-screen bg-gradient-to-br from-blue-50 via-slate-50 to-indigo-100">
        <x-sidebar />
        <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-30 hidden lg:hidden" onclick="closeSidebar()"></div>

        <main class="flex-1 min-w-0">

            <header class="bg-white/90 backdrop-blur border-b border-white/70 px-4 sm:px-8 py-4 sm:py-6">
                <div class="flex items-center gap-4">
                    <button class="lg:hidden flex flex-col justify-center items-center w-9 h-9 gap-1.5 rounded-lg hover:bg-gray-100 transition shrink-0" onclick="openSidebar()">
                        <span class="w-5 h-0.5 bg-gray-700 rounded"></span>
                        <span class="w-5 h-0.5 bg-gray-700 rounded"></span>
                        <span class="w-5 h-0.5 bg-gray-700 rounded"></span>
                    </button>
                    <div class="flex-1 min-w-0">
                        <h2 class="text-xl sm:text-3xl font-bold text-slate-900 truncate">Notifications</h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5 hidden sm:block">View important stock alerts, support updates, and system notifications.</p>
                    </div>
                    @if(($unreadCount ?? 0) > 0)
                        <form method="POST" action="{{ route('notifications.markAllRead') }}" class="shrink-0">
                            @csrf
                            <button type="submit" class="px-3 sm:px-5 py-2 sm:py-2.5 text-xs sm:text-sm font-semibold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition shadow-md">
                                Mark All Read
                            </button>
                        </form>
                    @endif
                </div>
            </header>

            <div class="p-4 sm:p-6 lg:p-8 space-y-5 sm:space-y-6">

                @if(session('success'))
                    <div class="rounded-2xl bg-green-50 border border-green-200 px-4 py-3 text-green-700 text-sm">{{ session('success') }}</div>
                @endif

                {{-- Summary Cards --}}
                <div class="grid grid-cols-3 gap-3 sm:gap-5">
                    <div class="bg-white/95 backdrop-blur border border-white/70 rounded-2xl p-3 sm:p-6 shadow-sm">
                        <p class="text-xs sm:text-sm text-slate-500">Total</p>
                        <h3 class="mt-1 sm:mt-3 text-xl sm:text-3xl font-bold text-blue-600">{{ $totalCount ?? $notifications->count() }}</h3>
                        <p class="text-xs text-slate-400 mt-1 hidden sm:block">All notifications</p>
                    </div>
                    <div class="bg-white/95 backdrop-blur border border-white/70 rounded-2xl p-3 sm:p-6 shadow-sm">
                        <p class="text-xs sm:text-sm text-slate-500">Unread</p>
                        <h3 class="mt-1 sm:mt-3 text-xl sm:text-3xl font-bold text-orange-500">{{ $unreadCount ?? $notifications->whereNull('read_at')->count() }}</h3>
                        <p class="text-xs text-slate-400 mt-1 hidden sm:block">Need attention</p>
                    </div>
                    <div class="bg-white/95 backdrop-blur border border-white/70 rounded-2xl p-3 sm:p-6 shadow-sm">
                        <p class="text-xs sm:text-sm text-slate-500">Read</p>
                        <h3 class="mt-1 sm:mt-3 text-xl sm:text-3xl font-bold text-green-600">{{ $readCount ?? $notifications->whereNotNull('read_at')->count() }}</h3>
                        <p class="text-xs text-slate-400 mt-1 hidden sm:block">Already reviewed</p>
                    </div>
                </div>

                {{-- Insight --}}
                <div class="rounded-2xl bg-blue-50 border border-blue-200 p-4 sm:p-5">
                    <div class="flex gap-3 sm:gap-4">
                        <div class="h-10 w-10 sm:h-11 sm:w-11 rounded-xl bg-blue-600 text-white flex items-center justify-center text-lg sm:text-xl shrink-0">🔔</div>
                        <div>
                            <h3 class="font-bold text-blue-800 text-sm sm:text-base">Notification Insight</h3>
                            <p class="text-xs sm:text-sm text-blue-700 mt-1 leading-relaxed">
                                @if(($unreadCount ?? 0) > 0)
                                    You have <strong>{{ $unreadCount }}</strong> unread notification(s). Review them to avoid missing important business alerts.
                                @else
                                    All notifications are currently read. New important alerts will appear here automatically.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Notification List --}}
                <div class="bg-white/95 backdrop-blur border border-white/70 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-slate-100 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-base sm:text-xl font-bold text-slate-900">Recent Notifications</h3>
                            <p class="text-xs sm:text-sm text-slate-500 mt-1">Latest important alerts from VendWise</p>
                        </div>
                        <span class="w-fit rounded-full bg-slate-100 px-3 sm:px-4 py-1.5 sm:py-2 text-xs font-semibold text-slate-600">
                            {{ $notifications->count() }} notification(s)
                        </span>
                    </div>

                    @if($notifications->isEmpty())
                        <div class="p-10 sm:p-12 text-center text-slate-500">
                            <div class="mx-auto mb-4 h-14 w-14 rounded-2xl bg-blue-50 flex items-center justify-center text-3xl">🔔</div>
                            <p class="font-bold text-slate-700">No notifications yet</p>
                            <p class="text-sm mt-1">Low stock, out of stock, support, and system alerts will appear here.</p>
                        </div>
                    @else
                        <div class="divide-y divide-slate-100">
                            @foreach ($notifications as $notification)
                                @php
                                    $data        = $notification->data ?? [];
                                    $title       = $data['title']   ?? 'Notification';
                                    $message     = $data['message'] ?? '';
                                    $type        = $data['type']    ?? 'general';
                                    $icon        = $data['icon']    ?? '🔔';
                                    $color       = $data['color']   ?? 'gray';
                                    $actionText  = $data['action_text'] ?? null;
                                    $actionUrl   = $data['action_url']  ?? null;

                                    if (!$actionUrl) {
                                        if (str_contains($type, 'stock'))       { $actionUrl = route('inventory.index');    $actionText = $actionText ?? 'View Inventory'; }
                                        elseif (str_contains($type, 'support')) { $actionUrl = route('support.index');     $actionText = $actionText ?? 'View Support'; }
                                        elseif (str_contains($type, 'report'))  { $actionUrl = route('reports.index');     $actionText = $actionText ?? 'View Reports'; }
                                        elseif (str_contains($type, 'transaction') || str_contains($type, 'sale')) { $actionUrl = route('transactions.index'); $actionText = $actionText ?? 'View Transactions'; }
                                    }

                                    $badge = match($type) { 'low_stock' => 'Low Stock', 'out_of_stock' => 'Out of Stock', 'transaction' => 'Transaction', 'support' => 'Support', 'account' => 'Account', default => 'General' };
                                    if ($type === 'low_stock')    { $icon = $icon ?: '⚠️'; $color = 'orange'; }
                                    if ($type === 'out_of_stock') { $icon = $icon ?: '🚨'; $color = 'red'; }

                                    $isUnread    = is_null($notification->read_at);
                                    $iconClass   = match($color) { 'red' => 'bg-red-100 text-red-700', 'orange' => 'bg-orange-100 text-orange-700', 'green' => 'bg-green-100 text-green-700', 'blue' => 'bg-blue-100 text-blue-700', 'purple' => 'bg-purple-100 text-purple-700', default => 'bg-slate-100 text-slate-700' };
                                    $badgeClass  = $iconClass;
                                    $buttonClass = match($color) { 'red' => 'bg-red-50 text-red-700 hover:bg-red-100', 'orange' => 'bg-orange-50 text-orange-700 hover:bg-orange-100', 'green' => 'bg-green-50 text-green-700 hover:bg-green-100', 'blue' => 'bg-blue-50 text-blue-700 hover:bg-blue-100', default => 'bg-slate-100 text-slate-700 hover:bg-slate-200' };
                                @endphp

                                <div class="p-4 sm:p-5 transition {{ $isUnread ? 'bg-blue-50/70' : 'bg-white hover:bg-slate-50' }}">
                                    <div class="flex items-start gap-3 sm:gap-5">
                                        <div class="h-10 w-10 sm:h-12 sm:w-12 rounded-2xl flex items-center justify-center text-lg sm:text-xl {{ $iconClass }} shrink-0">{{ $icon }}</div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex flex-wrap items-center gap-1.5 sm:gap-2">
                                                @if($isUnread)<span class="w-2 h-2 bg-blue-600 rounded-full shrink-0"></span>@endif
                                                <h4 class="font-bold text-slate-900 text-sm sm:text-base">{{ $title }}</h4>
                                                <span class="px-2 sm:px-3 py-0.5 sm:py-1 text-xs font-semibold rounded-full {{ $badgeClass }}">{{ $badge }}</span>
                                                @if($isUnread)
                                                    <span class="px-2 sm:px-3 py-0.5 sm:py-1 text-xs font-semibold rounded-full bg-blue-600 text-white">New</span>
                                                @else
                                                    <span class="px-2 sm:px-3 py-0.5 sm:py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-500">Read</span>
                                                @endif
                                            </div>
                                            <p class="text-xs sm:text-sm text-slate-600 mt-1.5 sm:mt-2 leading-relaxed">{{ $message }}</p>
                                            <div class="mt-2 sm:mt-3 flex flex-wrap items-center gap-2 sm:gap-3">
                                                @if($actionUrl && $actionText)
                                                    <a href="{{ $actionUrl }}" class="px-3 sm:px-4 py-1.5 sm:py-2 text-xs font-semibold rounded-xl transition {{ $buttonClass }}">{{ $actionText }}</a>
                                                @endif
                                                <span class="text-xs text-slate-400">{{ $notification->created_at->format('d/m/Y h:i A') }}</span>
                                            </div>
                                        </div>
                                        <div class="text-xs text-slate-400 whitespace-nowrap hidden sm:block">{{ $notification->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </main>
    </div>
    <script>
        function openSidebar()  { document.getElementById('mobileSidebar').classList.remove('-translate-x-full'); document.getElementById('sidebarOverlay').classList.remove('hidden'); }
        function closeSidebar() { document.getElementById('mobileSidebar').classList.add('-translate-x-full');    document.getElementById('sidebarOverlay').classList.add('hidden'); }
    </script>
</x-app-layout>