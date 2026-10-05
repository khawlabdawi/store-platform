@extends('layouts.app')

@section('title', $product->name)

@section('content')

    <a href="{{ route('products.index') }}" class="mb-4 inline-block text-emerald-700">← رجوع للمنتجات</a>

    <div class="grid gap-8 rounded-xl bg-white p-6 shadow-sm md:grid-cols-2">
        <div class="flex h-72 items-center justify-center rounded-lg bg-gray-100 text-gray-400">
            @if ($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                     class="h-full w-full rounded-lg object-cover">
            @else
                لا توجد صورة
            @endif
        </div>

        <div>
            <p class="text-sm text-gray-500">{{ $product->category->name }}</p>
            <h1 class="mb-3 text-2xl font-bold">{{ $product->name }}</h1>

            @if ($averageRating)
                <p class="mb-3 text-amber-600">
                    ★ {{ number_format($averageRating, 1) }}
                    <span class="text-sm text-gray-500">({{ $reviews->count() }} تقييم)</span>
                </p>
            @endif

            <div class="mb-4 text-2xl">
                @if ($product->sale_price)
                    <span class="font-bold text-emerald-700">{{ number_format($product->sale_price, 2) }}</span>
                    <span class="text-base text-gray-400 line-through">{{ number_format($product->price, 2) }}</span>
                @else
                    <span class="font-bold text-emerald-700">{{ number_format($product->price, 2) }}</span>
                @endif
            </div>

            <p class="mb-6 leading-relaxed text-gray-600">{{ $product->description }}</p>

            @if ($product->stock > 0)
                <p class="mb-4 text-sm text-emerald-700">متوفر ({{ $product->stock }} قطعة)</p>
                <button disabled class="w-full rounded-lg bg-emerald-600 px-6 py-3 text-lg text-white opacity-60">
                    أضف إلى السلة (قريبًا)
                </button>
            @else
                <p class="text-red-600">نفدت الكمية</p>
            @endif
        </div>
    </div>

    <section class="mt-8">
        <h2 class="mb-4 text-xl font-bold">التقييمات</h2>

        @forelse ($reviews as $review)
            <div class="mb-3 rounded-lg bg-white p-4 shadow-sm">
                <p class="font-semibold">{{ $review->user->name }}
                    <span class="text-amber-600">{{ str_repeat('★', $review->rating) }}</span>
                </p>
                @if ($review->comment)
                    <p class="mt-1 text-gray-600">{{ $review->comment }}</p>
                @endif
            </div>
        @empty
            <p class="text-gray-500">ما في تقييمات بعد.</p>
        @endforelse
    </section>

@endsection