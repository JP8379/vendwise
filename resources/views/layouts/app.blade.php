<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    <title>{{ config('app.name', 'VendWise') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">

    @auth
        @php
            $latestUnreadNotification = auth()->user()
                ->unreadNotifications()
                ->latest()
                ->first();
        @endphp
    @else
        @php
            $latestUnreadNotification = null;
        @endphp
    @endauth

    <!-- Session Toast Popup -->
    @if ((session('success') || session('error') || session('warning') || session('info')) && !$latestUnreadNotification)
        @php
            $toastType = session('success') ? 'success' : (session('error') ? 'error' : (session('warning') ? 'warning' : 'info'));

            $toastMessage = session('success') ?? session('error') ?? session('warning') ?? session('info');

            $toastTitle = match($toastType) {
                'success' => 'Success',
                'error' => 'Error',
                'warning' => 'Warning',
                default => 'Notification',
            };

            $toastIcon = match($toastType) {
                'success' => '✅',
                'error' => '❌',
                'warning' => '⚠️',
                default => '🔔',
            };

            $toastColor = match($toastType) {
                'success' => 'green',
                'error' => 'red',
                'warning' => 'orange',
                default => 'blue',
            };
        @endphp

        <div
            id="vendwise-session-toast"
            class="fixed top-6 right-6 z-50 w-full max-w-sm transition-all duration-500"
        >
            <div class="rounded-2xl border bg-white p-4 shadow-2xl
                @if($toastColor === 'green') border-green-200
                @elseif($toastColor === 'red') border-red-200
                @elseif($toastColor === 'orange') border-orange-200
                @else border-blue-200
                @endif">

                <div class="flex items-start gap-4">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl text-xl
                        @if($toastColor === 'green') bg-green-100 text-green-700
                        @elseif($toastColor === 'red') bg-red-100 text-red-700
                        @elseif($toastColor === 'orange') bg-orange-100 text-orange-700
                        @else bg-blue-100 text-blue-700
                        @endif">
                        {{ $toastIcon }}
                    </div>

                    <div class="flex-1">
                        <h3 class="text-sm font-bold text-slate-900">
                            {{ $toastTitle }}
                        </h3>

                        <p class="mt-1 text-sm leading-5 text-slate-600">
                            {{ $toastMessage }}
                        </p>
                    </div>

                    <button
                        type="button"
                        onclick="document.getElementById('vendwise-session-toast')?.remove()"
                        class="text-xl leading-none text-slate-400 hover:text-slate-700"
                    >
                        ×
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Latest Unread Notification Popup -->
    @auth
        @if ($latestUnreadNotification)
            @php
                $data = $latestUnreadNotification->data ?? [];

                $notificationTitle = $data['title'] ?? 'New Notification';
                $notificationMessage = $data['message'] ?? 'You have a new notification.';
                $notificationIcon = $data['icon'] ?? '🔔';
                $notificationColor = $data['color'] ?? 'blue';
                $notificationActionText = $data['action_text'] ?? 'View Notification';
                $notificationActionUrl = $data['action_url'] ?? route('notifications.index');

                $notificationId = $latestUnreadNotification->id;
            @endphp

            <div
                id="vendwise-notification-toast"
                data-notification-id="{{ $notificationId }}"
                class="fixed top-6 right-6 z-50 hidden w-full max-w-md transition-all duration-500"
            >
                <div class="rounded-2xl border bg-white p-5 shadow-2xl
                    @if($notificationColor === 'red') border-red-200
                    @elseif($notificationColor === 'orange') border-orange-200
                    @elseif($notificationColor === 'green') border-green-200
                    @elseif($notificationColor === 'purple') border-purple-200
                    @else border-blue-200
                    @endif">

                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl text-xl
                            @if($notificationColor === 'red') bg-red-100 text-red-700
                            @elseif($notificationColor === 'orange') bg-orange-100 text-orange-700
                            @elseif($notificationColor === 'green') bg-green-100 text-green-700
                            @elseif($notificationColor === 'purple') bg-purple-100 text-purple-700
                            @else bg-blue-100 text-blue-700
                            @endif">
                            {{ $notificationIcon }}
                        </div>

                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full bg-blue-600"></span>

                                <h3 class="text-sm font-bold text-slate-900">
                                    {{ $notificationTitle }}
                                </h3>

                                <span class="rounded-full bg-blue-600 px-2.5 py-1 text-[10px] font-bold text-white">
                                    New
                                </span>
                            </div>

                            <p class="mt-2 text-sm leading-5 text-slate-600">
                                {{ $notificationMessage }}
                            </p>

                            <div class="mt-4 flex flex-wrap items-center gap-3">
                                <a href="{{ $notificationActionUrl }}"
                                   class="rounded-xl px-4 py-2 text-xs font-bold transition
                                   @if($notificationColor === 'red') bg-red-50 text-red-700 hover:bg-red-100
                                   @elseif($notificationColor === 'orange') bg-orange-50 text-orange-700 hover:bg-orange-100
                                   @elseif($notificationColor === 'green') bg-green-50 text-green-700 hover:bg-green-100
                                   @elseif($notificationColor === 'purple') bg-purple-50 text-purple-700 hover:bg-purple-100
                                   @else bg-blue-50 text-blue-700 hover:bg-blue-100
                                   @endif">
                                    {{ $notificationActionText }}
                                </a>

                                <a href="{{ route('notifications.index') }}"
                                   class="rounded-xl bg-slate-100 px-4 py-2 text-xs font-bold text-slate-700 hover:bg-slate-200">
                                    View All
                                </a>
                            </div>
                        </div>

                        <button
                            type="button"
                            onclick="hideVendWiseNotificationToast()"
                            class="text-xl leading-none text-slate-400 hover:text-slate-700"
                        >
                            ×
                        </button>
                    </div>
                </div>
            </div>
        @endif
    @endauth

    <!-- Main Content -->
    {{ $slot }}

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sessionToast = document.getElementById('vendwise-session-toast');

            if (sessionToast) {
                setTimeout(function () {
                    sessionToast.classList.add('opacity-0', 'translate-x-5');

                    setTimeout(function () {
                        sessionToast.remove();
                    }, 500);
                }, 4500);
            }

            const notificationToast = document.getElementById('vendwise-notification-toast');

            if (notificationToast) {
                const notificationId = notificationToast.dataset.notificationId;
                const storageKey = 'vendwise_seen_notification_' + notificationId;

                if (!sessionStorage.getItem(storageKey)) {
                    notificationToast.classList.remove('hidden');

                    setTimeout(function () {
                        notificationToast.classList.add('opacity-0', 'translate-x-5');

                        setTimeout(function () {
                            notificationToast.remove();
                        }, 500);
                    }, 8500);

                    sessionStorage.setItem(storageKey, 'true');
                }
            }
        });

        function hideVendWiseNotificationToast() {
            const notificationToast = document.getElementById('vendwise-notification-toast');

            if (notificationToast) {
                notificationToast.classList.add('opacity-0', 'translate-x-5');

                setTimeout(function () {
                    notificationToast.remove();
                }, 500);
            }
        }
    </script>

</body>
</html>