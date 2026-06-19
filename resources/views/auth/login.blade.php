<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - VENDWISE</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-100 overflow-hidden">

    <!-- Background Glow -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-blue-300 rounded-full blur-3xl opacity-30"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-indigo-300 rounded-full blur-3xl opacity-30"></div>

    <div class="relative min-h-screen flex items-center justify-center px-6 py-10">

        <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">

            <!-- Left Side -->
            <div class="hidden lg:block bg-white/80 backdrop-blur-xl rounded-3xl p-10 shadow-2xl border border-white">

                <!-- Logo -->
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center shadow-lg">
                        <span class="text-white text-2xl font-extrabold">V</span>
                    </div>

                    <div>
                        <h1 class="text-2xl font-extrabold text-slate-900">
                            VENDWISE
                        </h1>

                        <p class="text-sm text-slate-500">
                            Smart Vendor Finance
                        </p>
                    </div>
                </div>

                <!-- Heading -->
                <h2 class="text-5xl font-extrabold leading-tight text-slate-900">
                    Welcome back to your business control center.
                </h2>

                <p class="mt-6 text-slate-600 leading-relaxed text-lg">
                    Track transactions, monitor stock, view reports, and receive smart business insights from one simple platform.
                </p>

                <!-- Features -->
                <div class="mt-10 space-y-5">

                    <div class="flex items-center gap-3 text-sm text-gray-700">
                        <div class="w-2.5 h-2.5 rounded-full bg-blue-600"></div>
                        <span>Real-time financial tracking</span>
                    </div>

                    <div class="flex items-center gap-3 text-sm text-gray-700">
                        <div class="w-2.5 h-2.5 rounded-full bg-blue-600"></div>
                        <span>Inventory and low-stock alerts</span>
                    </div>

                    <div class="flex items-center gap-3 text-sm text-gray-700">
                        <div class="w-2.5 h-2.5 rounded-full bg-blue-600"></div>
                        <span>Smart profit and loss insights</span>
                    </div>

                </div>
            </div>

            <!-- Login Card -->
            <div class="bg-white/90 backdrop-blur-xl rounded-3xl p-8 md:p-10 shadow-2xl border border-white">

                <!-- Logo -->
                <div class="text-center mb-8">

                    <div class="mx-auto w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-200">
                        <span class="text-white text-3xl font-extrabold">V</span>
                    </div>

                    <h2 class="mt-5 text-3xl font-extrabold text-slate-900">
                        Login to VENDWISE
                    </h2>

                    <p class="text-sm text-slate-500 mt-2">
                        Access your business dashboard securely.
                    </p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700">
                            Email Address
                        </label>

                        <input id="email"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autofocus
                               autocomplete="username"
                               class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700">
                            Password
                        </label>

                        <input id="password"
                               type="password"
                               name="password"
                               required
                               autocomplete="current-password"
                               class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember + Forgot -->
                    <div class="flex items-center justify-between">

                        <label class="flex items-center text-sm text-slate-600">
                            <input type="checkbox"
                                   name="remember"
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">

                            <span class="ml-2">
                                Remember me
                            </span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-sm font-medium text-blue-600 hover:underline">
                                Forgot password?
                            </a>
                        @endif

                    </div>

                    <!-- Button -->
                    <button type="submit"
                            class="w-full py-3 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                        Log in
                    </button>

                    <!-- Register -->
                    <div class="pt-4 text-center text-sm text-slate-600">
                        Don’t have an account?

                        <a href="{{ route('register') }}"
                           class="text-blue-600 font-semibold hover:underline">
                            Create Account
                        </a>
                    </div>

                </form>
            </div>

        </div>
    </div>

</body>
</html>