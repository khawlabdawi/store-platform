@extends('layouts.store')

@section('title', 'سلة المشتريات')

@section('content')

    <h1 class="mb-6 text-2xl font-bold">سلة المشتريات</h1>

    @if (count($items) === 0)
        <div class="rounded-xl bg-white p-10 text-center shadow-sm">
            <p class="mb-4 text-lg text-gray-500">سلتك فاضية.</p>
            <a href="{{ route('products.index') }}"
               class="inline-block rounded-lg bg-emerald-600 px-6 py-3 text-white">تصفّح المنتجات</a>
        </div>
    @else
        <div class="space-y-3">
            @foreach ($items as $item)
                <div class="flex flex-wrap items-center justify-between gap-4 rounded-xl bg-white p-4 shadow-sm">
                    <div>
                        <a href="{{ route('products.show', $item['product']) }}" class="font-semibold">
                            {{ $item['product']->name }}
                        </a>
                        <p class="text-sm text-gray-500">{{ number_format($item['unitPrice'], 2) }} للقطعة</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <form method="POST" action="{{ route('cart.update', $item['product']) }}" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                   min="1" max="{{ min(20, $item['product']->stock) }}"
                                   class="w-20 rounded-lg border-gray-300 text-center">
                            <button class="rounded-lg border px-3 py-2 text-sm">تحديث</button>
                        </form>

                        <p class="w-24 text-end font-bold text-emerald-700">{{ number_format($item['subtotal'], 2) }}</p>

                        <form method="POST" action="{{ route('cart.remove', $item['product']) }}">
                            @csrf
                            @method('DELETE')
                            <button class="rounded-lg px-3 py-2 text-sm text-red-600">حذف</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6 flex items-center justify-between rounded-xl bg-white p-4 shadow-sm">
            <span class="text-lg">المجموع:</span>
            <span class="text-2xl font-bold text-emerald-700">{{ number_format($total, 2) }}</span>
        </div>

        <p class="mt-4 text-sm text-gray-500">خطوة إتمام الطلب (الشراء) هي المرحلة الجاية.</p>
    @endif

@endsection