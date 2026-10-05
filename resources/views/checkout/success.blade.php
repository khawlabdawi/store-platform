@extends('layouts.store')

@section('title', 'تم استلام طلبك')

@section('content')

    <div class="mx-auto max-w-xl rounded-xl bg-white p-8 text-center shadow-sm">
        <p class="mb-2 text-4xl">✅</p>
        <h1 class="mb-2 text-2xl font-bold">شكرًا لك! تم استلام طلبك</h1>
        <p class="mb-4 text-gray-600">رقم طلبك: <strong>{{ $order->order_number }}</strong></p>

        <div class="mb-4 space-y-1 text-start">
            @foreach ($order->items as $item)
                <p>{{ $item->product->name }} × {{ $item->quantity }}
                    <span class="text-gray-500">({{ number_format($item->price * $item->quantity, 2) }})</span>
                </p>
            @endforeach
        </div>

        <p class="mb-6 text-xl font-bold text-emerald-700">المجموع: {{ number_format($order->total, 2) }}</p>
        <p class="mb-6 text-sm text-gray-500">الدفع عند الاستلام. سنتواصل معك على رقم {{ $order->phone }}.</p>

        <a href="{{ route('products.index') }}" class="rounded-lg bg-emerald-600 px-6 py-3 text-white">متابعة التسوق</a>
    </div>

@endsection