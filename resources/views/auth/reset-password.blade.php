<x-guest-layout>

    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-100 flex items-center justify-center px-6 py-12">

        <div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-2">

            <!-- Left Side -->
            <div class="hidden lg:flex flex-col justify-center bg-gradient-to-br from-blue-600 to-indigo-700 p-14 text-white">

                <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center text-3xl mb-8">
                    🔑
                </div>

                <h1 class="text-5xl font-extrabold leading-tight">
                    Create New Password
                </h1>

                <p class="mt-6 text-lg text-blue-100 leading-relaxed">
                    Set a new secure password for your VendWise account and continue managing your business safely.
                </p>

                <div class="mt-10 space-y-5 text-blue-100">

                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-white"></div>
                        <span>Use a strong password</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-white"></div>
                        <span>Confirm your new password</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-white"></div>
                        <span>Login again with updated details</span>
                    </div>

                </div>

            </div>

            <!-- Right Side -->
            <div class="p-10 lg:p-14 flex flex-col justify-center">

                <div class="text-center">

                    <div class="mx-auto w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center text-3xl mb-6">
                        🔐
                    </div>

                    <h2 class="text-4xl font-extrabold text-slate-900">
                        Reset Password
                    </h2>

                    <p class="mt-4 text-slate-500">
                        Enter your new password below to secure your VendWise account.
                    </p>

                </div>

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="mt-6 rounded-2xl bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.store') }}" class="mt-8 space-y-6">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" :value="__('Email Address')" />

                        <x-text-input
                            id="email"
                            class="block mt-2 w-full rounded-2xl border-slate-300 focus:border-blue-500 focus:ring-blue-500 bg-slate-50"
                            type="email"
                            name="email"
                            :value="old('email', $request->email)"
                            required
                            readonly
                        />

                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('New Password')" />

                        <x-text-input
                            id="password"
                            class="block mt-2 w-full rounded-2xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                            type="password"
                            name="password"
                            required
                            autofocus
                            autocomplete="new-password"
                            placeholder="Enter new password"
                        />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                        <x-text-input
                            id="password_confirmation"
                            class="block mt-2 w-full rounded-2xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Confirm new password"
                        />

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Button -->
                    <button type="submit"
                        class="w-full py-4 rounded-2xl bg-blue-600 text-white font-semibold text-lg hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                        Reset Password
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