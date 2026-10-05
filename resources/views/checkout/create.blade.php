@extends('layouts.store')

@section('title', 'إتمام الطلب')

@section('content')

    <h1 class="mb-6 text-2xl font-bold">إتمام الطلب</h1>

    <form method="POST" action="{{ route('checkout.store') }}"
          class="max-w-xl space-y-4 rounded-xl bg-white p-6 shadow-sm">
        @csrf

        <div>
            <label for="shipping_address" class="mb-1 block font-semibold">عنوان التوصيل</label>
            <textarea id="shipping_address" name="shipping_address" rows="3" required
                      class="w-full rounded-lg border-gray-300"
                      placeholder="المدينة، الحي، الشارع، رقم البناء">{{ old('shipping_address') }}</textarea>
            @error('shipping_address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="phone" class="mb-1 block font-semibold">رقم الهاتف</label>
            <input id="phone" name="phone" type="tel" required value="{{ old('phone') }}"
                   class="w-full rounded-lg border-gray-300" placeholder="09xxxxxxxx">
            @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="notes" class="mb-1 block font-semibold">ملاحظات (اختياري)</label>
            <textarea id="notes" name="notes" rows="2"
                      class="w-full rounded-lg border-gray-300">{{ old('notes') }}</textarea>
        </div>

        @error('cart') <p class="rounded-lg bg-red-100 p-3 text-red-800">{{ $message }}</p> @enderror

        <div class="rounded-lg bg-emerald-50 p-3 text-emerald-800">
            طريقة الدفع: <strong>الدفع عند الاستلام</strong>
        </div>

        <button class="w-full rounded-lg bg-emerald-600 px-6 py-3 text-lg font-semibold text-white">
            تأكيد الطلب
        </button>
    </form>

@endsection