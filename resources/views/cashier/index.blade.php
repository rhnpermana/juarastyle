@extends('layout.app')

@section('content')
<div class="row">
    <!-- Products Section -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Produk Tersedia</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($products as $product)
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h6 class="card-title">{{ $product->name }}</h6>
                                <p class="card-text text-muted small">{{ $product->description }}</p>
                                <p class="fw-bold text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <p class="text-muted">Stok: {{ $product->stock }}</p>
                                <form action="{{ route('cashier.add-to-cart') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="input-group input-group-sm mb-2">
                                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control" required>
                                        <button type="submit" class="btn btn-primary btn-sm" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                            Tambah
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Cart Section -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Keranjang</h5>
                @if(count($cart) > 0)
                <form action="{{ route('cashier.clear-cart') }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin mengosongkan keranjang?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Kosongkan</button>
                </form>
                @endif
            </div>
            <div class="card-body">
                @if(count($cart) > 0)
                <form action="{{ route('cashier.update-cart') }}" method="POST">
                    @csrf
                    @method('PUT')
                    @foreach($cart as $productId => $item)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <small class="fw-bold">{{ $item['name'] }}</small><br>
                            <small class="text-muted">Rp {{ number_format($item['price'], 0, ',', '.') }} x </small>
                            <input type="number" name="quantities[{{ $productId }}]" value="{{ $item['quantity'] }}" min="0" class="form-control form-control-sm d-inline-block" style="width: 60px;">
                        </div>
                        <div class="text-end">
                            <small class="fw-bold">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</small><br>
                            <form action="{{ route('cashier.remove-from-cart', $productId) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini dari keranjang?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total:</strong>
                        <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
                    </div>
                    <button type="submit" class="btn btn-warning btn-sm w-100 mt-2">Update Keranjang</button>
                </form>

                <!-- Checkout Form -->
                <form action="{{ route('cashier.checkout') }}" method="POST" class="mt-3" onsubmit="return confirm('Apakah Anda yakin ingin melanjutkan pembayaran?')">
                    @csrf
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Metode Pembayaran</label>
                        <select name="payment_method" id="payment_method" class="form-select" required>
                            <option value="cash">Tunai</option>
                            <option value="card">Kartu</option>
                            <option value="digital">Digital</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="paid_amount" class="form-label">Jumlah Dibayar</label>
                        <input type="number" name="paid_amount" id="paid_amount" class="form-control" min="{{ $total }}" step="1000" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Bayar</button>
                </form>
                @else
                <p class="text-muted text-center">Keranjang kosong</p>
                @endif
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success mt-3">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger mt-3">
    {{ session('error') }}
</div>
@endif

<script>
// Auto calculate change
document.getElementById('paid_amount').addEventListener('input', function() {
    const paid = parseFloat(this.value) || 0;
    const total = {{ $total }};
    const change = paid - total;
    // You can add change display here if needed
});
</script>
@endsection
