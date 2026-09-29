<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::find($request->product_id);

        if (!$product->is_active) {
            return back()->with('error', 'Produk tidak tersedia');
        }

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        $cart = Session::get('user_cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
                'subtotal' => $product->price * $request->quantity
            ];
        }

        $cart[$product->id]['subtotal'] = $cart[$product->id]['price'] * $cart[$product->id]['quantity'];

        Session::put('user_cart', $cart);

        return redirect()->route('user.checkout')->with('success', 'Produk ditambahkan ke keranjang');
    }

    public function checkout()
    {
        $cart = Session::get('user_cart', []);

        if (empty($cart)) {
            return redirect('/')->with('error', 'Keranjang kosong');
        }

        $total = array_sum(array_column($cart, 'subtotal'));

        return view('user.checkout', compact('cart', 'total'));
    }

    public function processPayment(Request $request)
    {
        $cart = Session::get('user_cart', []);

        if (empty($cart)) {
            return redirect('/')->with('error', 'Keranjang kosong');
        }

        $total = array_sum(array_column($cart, 'subtotal'));

        if (!is_array($cart)) {
            return redirect('/')->with('error', 'Keranjang tidak valid');
        }

        // Create transaction
        $transaction = \App\Models\Transaction::create([
            'user_id' => auth()->id(),
            'total_amount' => $total,
            'paid_amount' => $total, // Assuming full payment
            'change_amount' => 0,
            'status' => 'completed',
            'payment_method' => 'cash', // or whatever payment method
            'completed_at' => now(),
        ]);

        // Create transaction details and update stock
        foreach ($cart as $item) {
            \App\Models\TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'subtotal' => $item['subtotal'],
            ]);

            // Update product stock
            $product = Product::find($item['id']);
            $product->decrement('stock', $item['quantity']);
        }

        // Clear cart
        Session::forget('user_cart');

        return redirect()->route('user.receipt', $transaction)->with('success', 'Pembayaran berhasil');
    }

    public function receipt(\App\Models\Transaction $transaction)
    {
        // Check if transaction belongs to current user
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        return view('user.receipt', compact('transaction'));
    }
}
