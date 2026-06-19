<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - VENDWISE</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-100">

    <div class="min-h-screen flex items-center justify-center px-6 py-10">
        <div class="w-full max-w-6xl grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">

            <!-- Left Branding -->
            <div class="hidden lg:block bg-white/80 backdrop-blur-xl rounded-3xl p-10 shadow-2xl border border-white">

                <div class="flex items-center gap-4 mb-8">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center shadow-lg">
                        <span class="text-white text-2xl font-extrabold">V</span>
                    </div>

                    <div>
                        <h1 class="text-2xl font-extrabold text-slate-900">VENDWISE</h1>
                        <p class="text-sm text-slate-500">Smart Vendor Finance</p>
                    </div>
                </div>

                <h2 class="text-5xl font-extrabold leading-tight text-slate-900">
                    Start managing your business smarter today.
                </h2>

                <p class="mt-6 text-slate-600 leading-relaxed text-lg">
                    Create your VENDWISE account to track transactions, manage inventory,
                    monitor reports, and receive smart business insights.
                </p>

                <div class="mt-10 space-y-5">
                    <div class="flex items-center gap-3 text-sm text-gray-700">
                        <div class="w-2.5 h-2.5 rounded-full bg-blue-600"></div>
                        <span>Simple transaction and expense tracking</span>
                    </div>

                    <div class="flex items-center gap-3 text-sm text-gray-700">
                        <div class="w-2.5 h-2.5 rounded-full bg-blue-600"></div>
                        <span>Inventory monitoring with low-stock alerts</span>
                    </div>

                    <div class="flex items-center gap-3 text-sm text-gray-700">
                        <div class="w-2.5 h-2.5 rounded-full bg-blue-600"></div>
                        <span>Profit reports and AI-style business suggestions</span>
                    </div>
                </div>
            </div>

            <!-- Register Card -->
            <div class="bg-white/90 backdrop-blur-xl rounded-3xl p-8 md:p-10 shadow-2xl border border-white">

                <div class="text-center mb-8">
                    <div class="mx-auto w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-200">
                        <span class="text-white text-3xl font-extrabold">V</span>
                    </div>

                    <h2 class="mt-5 text-3xl font-extrabold text-slate-900">
                        Create Account
                    </h2>

                    <p class="text-sm text-slate-500 mt-2">
                        Fill in your business details to get started.
                    </p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />
                <x-input-error :messages="$errors->all()" class="mb-4" />

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700">
                            Full Name
                        </label>

                        <input id="name"
                               type="text"
                               name="name"
                               value="{{ old('name') }}"
                               required
                               autofocus
                               autocomplete="name"
                               placeholder="John Doe"
                               class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Business Name -->
                    <div>
                        <label for="business_name" class="block text-sm font-semibold text-slate-700">
                            Business Name
                        </label>

                        <input id="business_name"
                               type="text"
                               name="business_name"
                               value="{{ old('business_name') }}"
                               required
                               autocomplete="organization"
                               placeholder="Your Business Name"
                               class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

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
                               autocomplete="username"
                               placeholder="john@example.com"
                               class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label for="phone_number" class="block text-sm font-semibold text-slate-700">
                            Phone Number
                        </label>

                        <input id="phone_number"
                               type="text"
                               name="phone_number"
                               value="{{ old('phone_number') }}"
                               required
                               autocomplete="tel"
                               placeholder="+60 12-345 6789"
                               class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
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
                               autocomplete="new-password"
                               placeholder="••••••••"
                               class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700">
                            Confirm Password
                        </label>

                        <input id="password_confirmation"
                               type="password"
                               name="password_confirmation"
                               required
                               autocomplete="new-password"
                               placeholder="••••••••"
                               class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <button type="submit"
                            class="w-full py-3 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                        Create Account
                    </button>

                    <p class="text-center text-sm text-slate-600 pt-3">
                        Already have an account?

                        <a href="{{ route('login') }}"
                           class="text-blue-600 font-semibold hover:underline">
                            Login here
                        </a>
                    </p>
                </form>
            </div>

        </div>
    </div>

</body>
</html>