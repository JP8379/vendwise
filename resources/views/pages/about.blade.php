<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - VendWise</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-slate-800 bg-gradient-to-br from-blue-50 via-white to-slate-100">

    <div class="min-h-screen relative overflow-hidden">

        <!-- Decorative Background -->
        <div class="absolute top-28 right-0 w-72 h-72 bg-blue-200/40 rounded-full blur-3xl"></div>
        <div class="absolute top-96 -left-24 w-80 h-80 bg-blue-100/70 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-20 w-64 h-64 bg-indigo-100/70 rounded-full blur-3xl"></div>

        <!-- Header -->
        <header class="relative z-10 bg-white/80 backdrop-blur border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">

                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="h-11 w-11 rounded-xl bg-blue-600 text-white flex items-center justify-center font-extrabold text-xl shadow-md">
                        V
                    </div>

                    <span class="text-2xl font-extrabold tracking-wide text-slate-900">
                        VENDWISE
                    </span>
                </a>

                <!-- Back Button -->
                <a href="{{ route('home') }}"
                   class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-blue-600 text-white font-semibold shadow-md hover:bg-blue-700 hover:shadow-lg transition">
                    <span>←</span>
                    <span>Back to Home</span>
                </a>

            </div>
        </header>

        <!-- Hero Section -->
        <section class="relative z-10 max-w-7xl mx-auto px-6 py-16 grid lg:grid-cols-2 gap-14 items-center">

            <!-- Left Text -->
            <div>
                <span class="inline-flex items-center px-4 py-2 rounded-full bg-blue-100 text-blue-700 text-sm font-bold mb-6">
                    ABOUT THE PROJECT
                </span>

                <h1 class="text-5xl md:text-6xl font-extrabold text-slate-900 leading-tight mb-6">
                    Understanding
                    <span class="text-blue-600">VendWise</span>
                </h1>

                <div class="h-1.5 w-20 bg-blue-600 rounded-full mb-8"></div>

                <p class="text-lg text-slate-600 leading-8 max-w-xl">
                    This page explains what VendWise is, why it was created,
                    who it is designed for, the problem it solves, and the main
                    objective of the project.
                </p>
            </div>

            <!-- Right Dashboard Preview -->
            <div class="relative">
                <div class="absolute -inset-6 bg-blue-200/40 rounded-[3rem] blur-3xl"></div>

                <div class="relative flex bg-white rounded-[2rem] shadow-2xl border border-slate-200 overflow-hidden">

                    <!-- Mini Sidebar -->
                    <div class="w-20 bg-blue-600 p-4 flex flex-col items-center gap-5">
                        <div class="h-10 w-10 rounded-xl bg-white/20 text-white flex items-center justify-center font-bold">
                            V
                        </div>

                        <div class="h-9 w-9 rounded-xl bg-white/20 flex items-center justify-center text-white text-sm">⌂</div>
                        <div class="h-9 w-9 rounded-xl bg-white/10 flex items-center justify-center text-white text-sm">↗</div>
                        <div class="h-9 w-9 rounded-xl bg-white/10 flex items-center justify-center text-white text-sm">▣</div>
                        <div class="h-9 w-9 rounded-xl bg-white/10 flex items-center justify-center text-white text-sm">☰</div>
                        <div class="h-9 w-9 rounded-xl bg-white/10 flex items-center justify-center text-white text-sm">⚙</div>
                    </div>

                    <!-- Dashboard Card -->
                    <div class="flex-1 p-6">

                        <div class="grid grid-cols-3 gap-4 mb-5">
                            <div class="bg-green-50 border border-green-100 rounded-2xl p-4">
                                <p class="text-xs text-slate-500">Income</p>
                                <h3 class="text-lg font-extrabold text-green-600 mt-2">RM 0.00</h3>
                            </div>

                            <div class="bg-red-50 border border-red-100 rounded-2xl p-4">
                                <p class="text-xs text-slate-500">Expenses</p>
                                <h3 class="text-lg font-extrabold text-red-600 mt-2">RM 0.00</h3>
                            </div>

                            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4">
                                <p class="text-xs text-slate-500">Profit</p>
                                <h3 class="text-lg font-extrabold text-blue-600 mt-2">RM 0.00</h3>
                            </div>
                        </div>

                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 mb-5">
                            <div class="flex items-center justify-between mb-5">
                                <h3 class="font-extrabold text-slate-900">Financial Overview</h3>
                                <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-semibold">
                                    Demo Preview
                                </span>
                            </div>

                            <div class="h-36 flex items-end gap-3">
                                <div class="w-full h-12 bg-blue-200 rounded-t-xl"></div>
                                <div class="w-full h-20 bg-blue-300 rounded-t-xl"></div>
                                <div class="w-full h-16 bg-blue-400 rounded-t-xl"></div>
                                <div class="w-full h-24 bg-blue-500 rounded-t-xl"></div>
                                <div class="w-full h-28 bg-blue-600 rounded-t-xl"></div>
                                <div class="w-full h-32 bg-blue-700 rounded-t-xl"></div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between bg-white border border-slate-200 rounded-xl px-4 py-3">
                                <span class="text-sm text-slate-600">New Sale Recorded</span>
                                <span class="text-xs text-slate-400">2m ago</span>
                            </div>

                            <div class="flex items-center justify-between bg-white border border-slate-200 rounded-xl px-4 py-3">
                                <span class="text-sm text-slate-600">Stock Updated</span>
                                <span class="text-xs text-slate-400">10m ago</span>
                            </div>

                            <div class="flex items-center justify-between bg-white border border-slate-200 rounded-xl px-4 py-3">
                                <span class="text-sm text-slate-600">Expense Added</span>
                                <span class="text-xs text-slate-400">25m ago</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </section>

        <!-- Explanation Cards -->
        <section class="relative z-10 max-w-6xl mx-auto px-6 pb-20 space-y-6">

            <!-- 01 -->
            <div class="bg-white/90 backdrop-blur rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition p-8">
                <div class="grid md:grid-cols-[140px_1fr] gap-8 items-center">

                    <div class="flex flex-col items-center">
                        <div class="h-24 w-24 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-5xl font-extrabold shadow-sm">
                            ?
                        </div>

                        <div class="mt-3 px-4 py-2 rounded-xl bg-blue-600 text-white font-bold shadow">
                            01
                        </div>
                    </div>

                    <div class="md:border-l md:border-blue-100 md:pl-8">
                        <h2 class="text-2xl font-extrabold text-slate-900 mb-3">
                            What is VendWise?
                        </h2>

                        <div class="h-1 w-10 bg-blue-600 rounded-full mb-4"></div>

                        <p class="text-slate-600 leading-8">
                            VendWise is a web-based financial tracking system developed as a
                            Final Year Project. It is designed to help small vendors and small
                            businesses record income, expenses, sales, inventory, and view simple
                            financial reports in one organized platform.
                        </p>
                    </div>

                </div>
            </div>

            <!-- 02 -->
            <div class="bg-white/90 backdrop-blur rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition p-8">
                <div class="grid md:grid-cols-[140px_1fr] gap-8 items-center">

                    <div class="flex flex-col items-center">
                        <div class="h-24 w-24 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-5xl shadow-sm">
                            💡
                        </div>

                        <div class="mt-3 px-4 py-2 rounded-xl bg-green-500 text-white font-bold shadow">
                            02
                        </div>
                    </div>

                    <div class="md:border-l md:border-green-100 md:pl-8">
                        <h2 class="text-2xl font-extrabold text-slate-900 mb-3">
                            Why was this project created?
                        </h2>

                        <div class="h-1 w-10 bg-green-500 rounded-full mb-4"></div>

                        <p class="text-slate-600 leading-8">
                            This project was created because many small vendors still manage
                            business records manually using notebooks, spreadsheets, or simple
                            memory-based tracking. This can lead to missing records, calculation
                            mistakes, poor stock awareness, and difficulty understanding business
                            performance.
                        </p>
                    </div>

                </div>
            </div>

            <!-- 03 -->
            <div class="bg-white/90 backdrop-blur rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition p-8">
                <div class="grid md:grid-cols-[140px_1fr] gap-8 items-center">

                    <div class="flex flex-col items-center">
                        <div class="h-24 w-24 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-5xl shadow-sm">
                            👥
                        </div>

                        <div class="mt-3 px-4 py-2 rounded-xl bg-purple-500 text-white font-bold shadow">
                            03
                        </div>
                    </div>

                    <div class="md:border-l md:border-purple-100 md:pl-8">
                        <h2 class="text-2xl font-extrabold text-slate-900 mb-3">
                            Who is VendWise for?
                        </h2>

                        <div class="h-1 w-10 bg-purple-500 rounded-full mb-4"></div>

                        <p class="text-slate-600 leading-8">
                            VendWise is mainly designed for small vendors, micro-business owners,
                            food sellers, home-based businesses, and small shop owners who need a
                            simple way to manage daily transactions and inventory without using a
                            complex accounting system.
                        </p>
                    </div>

                </div>
            </div>

            <!-- 04 -->
            <div class="bg-white/90 backdrop-blur rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition p-8">
                <div class="grid md:grid-cols-[140px_1fr] gap-8 items-center">

                    <div class="flex flex-col items-center">
                        <div class="h-24 w-24 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center text-5xl shadow-sm">
                            🧩
                        </div>

                        <div class="mt-3 px-4 py-2 rounded-xl bg-orange-500 text-white font-bold shadow">
                            04
                        </div>
                    </div>

                    <div class="md:border-l md:border-orange-100 md:pl-8">
                        <h2 class="text-2xl font-extrabold text-slate-900 mb-3">
                            What problem does it solve?
                        </h2>

                        <div class="h-1 w-10 bg-orange-500 rounded-full mb-4"></div>

                        <p class="text-slate-600 leading-8">
                            VendWise solves the problem of disorganized financial tracking by
                            allowing users to manage transactions, monitor inventory, receive low
                            stock awareness, and view financial summaries more clearly. The system
                            helps users understand income, expenses, profit, and business activity
                            without needing advanced accounting knowledge.
                        </p>
                    </div>

                </div>
            </div>

            <!-- 05 -->
            <div class="bg-white/90 backdrop-blur rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition p-8">
                <div class="grid md:grid-cols-[140px_1fr] gap-8 items-center">

                    <div class="flex flex-col items-center">
                        <div class="h-24 w-24 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-5xl shadow-sm">
                            🎯
                        </div>

                        <div class="mt-3 px-4 py-2 rounded-xl bg-blue-600 text-white font-bold shadow">
                            05
                        </div>
                    </div>

                    <div class="md:border-l md:border-blue-100 md:pl-8">
                        <h2 class="text-2xl font-extrabold text-slate-900 mb-3">
                            Project Objective
                        </h2>

                        <div class="h-1 w-10 bg-blue-600 rounded-full mb-4"></div>

                        <p class="text-slate-600 leading-8">
                            The main objective of VendWise is to develop a user-friendly financial
                            tracking system that supports small vendors in recording business
                            activities, managing inventory, generating reports, and improving
                            decision-making through clear and simple business information.
                        </p>
                    </div>

                </div>
            </div>

        </section>

        <!-- Small Footer -->
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