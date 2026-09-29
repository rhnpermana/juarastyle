@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Riwayat Transaksi</h5>
    </div>
    <div class="card-body">
        @if($transactions->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No. Transaksi</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Pembayaran</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->transaction_number }}</td>
                        <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                        <td>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                        <td>{{ ucfirst($transaction->payment_method) }}</td>
                        <td>
                            <span class="badge bg-{{ $transaction->status === 'completed' ? 'success' : 'warning' }}">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('cashier.receipt', $transaction) }}" class="btn btn-sm btn-outline-primary">
                                Lihat
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $transactions->links() }}
        </div>
        @else
        <p class="text-muted text-center">Belum ada transaksi</p>
        @endif
    </div>
</div>
@endsection
