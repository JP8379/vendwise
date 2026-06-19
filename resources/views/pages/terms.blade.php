<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms & Conditions - VendWise</title>

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
                TERMS OF USE
            </span>

            <h1 class="text-5xl md:text-6xl font-extrabold text-slate-900 leading-tight mb-6">
                Terms &
                <span class="text-blue-600">Conditions</span>
            </h1>

            <div class="h-1.5 w-20 bg-blue-600 rounded-full mx-auto mb-8"></div>

            <p class="text-lg text-slate-600 leading-8 max-w-3xl mx-auto">
                These terms explain the basic responsibilities and acceptable use of VendWise
                as a financial tracking system for small business management.
            </p>

        </section>

        <!-- Terms Content -->
        <section class="relative z-10 max-w-6xl mx-auto px-6 pb-20">

            <div class="bg-white/90 backdrop-blur rounded-[2rem] border border-slate-200 shadow-sm p-8 md:p-10">

                <div class="grid lg:grid-cols-[280px_1fr] gap-10">

                    <!-- Left Summary -->
                    <div class="bg-blue-600 rounded-3xl p-7 text-white h-fit sticky top-8">
                        <div class="h-14 w-14 rounded-2xl bg-white/20 flex items-center justify-center text-3xl mb-5">
                            📄
                        </div>

                        <h2 class="text-2xl font-extrabold mb-3">
                            User Agreement
                        </h2>

                        <p class="text-blue-100 leading-7 text-sm">
                            By using VendWise, users agree to use the system responsibly for
                            recording business transactions, inventory, and financial reports.
                        </p>
                    </div>

                    <!-- Right Terms -->
                    <div class="space-y-5">

                        <div class="group rounded-3xl border border-slate-200 bg-slate-50 hover:bg-white hover:shadow-md transition p-6">
                            <div class="flex items-start gap-5">
                                <div class="h-12 w-12 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center font-extrabold">
                                    01
                                </div>

                                <div>
                                    <h3 class="text-xl font-extrabold text-slate-900 mb-2">
                                        User Responsibility
                                    </h3>

                                    <p class="text-slate-600 leading-7">
                                        Users are responsible for entering accurate business and financial
                                        information into the system. Any incorrect record may affect reports,
                                        summaries, and business insights.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="group rounded-3xl border border-slate-200 bg-slate-50 hover:bg-white hover:shadow-md transition p-6">
                            <div class="flex items-start gap-5">
                                <div class="h-12 w-12 rounded-2xl bg-green-100 text-green-600 flex items-center justify-center font-extrabold">
                                    02
                                </div>

                                <div>
                                    <h3 class="text-xl font-extrabold text-slate-900 mb-2">
                                        Account Security
                                    </h3>

                                    <p class="text-slate-600 leading-7">
                                        Users must keep their login credentials secure and should not share
                                        their account with unauthorized individuals. Each user is responsible
                                        for activities performed through their account.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="group rounded-3xl border border-slate-200 bg-slate-50 hover:bg-white hover:shadow-md transition p-6">
                            <div class="flex items-start gap-5">
                                <div class="h-12 w-12 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center font-extrabold">
                                    03
                                </div>

                                <div>
                                    <h3 class="text-xl font-extrabold text-slate-900 mb-2">
                                        System Usage
                                    </h3>

                                    <p class="text-slate-600 leading-7">
                                        VendWise should only be used for lawful business tracking and
                                        management purposes. Users should not misuse the system or attempt
                                        to access data that does not belong to them.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="group rounded-3xl border border-slate-200 bg-slate-50 hover:bg-white hover:shadow-md transition p-6">
                            <div class="flex items-start gap-5">
                                <div class="h-12 w-12 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center font-extrabold">
                                    04
                                </div>

                                <div>
                                    <h3 class="text-xl font-extrabold text-slate-900 mb-2">
                                        Financial Information
                                    </h3>

                                    <p class="text-slate-600 leading-7">
                                        VendWise provides financial summaries based on the records entered
                                        by users. Users should review important financial decisions carefully
                                        and verify records when needed.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="group rounded-3xl border border-slate-200 bg-slate-50 hover:bg-white hover:shadow-md transition p-6">
                            <div class="flex items-start gap-5">
                                <div class="h-12 w-12 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center font-extrabold">
                                    05
                                </div>

                                <div>
                                    <h3 class="text-xl font-extrabold text-slate-900 mb-2">
                                        Limitations
                                    </h3>

                                    <p class="text-slate-600 leading-7">
                                        VendWise is developed as a Final Year Project and is intended to
                                        support small business tracking. It is not a replacement for
                                        professional accounting, tax, or financial advice.
                                    </p>
                                </div>
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