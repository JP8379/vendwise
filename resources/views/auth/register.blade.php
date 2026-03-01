<x-guest-layout>
    <div class="w-full max-w-md bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
        <!-- Header -->
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-8 0h8M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2h-4l-2-2H9L7 5H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <div class="text-sm font-semibold tracking-wide text-slate-900">{{ strtoupper(config('app.name', 'VENDWISE')) }}</div>
            </div>
        </div>

        <h1 class="mt-6 text-2xl font-bold text-slate-900">Create Account</h1>
        <p class="mt-1 text-sm text-slate-500">Fill in your details to get started</p>

        <!-- Errors -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <x-input-error :messages="$errors->all()" class="mt-4" />

        <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
            @csrf

            <!-- Full Name -->
            <div>
                <x-input-label for="name" value="Full Name" />
                <x-text-input id="name" class="mt-1 block w-full"
                              type="text" name="name" :value="old('name')"
                              required autofocus autocomplete="name"
                              placeholder="John Doe" />
            </div>

            <!-- Business Name -->
            <div>
                <x-input-label for="business_name" value="Business Name" />
                <x-text-input id="business_name" class="mt-1 block w-full"
                              type="text" name="business_name" :value="old('business_name')"
                              required autocomplete="organization"
                              placeholder="Your Business Name" />
            </div>

            <!-- Email -->
            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" class="mt-1 block w-full"
                              type="email" name="email" :value="old('email')"
                              required autocomplete="username"
                              placeholder="john@example.com" />
            </div>

            <!-- Phone Number -->
            <div>
                <x-input-label for="phone_number" value="Phone Number" />
                <x-text-input id="phone_number" class="mt-1 block w-full"
                              type="text" name="phone_number" :value="old('phone_number')"
                              required autocomplete="tel"
                              placeholder="+60 12-345 6789" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" value="Password" />
                <x-text-input id="password" class="mt-1 block w-full"
                              type="password" name="password"
                              required autocomplete="new-password"
                              placeholder="••••••••" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" value="Confirm Password" />
                <x-text-input id="password_confirmation" class="mt-1 block w-full"
                              type="password" name="password_confirmation"
                              required autocomplete="new-password"
                              placeholder="••••••••" />
            </div>

            <button
                type="submit"
                class="mt-2 w-full inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Create Account
            </button>

            <p class="text-center text-sm text-slate-600 pt-2">
                Already have an account?
                <a class="text-blue-700 font-semibold hover:underline" href="{{ route('login') }}">
                    Login here
                </a>
            </p>
        </form>
    </div>
</x-guest-layout>