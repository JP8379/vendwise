<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role System - VendWise</title>

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
                ROLE-BASED ACCESS
            </span>

            <h1 class="text-5xl md:text-6xl font-extrabold text-slate-900 leading-tight mb-6">
                VendWise
                <span class="text-blue-600">Role System</span>
            </h1>

            <div class="h-1.5 w-20 bg-blue-600 rounded-full mx-auto mb-8"></div>

            <p class="text-lg text-slate-600 leading-8 max-w-3xl mx-auto">
                VendWise separates system access into Vendor/User and Admin roles.
                This keeps the system organized, secure, and easier to manage.
            </p>

        </section>

        <!-- Role Cards -->
        <section class="relative z-10 max-w-7xl mx-auto px-6 pb-16">

            <div class="grid lg:grid-cols-2 gap-8">

                <!-- Vendor Role -->
                <div class="bg-white/90 backdrop-blur rounded-[2rem] border border-blue-100 shadow-sm hover:shadow-xl transition overflow-hidden">

                    <div class="bg-blue-600 p-8 text-white">
                        <div class="h-16 w-16 rounded-2xl bg-white/20 flex items-center justify-center text-3xl mb-5">
                            🛒
                        </div>

                        <h2 class="text-3xl font-extrabold mb-3">
                            Vendor/User Role
                        </h2>

                        <p class="text-blue-100 leading-7">
                            This role is for small business owners who use VendWise to manage
                            their own business records.
                        </p>
                    </div>

                    <div class="p-8 space-y-4">
                        <div class="flex items-start gap-4 bg-blue-50 rounded-2xl p-4">
                            <span class="text-blue-600 font-bold">✓</span>
                            <p class="text-slate-700">View personal dashboard with business summary.</p>
                        </div>

                        <div class="flex items-start gap-4 bg-blue-50 rounded-2xl p-4">
                            <span class="text-blue-600 font-bold">✓</span>
                            <p class="text-slate-700">Add, view, and search business transactions.</p>
                        </div>

                        <div class="flex items-start gap-4 bg-blue-50 rounded-2xl p-4">
                            <span class="text-blue-600 font-bold">✓</span>
                            <p class="text-slate-700">Manage products, stock quantity, and inventory details.</p>
                        </div>

                        <div class="flex items-start gap-4 bg-blue-50 rounded-2xl p-4">
                            <span class="text-blue-600 font-bold">✓</span>
                            <p class="text-slate-700">View financial reports such as income, expenses, and profit.</p>
                        </div>

                        <div class="flex items-start gap-4 bg-blue-50 rounded-2xl p-4">
                            <span class="text-blue-600 font-bold">✓</span>
                            <p class="text-slate-700">Submit support tickets when help is needed.</p>
                        </div>

                        <div class="flex items-start gap-4 bg-blue-50 rounded-2xl p-4">
                            <span class="text-blue-600 font-bold">✓</span>
                            <p class="text-slate-700">Update profile and business settings.</p>
                        </div>
                    </div>

                </div>

                <!-- Admin Role -->
                <div class="bg-white/90 backdrop-blur rounded-[2rem] border border-slate-200 shadow-sm hover:shadow-xl transition overflow-hidden">

                    <div class="bg-slate-900 p-8 text-white">
                        <div class="h-16 w-16 rounded-2xl bg-white/10 flex items-center justify-center text-3xl mb-5">
                            🛡️
                        </div>

                        <h2 class="text-3xl font-extrabold mb-3">
                            Admin Role
                        </h2>

                        <p class="text-slate-300 leading-7">
                            This role is for system administrators who manage users,
                            support requests, logs, and system settings.
                        </p>
                    </div>

                    <div class="p-8 space-y-4">
                        <div class="flex items-start gap-4 bg-slate-50 rounded-2xl p-4">
                            <span class="text-slate-900 font-bold">✓</span>
                            <p class="text-slate-700">View system dashboard and overall platform summary.</p>
                        </div>

                        <div class="flex items-start gap-4 bg-slate-50 rounded-2xl p-4">
                            <span class="text-slate-900 font-bold">✓</span>
                            <p class="text-slate-700">Manage vendor accounts and user information.</p>
                        </div>

                        <div class="flex items-start gap-4 bg-slate-50 rounded-2xl p-4">
                            <span class="text-slate-900 font-bold">✓</span>
                            <p class="text-slate-700">Activate or deactivate vendor accounts when required.</p>
                        </div>

                        <div class="flex items-start gap-4 bg-slate-50 rounded-2xl p-4">
                            <span class="text-slate-900 font-bold">✓</span>
                            <p class="text-slate-700">View and manage support tickets submitted by users.</p>
                        </div>

                        <div class="flex items-start gap-4 bg-slate-50 rounded-2xl p-4">
                            <span class="text-slate-900 font-bold">✓</span>
                            <p class="text-slate-700">Monitor system logs for important admin actions.</p>
                        </div>

                        <div class="flex items-start gap-4 bg-slate-50 rounded-2xl p-4">
                            <span class="text-slate-900 font-bold">✓</span>
                            <p class="text-slate-700">Update system settings such as currency, timezone, and registration control.</p>
                        </div>
                    </div>

                </div>

            </div>

        </section>

        <!-- Access Flow -->
        <section class="relative z-10 max-w-7xl mx-auto px-6 pb-20">

            <div class="bg-white/90 backdrop-blur border border-slate-200 rounded-[2rem] shadow-sm p-8 md:p-10">

                <div class="text-center mb-10">
                    <h2 class="text-3xl font-extrabold text-slate-900">
                        How the Role System Works
                    </h2>

                    <p class="text-slate-600 mt-3">
                        Each user is redirected based on their assigned role after login.
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-6 text-center">

                    <div class="bg-blue-50 rounded-3xl p-6 border border-blue-100">
                        <div class="mx-auto h-14 w-14 rounded-2xl bg-blue-600 text-white flex items-center justify-center font-bold text-xl mb-4">
                            1
                        </div>
                        <h3 class="font-extrabold text-slate-900 mb-2">User Login</h3>
                        <p class="text-slate-600 text-sm leading-6">
                            The user enters their email and password through the login page.
                        </p>
                    </div>

                    <div class="bg-green-50 rounded-3xl p-6 border border-green-100">
                        <div class="mx-auto h-14 w-14 rounded-2xl bg-green-500 text-white flex items-center justify-center font-bold text-xl mb-4">
                            2
                        </div>
                        <h3 class="font-extrabold text-slate-900 mb-2">Role Checked</h3>
                        <p class="text-slate-600 text-sm leading-6">
                            VendWise checks whether the user is a vendor or an admin.
                        </p>
                    </div>

                    <div class="bg-purple-50 rounded-3xl p-6 border border-purple-100">
                        <div class="mx-auto h-14 w-14 rounded-2xl bg-purple-500 text-white flex items-center justify-center font-bold text-xl mb-4">
                            3
                        </div>
                        <h3 class="font-extrabold text-slate-900 mb-2">Correct Access</h3>
                        <p class="text-slate-600 text-sm leading-6">
                            The user is sent to the correct dashboard based on their role.
                        </p>
                    </div>

                </div>

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