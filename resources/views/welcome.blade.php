<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VendWise</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 antialiased text-[17px]">

    {{-- Navbar --}}
    <header class="w-full border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
            <a href="/" class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-blue-500 text-white shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 19V9m5 10V5m5 14v-7m5 7V3" />
                    </svg>
                </div>
                <span class="text-3xl font-extrabold tracking-wide">VENDWISE</span>
            </a>

            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}"
                   class="rounded-xl bg-slate-100 px-6 py-3 text-base font-medium text-slate-800 transition hover:bg-slate-200">
                    Login
                </a>
                <a href="{{ route('register') }}"
                   class="rounded-xl bg-blue-500 px-6 py-3 text-base font-medium text-white shadow-sm transition hover:bg-blue-600">
                    Get Started
                </a>
            </div>
        </div>
    </header>

    {{-- Hero Section --}}
    <section class="px-6 py-20 lg:py-24">
        <div class="mx-auto max-w-4xl text-center">
            <h1 class="text-6xl font-extrabold tracking-tight text-slate-900 sm:text-7xl">
                VENDWISE
            </h1>

            <p class="mt-6 text-3xl font-semibold text-slate-700 sm:text-4xl">
                Simple Financial Control for Small Businesses
            </p>

            <p class="mx-auto mt-6 max-w-3xl text-xl leading-relaxed text-slate-600 sm:text-2xl">
                Take control of your business finances with our easy-to-use platform.
                Track transactions, manage inventory, and generate insights — all in one place.
            </p>

            <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
                <a href="{{ route('register') }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-blue-500 px-8 py-4 text-lg font-semibold text-white shadow-md transition hover:bg-blue-600">
                    Get Started
                    <span class="text-xl">→</span>
                </a>

                <a href="{{ route('login') }}"
                   class="inline-flex items-center rounded-xl border border-blue-500 px-8 py-4 text-lg font-semibold text-blue-600 transition hover:bg-blue-50">
                    Login
                </a>
            </div>

            <div class="mt-6">
                <a href="#features" class="text-base font-medium text-blue-600 hover:underline">
                    Compare Vendor &amp; Admin Dashboards →
                </a>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section id="features" class="px-6 py-20">
        <div class="mx-auto max-w-6xl">
            <h2 class="text-center text-5xl font-extrabold tracking-tight text-slate-900">
                Everything You Need to Manage Your Business
            </h2>

            <div class="mt-14 grid gap-8 md:grid-cols-2 xl:grid-cols-4">
                {{-- Card 1 --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                    <div class="flex h-16 w-16 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 14l2-2 4 4m0 0l4-4m-4 4V6M5 20h14" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-3xl font-semibold text-slate-900">
                        Transaction Tracking
                    </h3>
                    <p class="mt-4 text-lg leading-relaxed text-slate-600">
                        Record and monitor all your income, expenses, and sales in one place.
                    </p>
                </div>

                {{-- Card 2 --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                    <div class="flex h-16 w-16 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 19V9m5 10V5m5 14v-7m5 7V3" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-3xl font-semibold text-slate-900">
                        Financial Overview
                    </h3>
                    <p class="mt-4 text-lg leading-relaxed text-slate-600">
                        Get real-time insights with beautiful charts and analytics.
                    </p>
                </div>

                {{-- Card 3 --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                    <div class="flex h-16 w-16 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-3xl font-semibold text-slate-900">
                        Inventory Management
                    </h3>
                    <p class="mt-4 text-lg leading-relaxed text-slate-600">
                        Keep track of your products and stock levels effortlessly.
                    </p>
                </div>

                {{-- Card 4 --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                    <div class="flex h-16 w-16 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 17l4-4 4 4m0-8H7" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-3xl font-semibold text-slate-900">
                        Profit &amp; Loss Reports
                    </h3>
                    <p class="mt-4 text-lg leading-relaxed text-slate-600">
                        Generate detailed reports to understand your business performance.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- How It Works --}}
    <section class="px-6 py-20">
        <div class="mx-auto max-w-6xl">
            <h2 class="text-center text-5xl font-extrabold tracking-tight text-slate-900">
                How It Works
            </h2>

            <div class="mt-14 grid gap-10 md:grid-cols-3">
                <div class="text-center">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-blue-500 text-2xl font-bold text-white shadow-sm">
                        1
                    </div>
                    <h3 class="mt-6 text-3xl font-semibold text-slate-900">Create Account</h3>
                    <p class="mt-3 text-lg leading-relaxed text-slate-600">
                        Sign up in seconds and set up your business profile.
                    </p>
                </div>

                <div class="text-center">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-blue-500 text-2xl font-bold text-white shadow-sm">
                        2
                    </div>
                    <h3 class="mt-6 text-3xl font-semibold text-slate-900">Add Transactions</h3>
                    <p class="mt-3 text-lg leading-relaxed text-slate-600">
                        Record your income, expenses, and sales easily.
                    </p>
                </div>

                <div class="text-center">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-blue-500 text-2xl font-bold text-white shadow-sm">
                        3
                    </div>
                    <h3 class="mt-6 text-3xl font-semibold text-slate-900">Track Performance</h3>
                    <p class="mt-3 text-lg leading-relaxed text-slate-600">
                        Monitor your business with real-time analytics.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="px-6 py-20">
        <div class="mx-auto max-w-5xl rounded-3xl bg-blue-500 px-8 py-16 text-center text-white shadow-lg">
            <h2 class="text-5xl font-extrabold">
                Ready to Take Control?
            </h2>
            <p class="mt-4 text-xl text-blue-100">
                Start managing your business finances today
            </p>

            <div class="mt-8">
                <a href="{{ route('register') }}"
                   class="inline-flex items-center rounded-xl bg-white px-8 py-4 text-lg font-semibold text-blue-600 transition hover:bg-slate-100">
                    Get Started Free
                </a>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-slate-950 px-6 py-16 text-white">
        <div class="mx-auto max-w-4xl text-center">
            <div class="flex items-center justify-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-white text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 19V9m5 10V5m5 14v-7m5 7V3" />
                    </svg>
                </div>
                <span class="text-3xl font-extrabold tracking-wide">VENDWISE</span>
            </div>

            <p class="mt-5 text-lg text-slate-300">
                Simple Financial Control for Small Businesses
            </p>

            <div class="mt-8 flex flex-wrap items-center justify-center gap-8 text-base text-slate-300">
                <a href="#" class="hover:text-white">About</a>
                <a href="#" class="hover:text-white">Features</a>
                <a href="#" class="hover:text-white">Role System</a>
                <a href="#" class="hover:text-white">Privacy</a>
                <a href="#" class="hover:text-white">Terms</a>
                <a href="#" class="hover:text-white">Contact</a>
            </div>

            <p class="mt-8 text-base text-slate-400">
                © 2026 VENDWISE. All rights reserved.
            </p>
        </div>
    </footer>

</body>
</html>