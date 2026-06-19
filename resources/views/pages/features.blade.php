<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Features - VendWise</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-slate-800 bg-gradient-to-br from-blue-50 via-white to-slate-100">

    <div class="min-h-screen relative overflow-hidden">

        <!-- Background Effects -->
        <div class="absolute top-28 right-0 w-80 h-80 bg-blue-200/40 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 -left-24 w-80 h-80 bg-indigo-100/70 rounded-full blur-3xl"></div>

        <!-- Header -->
        <header class="relative z-10 bg-white/80 backdrop-blur border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">

                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="h-11 w-11 rounded-xl bg-blue-600 text-white flex items-center justify-center font-extrabold text-xl shadow-md">
                        V
                    </div>

                    <span class="text-2xl font-extrabold tracking-wide text-slate-900">
                        VENDWISE
                    </span>
                </a>

                <a href="{{ route('home') }}"
                   class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-blue-600 text-white font-semibold shadow-md hover:bg-blue-700 hover:shadow-lg transition">
                    <span>←</span>
                    <span>Back to Home</span>
                </a>

            </div>
        </header>

        <!-- Hero -->
        <section class="relative z-10 max-w-7xl mx-auto px-6 py-16 text-center">

            <span class="inline-flex items-center px-4 py-2 rounded-full bg-blue-100 text-blue-700 text-sm font-bold mb-6">
                VENDWISE FEATURES
            </span>

            <h1 class="text-5xl md:text-6xl font-extrabold text-slate-900 leading-tight mb-6">
                Features Built for
                <span class="text-blue-600">Small Businesses</span>
            </h1>

            <div class="h-1.5 w-20 bg-blue-600 rounded-full mx-auto mb-8"></div>

            <p class="text-lg text-slate-600 leading-8 max-w-3xl mx-auto">
                VendWise includes essential modules that help small vendors record transactions,
                manage products, monitor stock, view reports, and handle support more efficiently.
            </p>

        </section>

        <!-- Feature Cards -->
        <section class="relative z-10 max-w-7xl mx-auto px-6 pb-20">

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-7">

                <!-- 01 -->
                <div class="group bg-white/90 backdrop-blur rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition p-8">
                    <div class="h-16 w-16 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition">
                        💰
                    </div>

                    <span class="text-sm font-bold text-blue-600">01</span>

                    <h2 class="text-2xl font-extrabold text-slate-900 mt-2 mb-4">
                        Transaction Tracking
                    </h2>

                    <p class="text-slate-600 leading-7">
                        Allows vendors to record income, sales, expenses, payment methods,
                        dates, and descriptions in an organized way.
                    </p>
                </div>

                <!-- 02 -->
                <div class="group bg-white/90 backdrop-blur rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition p-8">
                    <div class="h-16 w-16 rounded-2xl bg-green-100 text-green-600 flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition">
                        📦
                    </div>

                    <span class="text-sm font-bold text-green-600">02</span>

                    <h2 class="text-2xl font-extrabold text-slate-900 mt-2 mb-4">
                        Inventory Management
                    </h2>

                    <p class="text-slate-600 leading-7">
                        Helps users manage product names, categories, stock quantity,
                        prices, and low stock threshold levels.
                    </p>
                </div>

                <!-- 03 -->
                <div class="group bg-white/90 backdrop-blur rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition p-8">
                    <div class="h-16 w-16 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition">
                        📊
                    </div>

                    <span class="text-sm font-bold text-purple-600">03</span>

                    <h2 class="text-2xl font-extrabold text-slate-900 mt-2 mb-4">
                        Financial Reports
                    </h2>

                    <p class="text-slate-600 leading-7">
                        Provides daily, monthly, and yearly summaries to help users
                        understand income, expenses, and net profit.
                    </p>
                </div>

                <!-- 04 -->
                <div class="group bg-white/90 backdrop-blur rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition p-8">
                    <div class="h-16 w-16 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition">
                        🔔
                    </div>

                    <span class="text-sm font-bold text-orange-600">04</span>

                    <h2 class="text-2xl font-extrabold text-slate-900 mt-2 mb-4">
                        Notifications
                    </h2>

                    <p class="text-slate-600 leading-7">
                        Displays important alerts such as new transaction updates and
                        low stock notifications to improve awareness.
                    </p>
                </div>

                <!-- 05 -->
                <div class="group bg-white/90 backdrop-blur rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition p-8">
                    <div class="h-16 w-16 rounded-2xl bg-pink-100 text-pink-600 flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition">
                        🧠
                    </div>

                    <span class="text-sm font-bold text-pink-600">05</span>

                    <h2 class="text-2xl font-extrabold text-slate-900 mt-2 mb-4">
                        Business Insights
                    </h2>

                    <p class="text-slate-600 leading-7">
                        Helps users identify financial patterns through simple summaries,
                        dashboard cards, and report-based insights.
                    </p>
                </div>

                <!-- 06 -->
                <div class="group bg-white/90 backdrop-blur rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition p-8">
                    <div class="h-16 w-16 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition">
                        🛡️
                    </div>

                    <span class="text-sm font-bold text-indigo-600">06</span>

                    <h2 class="text-2xl font-extrabold text-slate-900 mt-2 mb-4">
                        Admin Control
                    </h2>

                    <p class="text-slate-600 leading-7">
                        Allows admin users to manage vendors, support tickets,
                        system logs, and system settings from a separate panel.
                    </p>
                </div>

            </div>

        </section>

        <!-- Summary Section -->
        <section class="relative z-10 max-w-7xl mx-auto px-6 pb-20">
            <div class="bg-blue-600 rounded-[2rem] p-10 md:p-12 text-white shadow-xl text-center">

                <h2 class="text-3xl md:text-4xl font-extrabold mb-4">
                    Simple Tools, Clearer Business Tracking
                </h2>

                <p class="text-blue-100 leading-8 max-w-3xl mx-auto">
                    These features work together to help small vendors reduce manual work,
                    organize business records, and understand their financial performance better.
                </p>

            </div>
        </section>

        <!-- Footer -->
        <footer class="relative z-10 max-w-7xl mx-auto px-6 pb-10">
            <div class="bg-blue-50/80 border border-blue-100 rounded-3xl py-8 text-center shadow-sm">
                <div class="mx-auto h-11 w-11 rounded-xl bg-blue-600 text-white flex items-center justify-center font-extrabold text-xl shadow-md mb-3">
                    V
                </div>

                <h2 class="text-xl font-extrabold text-slate-900">
                    VENDWISE
                </h2>

                <p class="text-slate-500 mt-1">
                    Simple Financial Control for Small Businesses.
                </p>
            </div>
        </footer>

    </div>

</body>
</html>