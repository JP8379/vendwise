<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - VENDWISE</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background: linear-gradient(160deg, #e8eeff 0%, #f1f5ff 50%, #f8faff 100%); min-height: 100vh;">
    <div class="flex min-h-screen">
        @include('admin.layouts.sidebar')

        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>
</body>
</html>