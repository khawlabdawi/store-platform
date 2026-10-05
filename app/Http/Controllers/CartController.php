<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);

        $products = Product::whereIn('id', array_keys($cart))
            ->where('is_active', true)
            ->get()
            ->keyBy('id');

        $items = [];
        $total = 0;

        foreach ($cart as $productId => $quantity) {
            $product = $products->get($productId);

            if (! $product) {
                continue; // منتج انحذف أو انخفى
            }

            $quantity = min($quantity, $product->stock);
            $unitPrice = $product->sale_price ?? $product->price;
            $subtotal = $unitPrice * $quantity;

            $items[] = compact('product', 'quantity', 'unitPrice', 'subtotal');
            $total += $subtotal;
        }

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        abort_unless($product->is_active, 404);

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:20'],
        ]);

        $cart = session('cart', []);
        $newQuantity = ($cart[$product->id] ?? 0) + $data['quantity'];

        if ($newQuantity > $product->stock) {
            return back()->with('error', 'عذرًا، الكمية المتوفرة من هذا المنتج ' . $product->stock . ' فقط.');
        }

        $cart[$product->id] = $newQuantity;
        session(['cart' => $cart]);

        return back()->with('success', 'تمت إضافة المنتج إلى السلة.');
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:20'],
        ]);

        $cart = session('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id] = min($data['quantity'], $product->stock);
            session(['cart' => $cart]);
        }

        return back();
    }

    public function remove(Product $product)
    {
        $cart = session('cart', []);
        unset($cart[$product->id]);
        session(['cart' => $cart]);

        return back()->with('success', 'تم حذف المنتج من السلة.');
    }
}