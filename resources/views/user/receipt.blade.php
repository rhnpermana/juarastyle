@extends('layout.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h3 class="text-success fw-bold">✓ Pembayaran Berhasil!</h3>
                        <p class="text-muted">Terima kasih atas pembelian Anda</p>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Detail Transaksi</h5>
                            <p><strong>ID Transaksi:</strong> #{{ $transaction->id }}</p>
                            <p><strong>Tanggal:</strong> {{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Status:</strong> <span class="badge bg-success">{{ ucfirst($transaction->status) }}</span></p>
                            <p><strong>Metode Pembayaran:</strong> {{ ucfirst($transaction->payment_method) }}</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <h5>Informasi Pembeli</h5>
                            <p><strong>Nama:</strong> {{ $transaction->user->name }}</p>
                            <p><strong>Email:</strong> {{ $transaction->user->email }}</p>
                        </div>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaction->transactionDetails as $detail)
                                <tr>
                                    <td>{{ $detail->product->name }}</td>
                                    <td>Rp {{ number_format($detail->unit_price, 0, ',', '.') }}</td>
                                    <td>{{ $detail->quantity }}</td>
                                    <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="3" class="text-end">Total:</th>
                                    <th>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="text-center">
                        <a href="/" class="btn btn-primary me-2">Kembali Berbelanja</a>
                        <button onclick="window.print()" class="btn btn-outline-secondary">Cetak Struk</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .navbar, footer {
        display: none !important;
    }
    .container {
        max-width: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .card {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
    }
}
</style>
@endsection
