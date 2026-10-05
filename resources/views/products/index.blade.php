@extends('layouts.app')

@section('title', 'المنتجات')

@section('content')

    {{-- فلتر التصنيفات --}}
    <nav class="mb-6 flex flex-wrap gap-2">
        <a href="{{ route('products.index') }}"
           class="rounded-full px-4 py-2 text-sm {{ request('category') ? 'bg-white border' : 'bg-emerald-600 text-white' }}">
            الكل
        </a>
        @foreach ($categories as $category)
            <a href="{{ route('products.index', ['category' => $category->slug]) }}"
               class="rounded-full px-4 py-2 text-sm {{ request('category') === $category->slug ? 'bg-emerald-600 text-white' : 'bg-white border' }}">
                {{ $category->name }}
            </a>
        @endforeach
    </nav>

    @if ($products->isEmpty())
        <p class="py-12 text-center text-lg text-gray-500">ما لقينا منتجات مطابقة. جرّبي كلمة ثانية.</p>
    @else
        <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
            @foreach ($products as $product)
                <a href="{{ route('products.show', $product) }}"
                   class="block rounded-xl bg-white p-3 shadow-sm transition hover:shadow-md">
                    <div class="mb-3 flex h-40 items-center justify-center rounded-lg bg-gray-100 text-gray-400">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                 class="h-full w-full rounded-lg object-cover">
                        @else
                            لا توجد صورة
                        @endif
                    </div>

                    <p class="text-xs text-gray-500">{{ $product->category->name }}</p>
                    <h2 class="font-semibold">{{ $product->name }}</h2>

                    <div class="mt-2">
                        @if ($product->sale_price)
                            <span class="font-bold text-emerald-700">{{ number_format($product->sale_price, 2) }}</span>
                            <span class="text-sm text-gray-400 line-through">{{ number_format($product->price, 2) }}</span>
                        @else
                            <span class="font-bold text-emerald-700">{{ number_format($product->price, 2) }}</span>
                        @endif
                    </div>

                    @if ($product->stock < 1)
                        <p class="mt-1 text-sm text-red-600">نفدت الكمية</p>
                    @endif
                </a>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @endif

@endsection