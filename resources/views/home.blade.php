<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>VendWise</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800">

<!-- NAVBAR -->
<nav class="flex justify-between items-center px-10 py-4 bg-white shadow-sm">
    <div class="flex items-center space-x-2">
        <div class="bg-blue-600 text-white p-2 rounded">
            📊
        </div>
        <span class="font-bold text-lg">VENDWISE</span>
    </div>

    <div class="space-x-4">
        <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600">Login</a>
        <a href="{{ route('register') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
           Get Started
        </a>
    </div>
</nav>

<!-- HERO SECTION -->
<section class="text-center py-20 px-6">
    <h1 class="text-5xl font-bold mb-4">VENDWISE</h1>
    <p class="text-xl text-gray-600 mb-6">
        Simple Financial Control for Small Businesses
    </p>
    <p class="text-gray-500 max-w-2xl mx-auto mb-8">
        Take control of your business finances with our easy-to-use platform.
        Track transactions, manage inventory, and generate insights — all in one place.
    </p>

    <div class="space-x-4">
        <a href="{{ route('register') }}" 
           class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
           Get Started →
        </a>
        <a href="{{ route('login') }}" 
           class="border border-blue-600 text-blue-600 px-6 py-3 rounded-lg hover:bg-blue-50">
           Login
        </a>
    </div>
</section>

<!-- FEATURES -->
<section class="py-16 bg-white">
    <h2 class="text-3xl font-bold text-center mb-12">
        Everything You Need to Manage Your Business
    </h2>

    <div class="grid md:grid-cols-4 gap-8 px-10">
        <div class="bg-gray-50 p-6 rounded-lg shadow text-center">
            <h3 class="font-semibold mb-2">Transaction Tracking</h3>
            <p class="text-gray-600 text-sm">
                Record and monitor income, expenses, and sales in one place.
            </p>
        </div>

        <div class="bg-gray-50 p-6 rounded-lg shadow text-center">
            <h3 class="font-semibold mb-2">Financial Overview</h3>
            <p class="text-gray-600 text-sm">
                Get real-time insights with beautiful charts and analytics.
            </p>
        </div>

        <div class="bg-gray-50 p-6 rounded-lg shadow text-center">
            <h3 class="font-semibold mb-2">Inventory Management</h3>
            <p class="text-gray-600 text-sm">
                Keep track of products and stock levels effortlessly.
            </p>
        </div>

        <div class="bg-gray-50 p-6 rounded-lg shadow text-center">
            <h3 class="font-semibold mb-2">Profit & Loss Reports</h3>
            <p class="text-gray-600 text-sm">
                Generate detailed reports to understand performance.
            </p>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="py-20 text-center">
    <h2 class="text-3xl font-bold mb-12">How It Works</h2>

    <div class="grid md:grid-cols-3 gap-10 px-10">
        <div>
            <div class="bg-blue-600 text-white w-12 h-12 mx-auto rounded-full flex items-center justify-center mb-4">
                1
            </div>
            <h3 class="font-semibold">Create Account</h3>
            <p class="text-gray-600 text-sm">
                Sign up and set up your business profile.
            </p>
        </div>

        <div>
            <div class="bg-blue-600 text-white w-12 h-12 mx-auto rounded-full flex items-center justify-center mb-4">
                2
            </div>
            <h3 class="font-semibold">Add Transactions</h3>
            <p class="text-gray-600 text-sm">
                Record income, expenses, and sales easily.
            </p>
        </div>

        <div>
            <div class="bg-blue-600 text-white w-12 h-12 mx-auto rounded-full flex items-center justify-center mb-4">
                3
            </div>
            <h3 class="font-semibold">Track Performance</h3>
            <p class="text-gray-600 text-sm">
                Monitor business with real-time analytics.
            </p>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="bg-blue-600 text-white text-center py-16">
    <h2 class="text-3xl font-bold mb-4">Ready to Take Control?</h2>
    <p class="mb-6">Start managing your business finances today</p>

    <a href="{{ route('register') }}"
       class="bg-white text-blue-600 px-6 py-3 rounded-lg hover:bg-gray-100">
        Get Started Free
    </a>
</section>

<!-- FOOTER -->
<footer class="bg-black text-gray-400 text-center py-8">
    <div class="mb-2 font-semibold text-white">VENDWISE</div>
    <p class="text-sm">Simple Financial Control for Small Businesses</p>
    <p class="text-xs mt-4">© 2026 VendWise. All rights reserved.</p>
</footer>

</body>
</html>