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
            <nav class="flex items-center gap-3 text-sm">
    @auth
        <a href="{{ route('profile.edit') }}" class="text-gray-700">{{ auth()->user()->name }}</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="rounded-lg border px-3 py-2">تسجيل الخروج</button>
        </form>
    @else
        <a href="{{ route('login') }}" class="px-3 py-2">دخول</a>
        <a href="{{ route('register') }}" class="rounded-lg bg-emerald-600 px-3 py-2 text-white">حساب جديد</a>
    @endauth
</nav>
        </div>
        <a href="{{ route('cart.index') }}" class="rounded-lg border px-3 py-2">
    🛒 السلة ({{ collect(session('cart', []))->sum() }})
</a>
    </header>

    <main class="mx-auto max-w-6xl p-4">



        @if (session('success'))
    <div class="mb-4 rounded-lg bg-emerald-100 p-3 text-emerald-800">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="mb-4 rounded-lg bg-red-100 p-3 text-red-800">{{ session('error') }}</div>
@endif
@if ($errors->any())
    <div class="mb-4 rounded-lg bg-red-100 p-3 text-red-800">{{ $errors->first() }}</div>
@endif
        @yield('content')

    </main>

    <footer class="mt-12 border-t bg-white p-6 text-center text-sm text-gray-500">
        © {{ date('Y') }} متجري. جميع الحقوق محفوظة.
    </footer>

</body>
</html>