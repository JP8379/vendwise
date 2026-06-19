<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - VendWise</title>

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
                DATA PRIVACY
            </span>

            <h1 class="text-5xl md:text-6xl font-extrabold text-slate-900 leading-tight mb-6">
                Privacy
                <span class="text-blue-600">Policy</span>
            </h1>

            <div class="h-1.5 w-20 bg-blue-600 rounded-full mx-auto mb-8"></div>

            <p class="text-lg text-slate-600 leading-8 max-w-3xl mx-auto">
                VendWise respects user privacy and aims to protect personal,
                business, transaction, and inventory information entered into the system.
            </p>

        </section>

        <!-- Privacy Content -->
        <section class="relative z-10 max-w-6xl mx-auto px-6 pb-20">

            <div class="grid lg:grid-cols-[320px_1fr] gap-8">

                <!-- Left Privacy Summary -->
                <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-[2rem] p-8 text-white shadow-xl h-fit">

                    <div class="h-16 w-16 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center text-3xl mb-6">
                        🔐
                    </div>

                    <h2 class="text-3xl font-extrabold mb-4">
                        Your Data Matters
                    </h2>

                    <p class="text-blue-100 leading-8">
                        VendWise uses authentication and role-based access so users can only
                        access their own business records while admin access remains limited
                        for management and support purposes.
                    </p>

                    <div class="mt-8 space-y-4">
                        <div class="flex items-center gap-3 bg-white/10 rounded-2xl p-4">
                            <span class="text-xl">✓</span>
                            <span class="font-semibold">Protected access</span>
                        </div>

                        <div class="flex items-center gap-3 bg-white/10 rounded-2xl p-4">
                            <span class="text-xl">✓</span>
                            <span class="font-semibold">User-based records</span>
                        </div>

                        <div class="flex items-center gap-3 bg-white/10 rounded-2xl p-4">
                            <span class="text-xl">✓</span>
                            <span class="font-semibold">Limited admin control</span>
                        </div>
                    </div>

                </div>

                <!-- Right Privacy Details -->
                <div class="space-y-5">

                    <!-- 01 -->
                    <div class="bg-white/90 backdrop-blur rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition p-6">
                        <div class="flex items-start gap-5">
                            <div class="h-14 w-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center font-extrabold">
                                01
                            </div>

                            <div>
                                <h3 class="text-xl font-extrabold text-slate-900 mb-2">
                                    Information Collected
                                </h3>

                                <p class="text-slate-600 leading-7">
                                    VendWise may collect user details such as name, email,
                                    business name, phone number, transaction records,
                                    inventory records, notifications, and support messages.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- 02 -->
                    <div class="bg-white/90 backdrop-blur rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition p-6">
                        <div class="flex items-start gap-5">
                            <div class="h-14 w-14 rounded-2xl bg-green-100 text-green-600 flex items-center justify-center font-extrabold">
                                02
                            </div>

                            <div>
                                <h3 class="text-xl font-extrabold text-slate-900 mb-2">
                                    How Information Is Used
                                </h3>

                                <p class="text-slate-600 leading-7">
                                    The information is used to provide financial tracking,
                                    inventory management, financial reports, notifications,
                                    support handling, and user account management.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- 03 -->
                    <div class="bg-white/90 backdrop-blur rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition p-6">
                        <div class="flex items-start gap-5">
                            <div class="h-14 w-14 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center font-extrabold">
                                03
                            </div>

                            <div>
                                <h3 class="text-xl font-extrabold text-slate-900 mb-2">
                                    Data Protection
                                </h3>

                                <p class="text-slate-600 leading-7">
                                    User data is protected through login authentication and
                                    role-based access control. Each vendor can only access
                                    their own business data and records.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- 04 -->
                    <div class="bg-white/90 backdrop-blur rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition p-6">
                        <div class="flex items-start gap-5">
                            <div class="h-14 w-14 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center font-extrabold">
                                04
                            </div>

                            <div>
                                <h3 class="text-xl font-extrabold text-slate-900 mb-2">
                                    Admin Access
                                </h3>

                                <p class="text-slate-600 leading-7">
                                    Administrators may access limited account information for
                                    support, user management, system monitoring, and system
                                    settings purposes.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- 05 -->
                    <div class="bg-white/90 backdrop-blur rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition p-6">
                        <div class="flex items-start gap-5">
                            <div class="h-14 w-14 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center font-extrabold">
                                05
                            </div>

                            <div>
                                <h3 class="text-xl font-extrabold text-slate-900 mb-2">
                                    User Responsibility
                                </h3>

                                <p class="text-slate-600 leading-7">
                                    Users are responsible for keeping their account login details
                                    secure and ensuring the information they enter into VendWise
                                    is accurate and appropriate.
                                </p>
                            </div>
                        </div>
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