<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function create()
    {
        if (empty(session('cart', []))) {
            return redirect()->route('cart.index')->with('error', 'سلتك فاضية.');
        }

        return view('checkout.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'shipping_address' => ['required', 'string', 'min:10', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^\+?[0-9\s\-]{7,20}$/'],
            'notes' => ['nullable', 'string', 'max:500'],
        ], [
            'shipping_address.required' => 'اكتبي عنوان التوصيل.',
            'shipping_address.min' => 'العنوان قصير، اكتبيه بالتفصيل.',
            'phone.required' => 'اكتبي رقم هاتف للتواصل.',
            'phone.regex' => 'اكتبي رقم هاتف صحيح.',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'سلتك فاضية.');
        }

        $order = DB::transaction(function () use ($cart, $data, $request) {
            // قفل صفوف المنتجات لمنع بيع نفس القطعة مرتين
            $products = Product::whereIn('id', array_keys($cart))
                ->where('is_active', true)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $total = 0;
            $lines = [];

            foreach ($cart as $productId => $quantity) {
                $product = $products->get($productId);

                if (! $product) {
                    throw ValidationException::withMessages([
                        'cart' => 'أحد المنتجات لم يعد متوفرًا. راجعي السلة.',
                    ]);
                }

                if ($quantity > $product->stock) {
                    throw ValidationException::withMessages([
                        'cart' => "الكمية المتوفرة من «{$product->name}» {$product->stock} فقط.",
                    ]);
                }

                // السعر الفعلي وقت الشراء (سعر الخصم إن وُجد)
                $unitPrice = $product->sale_price ?? $product->price;

                $lines[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'price' => $unitPrice,
                ];
                $total += $unitPrice * $quantity;
            }

            $order = Order::create([
                'user_id' => $request->user()->id,
                'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                'status' => 'pending',
                'total' => $total,
                'shipping_address' => $data['shipping_address'],
                'phone' => $data['phone'],
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($lines as $line) {
                $order->items()->create([
                    'product_id' => $line['product']->id,
                    'quantity' => $line['quantity'],
                    'price' => $line['price'],
                ]);

                $line['product']->decrement('stock', $line['quantity']);
            }

            return $order;
        });

        session()->forget('cart');

        return redirect()->route('checkout.success', $order->order_number);
    }

    public function success(Request $request, string $orderNumber)
    {
        $order = Order::with('items.product')
            ->where('order_number', $orderNumber)
            ->where('user_id', $request->user()->id) // الزبون يشوف طلباته بس
            ->firstOrFail();

        return view('checkout.success', compact('order'));
    }
}