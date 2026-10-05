<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'متجري')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <header class="bg-white shadow-sm">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 p-4">
            <a href="{{ route('home') }}" class="text-xl font-bold text-emerald-700">متجري</a>

            <form action="{{ route('products.index') }}" method="GET" class="flex flex-1 max-w-md gap-2">
                <input type="search" name="q" value="{{ request('q') }}"
                       placeholder="ابحث عن منتج..."
                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-base">
                <button class="rounded-lg bg-emerald-600 px-4 py-2 text-white">بحث</button>
            </form>
        </div>
    </header>

    <main class="mx-auto max-w-6xl p-4">
        @yield('content')
    </main>

    <footer class="mt-12 border-t bg-white p-6 text-center text-sm text-gray-500">
        © {{ date('Y') }} متجري. جميع الحقوق محفوظة.
    </footer>

</body>
</html>