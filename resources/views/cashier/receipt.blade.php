@extends('layout.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header text-center">
                <h4>Struk Pembayaran</h4>
                <small class="text-muted">{{ $transaction->transaction_number }}</small>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <h5>JuaraaStyle</h5>
                    <p class="mb-0">Jl. Letjend suparman.</p>
                    <p class="mb-0">Telp: (021) 1234567</p>
                </div>

                <hr>

                <div class="row mb-2">
                    <div class="col-6">Tanggal:</div>
                    <div class="col-6 text-end">{{ $transaction->created_at->format('d/m/Y H:i') }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">Kasir:</div>
                    <div class="col-6 text-end">{{ $transaction->user->name }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">Pembayaran:</div>
                    <div class="col-6 text-end">{{ ucfirst($transaction->payment_method) }}</div>
                </div>

                <hr>

                <div class="mb-3">
                    <strong>Detail Pembelian:</strong>
                    @foreach($transaction->transactionDetails as $detail)
                    <div class="row">
                        <div class="col-6">{{ $detail->product->name }}</div>
                        <div class="col-3 text-center">{{ $detail->quantity }} x</div>
                        <div class="col-3 text-end">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</div>
                    </div>
                    @endforeach
                </div>

                <hr>

                <div class="row">
                    <div class="col-6"><strong>Total:</strong></div>
                    <div class="col-6 text-end"><strong>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</strong></div>
                </div>
                <div class="row">
                    <div class="col-6">Dibayar:</div>
                    <div class="col-6 text-end">Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</div>
                </div>
                <div class="row">
                    <div class="col-6">Kembalian:</div>
                    <div class="col-6 text-end">Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</div>
                </div>

                <hr>

                <div class="text-center">
                    <p class="mb-0">Terima Kasih Atas Kunjungan Anda</p>
                    <small class="text-muted">Barang yang sudah dibeli tidak dapat dikembalikan</small>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('cashier.index') }}" class="btn btn-primary">Transaksi Baru</a>
                <a href="{{ route('cashier.history') }}" class="btn btn-outline-secondary">Riwayat Transaksi</a>
                <button onclick="window.print()" class="btn btn-outline-info">Cetak</button>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .card-footer {
        display: none;
    }
    .btn {
        display: none;
    }
}
</style>
@endsection
