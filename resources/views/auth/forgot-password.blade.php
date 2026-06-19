<x-guest-layout>

    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-100 flex items-center justify-center px-6 py-12">

        <div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-2">

            <!-- Left Side -->
            <div class="hidden lg:flex flex-col justify-center bg-gradient-to-br from-blue-600 to-indigo-700 p-14 text-white">

                <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center text-3xl mb-8">
                    🔐
                </div>

                <h1 class="text-5xl font-extrabold leading-tight">
                    Forgot Your Password?
                </h1>

                <p class="mt-6 text-lg text-blue-100 leading-relaxed">
                    Enter your registered email and VendWise will generate a reset password link for local FYP testing.
                </p>

                <div class="mt-10 space-y-5 text-blue-100">

                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-white"></div>
                        <span>Secure password reset process</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-white"></div>
                        <span>Local demo reset link preview</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-white"></div>
                        <span>Get back to managing your business</span>
                    </div>

                </div>

            </div>

            <!-- Right Side -->
            <div class="p-10 lg:p-14 flex flex-col justify-center">

                <div class="text-center">

                    <div class="mx-auto w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center text-3xl mb-6">
                        🔑
                    </div>

                    <h2 class="text-4xl font-extrabold text-slate-900">
                        Reset Password
                    </h2>

                    <p class="mt-4 text-slate-500">
                        Enter your registered email to generate a password reset link.
                    </p>

                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mt-6 rounded-2xl bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Demo Reset Link -->
                @if (session('reset_link'))
                    <div class="mt-5 rounded-2xl bg-blue-50 border border-blue-200 p-5">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center text-lg">
                                🔗
                            </div>

                            <div class="flex-1">
                                <h3 class="font-bold text-blue-800">
                                    Demo Reset Password Link
                                </h3>

                                <p class="mt-1 text-sm text-blue-700 leading-relaxed">
                                    This link is shown directly for VendWise local FYP testing. In a real system, this link will be sent through email.
                                </p>

                                <a href="{{ session('reset_link') }}"
                                   class="mt-4 inline-block w-full text-center rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition shadow">
                                    Open Reset Password Page
                                </a>

                                <p class="mt-3 text-xs text-blue-600 break-all">
                                    {{ session('reset_link') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="mt-8 space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" :value="__('Email Address')" />

                        <x-text-input
                            id="email"
                            class="block mt-2 w-full rounded-2xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autofocus
                        />

                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Button -->
                    <button type="submit"
                        class="w-full py-4 rounded-2xl bg-blue-600 text-white font-semibold text-lg hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                        Generate Reset Link
                    </button>

                </form>

                <!-- Back -->
                <div class="mt-8 text-center">
                    <a href="{{ route('login') }}"
                       class="text-sm font-semibold text-blue-600 hover:text-blue-700 transition">
                        ← Back to Login
                    </a>
                </div>

            </div>

        </div>

    </div>

</x-guest-layout>