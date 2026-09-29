@extends('layout.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4 text-primary fw-bold">Edit Profil</h3>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 text-center">
                                @if($user->avatar)
                                    <img src="{{ asset('uploads/avatars/' . $user->avatar) }}" alt="Avatar" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                    <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 150px; height: 150px;">
                                        <span class="text-white fs-1">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <small class="text-muted">Upload foto baru untuk mengganti avatar</small>
                                <div class="mb-3">
                                    <label for="avatar" class="form-label">Foto Profil</label>
                                    <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-semibold">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label fw-semibold">Telepon</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label fw-semibold">Alamat</label>
                                    <textarea class="form-control" id="address" name="address" rows="3">{{ $user->address }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 rounded-pill">Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
