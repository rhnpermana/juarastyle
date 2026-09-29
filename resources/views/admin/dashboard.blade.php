@extends('layout.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Admin Dashboard</h1>

            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Users</h5>
                            <h2>{{ $totalUsers }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">Admin Users</h5>
                            <h2>{{ $adminUsers }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h5 class="card-title">Cashier Users</h5>
                            <h2>{{ $cashierUsers }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <h5 class="card-title">Regular Users</h5>
                            <h2>{{ $regularUsers }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mt-2">
                <div class="col-md-4">
                    <div class="card bg-secondary text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Products</h5>
                            <h2>{{ $totalProducts }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">Active Products</h5>
                            <h2>{{ $activeProducts }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Transactions</h5>
                            <h2>{{ $totalTransactions }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('admin.users') }}" class="btn btn-primary me-2">Kelola Users</a>
                <a href="{{ route('admin.products') }}" class="btn btn-success me-2">Kelola Produk</a>
                <a href="{{ route('cashier.index') }}" class="btn btn-info">Buka Kasir</a>
            </div>
        </div>
    </div>
</div>
@endsection
