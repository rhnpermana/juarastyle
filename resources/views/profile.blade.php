@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">

                    <h2 class="text-center fw-bold text-primary mb-4">👤 Profil Kamu</h2>

                    {{-- Notifikasi sukses --}}
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- Foto Profil --}}
                    <div class="text-center mb-4">
                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://via.placeholder.com/150' }}"
                             alt="Avatar" class="rounded-circle shadow" width="150" height="150">
                    </div>

                    {{-- Form Update Profil --}}
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nomor HP</label>
                            <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Alamat</label>
                            <textarea name="address" class="form-control" rows="3">{{ $user->address }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Ganti Foto Profil</label>
                            <input type="file" name="avatar" class="form-control">
                            <small class="text-muted">Format: JPG, PNG, maksimal 2MB</small>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold">
                                💾 Simpan Perubahan
                            </button>
                        </div>
                    </form>

                    {{-- Tombol Logout --}}
                    <form action="{{ route('logout') }}" method="POST" class="text-center mt-4">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger rounded-pill px-4 fw-semibold">
                            🚪 Keluar
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
