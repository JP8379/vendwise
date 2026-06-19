<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - VendWise</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-slate-800 bg-gradient-to-br from-blue-50 via-white to-slate-100">

    <div class="min-h-screen relative overflow-hidden">

        <!-- Background Effects -->
        <div class="absolute top-20 right-0 w-80 h-80 bg-blue-200/40 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 -left-24 w-80 h-80 bg-indigo-100/70 rounded-full blur-3xl"></div>

        <!-- Header -->
        <header class="relative z-10 bg-white/80 backdrop-blur border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="h-11 w-11 rounded-xl bg-blue-600 text-white flex items-center justify-center font-extrabold text-xl shadow-md">
                        V
                    </div>
                    <span class="text-2xl font-extrabold tracking-wide text-slate-900">VENDWISE</span>
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
                CONTACT INFORMATION
            </span>
            <h1 class="text-5xl md:text-6xl font-extrabold text-slate-900 leading-tight mb-6">
                Get in <span class="text-blue-600">Touch</span>
            </h1>
            <div class="h-1.5 w-20 bg-blue-600 rounded-full mx-auto mb-8"></div>
            <p class="text-lg text-slate-600 leading-8 max-w-3xl mx-auto">
                Need help, support, or more information about VendWise?
                Users can contact the system team or access support features through the dashboard.
            </p>
        </section>

        <!-- Main Contact Section -->
        <section class="relative z-10 max-w-7xl mx-auto px-6 pb-20">
            <div class="grid lg:grid-cols-2 gap-8">

                <!-- Contact Info -->
                <div class="bg-white/90 backdrop-blur rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">

                    <div class="bg-white p-8 border-b border-slate-100">
                        <div class="flex items-center gap-4 mb-5">
                            <div class="h-16 w-16 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-3xl">
                                📞
                            </div>
                            <div>
                                <h2 class="text-3xl font-extrabold text-slate-900">Contact Us</h2>
                                <p class="text-slate-500 mt-1">VendWise Support Information</p>
                            </div>
                        </div>
                        <p class="text-slate-600 leading-8">
                            For questions, support, feedback, or project-related inquiries,
                            users can reach the VendWise team through the following details.
                        </p>
                    </div>

                    <div class="p-8 space-y-5">

                        <!-- System Name -->
                        <div class="flex items-start gap-5 bg-blue-50 rounded-3xl p-5 border border-blue-100">
                            <div class="h-12 w-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-xl">
                                🖥️
                            </div>
                            <div>
                                <h3 class="font-extrabold text-slate-900 mb-1">System Name</h3>
                                <p class="text-slate-600">VendWise</p>
                            </div>
                        </div>

                        <!-- Email — updated to admin@vendwise.com -->
                        <div class="flex items-start gap-5 bg-green-50 rounded-3xl p-5 border border-green-100">
                            <div class="h-12 w-12 rounded-2xl bg-green-500 text-white flex items-center justify-center text-xl">
                                ✉️
                            </div>
                            <div>
                                <h3 class="font-extrabold text-slate-900 mb-1">Email Address</h3>
                                <a href="mailto:admin@vendwise.com"
                                   class="text-green-700 font-semibold hover:underline">
                                    admin@vendwise.com
                                </a>
                            </div>
                        </div>

                        <!-- Project Purpose -->
                        <div class="flex items-start gap-5 bg-purple-50 rounded-3xl p-5 border border-purple-100">
                            <div class="h-12 w-12 rounded-2xl bg-purple-500 text-white flex items-center justify-center text-xl">
                                🎯
                            </div>
                            <div>
                                <h3 class="font-extrabold text-slate-900 mb-1">Project Purpose</h3>
                                <p class="text-slate-600 leading-7">
                                    Financial tracking and inventory management
                                    system for small businesses and vendors.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Support Card — Login to Support button removed -->
                <div class="relative overflow-hidden rounded-[2rem] shadow-xl bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-700 text-white">

                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 w-72 h-72 bg-indigo-300/20 rounded-full blur-3xl"></div>

                    <div class="relative p-10 h-full flex flex-col justify-between">
                        <div>
                            <div class="h-20 w-20 rounded-3xl bg-white/20 backdrop-blur flex items-center justify-center text-5xl mb-8 shadow-lg">
                                💬
                            </div>
                            <h2 class="text-4xl font-extrabold mb-5 leading-tight">
                                Need Help <br>or Support?
                            </h2>
                            <p class="text-blue-100 leading-8 text-lg">
                                Registered users can access the VendWise dashboard
                                to submit support tickets, manage issues, and receive
                                assistance from the admin system.
                            </p>

                            <!-- Contact via email nudge -->
                            <div class="mt-8 flex items-center gap-3 bg-white/10 rounded-2xl px-5 py-4 border border-white/20">
                                <span class="text-2xl">✉️</span>
                                <div>
                                    <p class="text-sm text-blue-200 font-medium">Prefer email?</p>
                                    <a href="mailto:admin@vendwise.com"
                                       class="text-white font-bold hover:underline">
                                        admin@vendwise.com
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Only Create Account button remains -->
                        <div class="mt-10 flex flex-wrap gap-4">
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center justify-center px-7 py-4 rounded-2xl bg-white text-blue-700 font-extrabold shadow-lg hover:bg-slate-100 transition">
                                Create Account
                            </a>
                            <a href="{{ route('login') }}"
                               class="inline-flex items-center justify-center px-7 py-4 rounded-2xl border border-white/30 bg-white/10 backdrop-blur text-white font-bold hover:bg-white/20 transition">
                                Login
                            </a>
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
                <h2 class="text-xl font-extrabold text-slate-900">VENDWISE</h2>
                <p class="text-slate-500 mt-1">Simple Financial Control for Small Businesses.</p>
            </div>
        </footer>

    </div>
</body>
</html>