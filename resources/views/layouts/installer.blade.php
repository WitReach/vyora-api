<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vyora Setup Wizard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; background-color: #f9fafb; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-2xl shadow-xl border border-gray-100">
        <div class="text-center">
            <h2 class="text-3xl font-black text-gray-900 tracking-tight">Vyora Admin</h2>
            <p class="mt-2 text-sm text-gray-500 font-medium">@yield('subtitle', 'Installation Wizard')</p>
        </div>
        
        @yield('content')
        
    </div>
</body>
</html>
