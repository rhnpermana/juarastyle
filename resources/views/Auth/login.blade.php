@extends('layout.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4 text-primary fw-bold">Login User</h3>

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   placeholder="Masukkan email kamu" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="Masukkan password" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 rounded-pill">Masuk</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
