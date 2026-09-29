<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CashierController extends Controller
{
    public function index()
    {
        $products = Product::active()->orderBy('name')->get();
        $cart = Session::get('cart', []);
        $total = $this->calculateTotal($cart);

        return view('cashier.index', compact('products', 'cart', 'total'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::find($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        $cart = Session::get('cart', []);

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

        Session::put('cart', $cart);

        return back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    public function removeFromCart($productId)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
        }

        return back()->with('success', 'Produk dihapus dari keranjang');
    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:0'
        ]);

        $cart = Session::get('cart', []);

        foreach ($request->quantities as $productId => $quantity) {
            if ($quantity <= 0) {
                unset($cart[$productId]);
            } else {
                $product = Product::find($productId);
                if ($product && $product->stock >= $quantity) {
                    $cart[$productId]['quantity'] = $quantity;
                    $cart[$productId]['subtotal'] = $product->price * $quantity;
                }
            }
        }

        Session::put('cart', $cart);

        return back()->with('success', 'Keranjang diperbarui');
    }

    public function clearCart()
    {
        Session::forget('cart');
        return back()->with('success', 'Keranjang dikosongkan');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,card,digital',
            'paid_amount' => 'required|numeric|min:0'
        ]);

        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang kosong');
        }

        $total = $this->calculateTotal($cart);

        if ($request->paid_amount < $total) {
            return back()->with('error', 'Jumlah pembayaran kurang');
        }

        DB::beginTransaction();

        try {
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'paid_amount' => $request->paid_amount,
                'change_amount' => $request->paid_amount - $total,
                'payment_method' => $request->payment_method,
                'status' => 'completed',
                'completed_at' => now()
            ]);

            foreach ($cart as $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'subtotal' => $item['subtotal']
                ]);

                // Update stock
                $product = Product::find($item['id']);
                $product->decrement('stock', $item['quantity']);
            }

            DB::commit();
            Session::forget('cart');

            return redirect()->route('cashier.receipt', $transaction->id)->with('success', 'Transaksi berhasil');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat memproses transaksi');
        }
    }

    public function receipt(Transaction $transaction)
    {
        $this->authorize('view', $transaction);

        return view('cashier.receipt', compact('transaction'));
    }

    public function history()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->completed()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('cashier.history', compact('transactions'));
    }

    private function calculateTotal($cart)
    {
        return array_sum(array_column($cart, 'subtotal'));
    }
}
