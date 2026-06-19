<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VendWise</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-slate-900 bg-gradient-to-br from-blue-50 via-white to-indigo-100">

    <!-- ═══════════════════════════════════════════════
         NAVBAR — responsive with hamburger menu
    ════════════════════════════════════════════════ -->
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">

            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2 sm:gap-3">
                <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl bg-blue-600 text-white flex items-center justify-center font-extrabold text-lg sm:text-xl shadow-lg shadow-blue-200 shrink-0">
                    V
                </div>
                <div>
                    <h1 class="text-lg sm:text-2xl font-extrabold tracking-[0.2em] sm:tracking-[0.25em] text-slate-900 leading-none">VENDWISE</h1>
                    <p class="text-xs text-slate-500 mt-0.5">Smart Vendor Finance</p>
                </div>
            </a>

            <!-- Desktop Nav -->
            <div class="hidden sm:flex items-center gap-4">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                           class="px-5 py-2.5 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-200 text-sm">
                            Admin Dashboard
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}"
                           class="px-5 py-2.5 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-200 text-sm">
                            Dashboard
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                       class="text-slate-700 hover:text-blue-600 font-semibold transition text-sm">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="px-5 py-2.5 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-200 text-sm">
                        Get Started Free
                    </a>
                @endauth
            </div>

            <!-- Mobile Hamburger -->
            <button id="mobileMenuBtn"
                    class="sm:hidden flex flex-col justify-center items-center w-9 h-9 gap-1.5 rounded-lg hover:bg-slate-100 transition"
                    aria-label="Open menu">
                <span class="w-5 h-0.5 bg-slate-700 rounded transition-all" id="bar1"></span>
                <span class="w-5 h-0.5 bg-slate-700 rounded transition-all" id="bar2"></span>
                <span class="w-5 h-0.5 bg-slate-700 rounded transition-all" id="bar3"></span>
            </button>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div id="mobileMenu"
             class="sm:hidden hidden border-t border-slate-200 bg-white/95 backdrop-blur px-4 py-4 space-y-2">
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                       class="block w-full text-center px-5 py-3 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition text-sm">
                        Admin Dashboard
                    </a>
                @else
                    <a href="{{ route('dashboard') }}"
                       class="block w-full text-center px-5 py-3 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition text-sm">
                        Dashboard
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}"
                   class="block w-full text-center px-5 py-3 rounded-xl border border-slate-300 text-slate-700 font-semibold hover:bg-slate-50 transition text-sm">
                    Login
                </a>
                <a href="{{ route('register') }}"
                   class="block w-full text-center px-5 py-3 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition text-sm">
                    Get Started Free
                </a>
            @endauth
        </div>
    </header>

    <!-- ═══════════════════════════════════════════════
         HERO SECTION — stacks on mobile
    ════════════════════════════════════════════════ -->
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(37,99,235,0.16),_transparent_35%),radial-gradient(circle_at_bottom_right,_rgba(79,70,229,0.14),_transparent_35%)]"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 py-12 sm:py-20 lg:py-28">
            <div class="grid lg:grid-cols-2 gap-10 lg:gap-14 items-center">

                <!-- Hero Text -->
                <div>
                    <h2 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight tracking-tight text-slate-900">
                        Manage Your Business
                        <span class="text-blue-600">Smarter</span>
                    </h2>

                    <p class="mt-5 sm:mt-6 text-base sm:text-lg text-slate-600 leading-8 max-w-xl">
                        VendWise helps small vendors manage transactions, inventory, reports,
                        notifications, support, and business performance in one simple platform.
                    </p>

                    <div class="mt-8 sm:mt-10 flex flex-col sm:flex-row gap-3 sm:gap-4">
                        <a href="{{ route('register') }}"
                           class="text-center px-8 py-4 rounded-2xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                            Get Started Free
                        </a>
                        <a href="{{ route('login') }}"
                           class="text-center px-8 py-4 rounded-2xl bg-white border border-slate-300 text-slate-700 font-semibold hover:bg-slate-50 transition shadow-sm">
                            Login
                        </a>
                    </div>

                    <div class="mt-8 sm:mt-10 grid grid-cols-3 gap-3 sm:gap-4 max-w-2xl">
                        <div class="rounded-2xl bg-white/80 backdrop-blur border border-white shadow-sm p-3 sm:p-4">
                            <p class="text-xs sm:text-sm font-bold text-slate-900">Track</p>
                            <p class="text-xs text-slate-500 mt-1 hidden sm:block">Sales, income, and expenses</p>
                        </div>
                        <div class="rounded-2xl bg-white/80 backdrop-blur border border-white shadow-sm p-3 sm:p-4">
                            <p class="text-xs sm:text-sm font-bold text-slate-900">Manage</p>
                            <p class="text-xs text-slate-500 mt-1 hidden sm:block">Products and stock alerts</p>
                        </div>
                        <div class="rounded-2xl bg-white/80 backdrop-blur border border-white shadow-sm p-3 sm:p-4">
                            <p class="text-xs sm:text-sm font-bold text-slate-900">Review</p>
                            <p class="text-xs text-slate-500 mt-1 hidden sm:block">Reports and insights</p>
                        </div>
                    </div>
                </div>

                <!-- Hero Preview Card — hidden on small mobile, shown md+ -->
                <div class="relative hidden md:block">
                    <div class="absolute -inset-6 bg-blue-200/40 blur-3xl rounded-full"></div>
                    <div class="relative bg-white/95 backdrop-blur border border-white rounded-3xl shadow-2xl overflow-hidden">
                        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center font-extrabold text-sm">V</div>
                                <div>
                                    <h3 class="font-extrabold tracking-[0.18em] text-slate-900 text-sm">VENDWISE</h3>
                                    <p class="text-xs text-slate-500">Dashboard Preview</p>
                                </div>
                            </div>
                            <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">System Ready</span>
                        </div>

                        <div class="p-5 space-y-4">
                            <div class="grid grid-cols-3 gap-3">
                                <div class="rounded-2xl bg-blue-50 p-3 border border-blue-100">
                                    <p class="text-xs text-blue-600 font-semibold">Transactions</p>
                                    <p class="mt-1 text-xs font-bold text-slate-900">Income & Expense</p>
                                </div>
                                <div class="rounded-2xl bg-orange-50 p-3 border border-orange-100">
                                    <p class="text-xs text-orange-600 font-semibold">Inventory</p>
                                    <p class="mt-1 text-xs font-bold text-slate-900">Stock Alerts</p>
                                </div>
                                <div class="rounded-2xl bg-green-50 p-3 border border-green-100">
                                    <p class="text-xs text-green-600 font-semibold">Reports</p>
                                    <p class="mt-1 text-xs font-bold text-slate-900">PDF Export</p>
                                </div>
                            </div>

                            <div class="rounded-2xl border border-slate-200 p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="font-bold text-slate-900 text-sm">Business Overview</h4>
                                    <span class="text-xs text-slate-400">Rule-Based Insight</span>
                                </div>
                                <div class="space-y-2.5">
                                    <div class="h-2.5 rounded-full bg-blue-100 overflow-hidden"><div class="h-full w-3/4 bg-blue-600 rounded-full"></div></div>
                                    <div class="h-2.5 rounded-full bg-green-100 overflow-hidden"><div class="h-full w-2/3 bg-green-500 rounded-full"></div></div>
                                    <div class="h-2.5 rounded-full bg-orange-100 overflow-hidden"><div class="h-full w-1/2 bg-orange-500 rounded-full"></div></div>
                                </div>
                            </div>

                            <div class="rounded-2xl bg-slate-50 border border-slate-200 p-4">
                                <div class="flex items-start gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-orange-100 text-orange-700 flex items-center justify-center shrink-0">🔔</div>
                                    <div>
                                        <p class="font-bold text-slate-900 text-sm">Important Notifications</p>
                                        <p class="text-xs text-slate-500 mt-1">Low stock and out of stock alerts help vendors respond faster.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         FEATURES — stacks on mobile
    ════════════════════════════════════════════════ -->
    <section class="py-16 sm:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-10 sm:mb-16">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-4">Powerful Features</h2>
                <p class="text-slate-600 text-base sm:text-lg">Everything small vendors need to manage business finances.</p>
            </div>

            <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6 sm:gap-8">
                <div class="bg-slate-50 border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm hover:shadow-lg hover:-translate-y-1 transition">
                    <div class="h-12 w-12 sm:h-14 sm:w-14 rounded-2xl bg-blue-100 flex items-center justify-center text-xl sm:text-2xl mb-5 sm:mb-6">💰</div>
                    <h3 class="text-xl sm:text-2xl font-bold mb-3 sm:mb-4 text-slate-900">Transaction Tracking</h3>
                    <p class="text-slate-600 leading-7 text-sm sm:text-base">Record sales, expenses, income, product sales, and restock transactions in an organized way.</p>
                </div>

                <div class="bg-slate-50 border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm hover:shadow-lg hover:-translate-y-1 transition">
                    <div class="h-12 w-12 sm:h-14 sm:w-14 rounded-2xl bg-green-100 flex items-center justify-center text-xl sm:text-2xl mb-5 sm:mb-6">📦</div>
                    <h3 class="text-xl sm:text-2xl font-bold mb-3 sm:mb-4 text-slate-900">Inventory Management</h3>
                    <p class="text-slate-600 leading-7 text-sm sm:text-base">Monitor product quantity, stock value, low stock limits, and stock status automatically.</p>
                </div>

                <div class="bg-slate-50 border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm hover:shadow-lg hover:-translate-y-1 transition sm:col-span-2 md:col-span-1">
                    <div class="h-12 w-12 sm:h-14 sm:w-14 rounded-2xl bg-purple-100 flex items-center justify-center text-xl sm:text-2xl mb-5 sm:mb-6">📊</div>
                    <h3 class="text-xl sm:text-2xl font-bold mb-3 sm:mb-4 text-slate-900">Reports & Insights</h3>
                    <p class="text-slate-600 leading-7 text-sm sm:text-base">View financial summaries, profit analysis, rule-based suggestions, and export reports to PDF.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         WORKFLOW — stacks on mobile
    ════════════════════════════════════════════════ -->
    <section class="py-16 sm:py-24 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid lg:grid-cols-2 gap-10 lg:gap-12 items-center">
                <div>
                    <span class="inline-flex px-4 py-2 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold">
                        Simple Workflow
                    </span>
                    <h2 class="mt-5 sm:mt-6 text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
                        Built for small vendors who need simple control.
                    </h2>
                    <p class="mt-4 sm:mt-5 text-slate-600 leading-8 text-sm sm:text-base">
                        VendWise connects financial tracking with inventory activity. Product sales reduce stock,
                        restock expenses increase stock, and important alerts help vendors manage stock early.
                    </p>
                </div>

                <div class="grid gap-4">
                    <div class="rounded-3xl bg-white border border-white p-5 sm:p-6 shadow-sm flex gap-4">
                        <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold shrink-0">1</div>
                        <div>
                            <h3 class="font-bold text-slate-900">Add Products</h3>
                            <p class="text-xs sm:text-sm text-slate-500 mt-1">Record product name, category, stock quantity, low stock limit, and price.</p>
                        </div>
                    </div>

                    <div class="rounded-3xl bg-white border border-white p-5 sm:p-6 shadow-sm flex gap-4">
                        <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl bg-green-100 text-green-700 flex items-center justify-center font-bold shrink-0">2</div>
                        <div>
                            <h3 class="font-bold text-slate-900">Record Transactions</h3>
                            <p class="text-xs sm:text-sm text-slate-500 mt-1">Track income, normal expenses, product sales, and restock expenses.</p>
                        </div>
                    </div>

                    <div class="rounded-3xl bg-white border border-white p-5 sm:p-6 shadow-sm flex gap-4">
                        <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl bg-orange-100 text-orange-700 flex items-center justify-center font-bold shrink-0">3</div>
                        <div>
                            <h3 class="font-bold text-slate-900">Review Reports</h3>
                            <p class="text-xs sm:text-sm text-slate-500 mt-1">Use dashboards, notifications, and reports to understand business performance.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         CTA
    ════════════════════════════════════════════════ -->
    <section class="py-16 sm:py-24 bg-blue-600">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 text-center">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-5 sm:mb-6">Start Managing Your Business Today</h2>
            <p class="text-blue-100 text-base sm:text-lg leading-8 mb-8 sm:mb-10">Join VendWise and simplify your financial management process.</p>
            <a href="{{ route('register') }}"
               class="inline-block px-8 py-4 rounded-2xl bg-white text-blue-600 font-semibold hover:bg-blue-50 transition shadow-lg text-sm sm:text-base">
                Get Started Free
            </a>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         FOOTER
    ════════════════════════════════════════════════ -->
    <footer class="bg-slate-950 text-white py-12 sm:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 text-center">
            <div class="flex items-center justify-center gap-3 mb-5 sm:mb-6">
                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-blue-600 text-white flex items-center justify-center font-extrabold text-lg sm:text-xl shadow-lg shadow-blue-900/40">V</div>
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-[0.25em]">VENDWISE</h2>
            </div>
            <p class="text-slate-400 text-base sm:text-lg mb-8 sm:mb-10">Simple Financial Control for Small Businesses</p>

            <div class="flex flex-wrap justify-center gap-4 sm:gap-8 text-sm font-medium">
                <a href="{{ route('about') }}"    class="text-slate-300 hover:text-white transition">About</a>
                <a href="{{ route('features') }}" class="text-slate-300 hover:text-white transition">Features</a>
                <a href="{{ route('roles') }}"    class="text-slate-300 hover:text-white transition">Role System</a>
                <a href="{{ route('privacy') }}"  class="text-slate-300 hover:text-white transition">Privacy</a>
                <a href="{{ route('terms') }}"    class="text-slate-300 hover:text-white transition">Terms</a>
                <a href="{{ route('contact') }}"  class="text-slate-300 hover:text-white transition">Contact</a>
            </div>

            <div class="border-t border-slate-800 mt-8 sm:mt-10 pt-6 sm:pt-8">
                <p class="text-slate-500 text-xs sm:text-sm">&copy; {{ date('Y') }} VENDWISE. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Hamburger toggle script -->
    <script>
        const btn  = document.getElementById('mobileMenuBtn');
        const menu = document.getElementById('mobileMenu');
        const bar1 = document.getElementById('bar1');
        const bar2 = document.getElementById('bar2');
        const bar3 = document.getElementById('bar3');

        btn.addEventListener('click', () => {
            const open = !menu.classList.contains('hidden');
            menu.classList.toggle('hidden', open);

            // Animate bars into X when open
            bar1.classList.toggle('rotate-45',   !open);
            bar1.classList.toggle('translate-y-2', !open);
            bar2.classList.toggle('opacity-0',    !open);
            bar3.classList.toggle('-rotate-45',  !open);
            bar3.classList.toggle('-translate-y-2',!open);
        });
    </script>

</body>
</html>