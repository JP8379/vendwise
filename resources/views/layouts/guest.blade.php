<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'VendWise') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen bg-slate-50 flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-6xl grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">

            <!-- Left info card -->
            <div class="hidden lg:flex justify-center">
                <div class="w-full max-w-md bg-white rounded-2xl shadow-sm border border-slate-200 p-10 text-center">
                    <div class="mx-auto mb-6 flex h-14 w-14 items-center justify-center rounded-full bg-blue-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M18 9v3m0 0v3m0-3h3m-3 0h-3M12 7a4 4 0 110 8 4 4 0 010-8zM6 20a6 6 0 1112 0H6z"/>
                        </svg>
                    </div>

                    <h2 class="text-2xl font-bold">Join <span class="text-blue-700">VENDWISE</span> Today</h2>
                    <p class="mt-2 text-sm text-slate-500">
                        Start managing your business finances with ease
                    </p>

                    <ul class="mt-6 space-y-3 text-left text-sm text-slate-600">
                        <li class="flex items-start gap-3">
                            <span class="mt-1 h-2 w-2 rounded-full bg-emerald-500"></span>
                            Free to get started
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1 h-2 w-2 rounded-full bg-emerald-500"></span>
                            Real-time financial tracking
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1 h-2 w-2 rounded-full bg-emerald-500"></span>
                            Detailed analytics & reports
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Right form -->
            <div class="flex justify-center">
                {{ $slot }}
            </div>

        </div>
    </div>
</body>
</html>