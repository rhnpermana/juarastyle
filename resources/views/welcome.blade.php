<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Shoping</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .hero {
  position: relative;
  z-index: 1;
}

.hero * {
  position: relative;
  z-index: 2;
}

.hero::before {
  position: absolute;
  content: "";
  inset: 0;
  z-index: 0;
}

.btn-accent, .btn-outline-secondary {
  position: relative;
  z-index: 5;
  pointer-events: auto;
}

    :root {
      --accent: #4f46e5;
      --accent-light: #6366f1;
      --dark: #0f172a;
      --text: #1e293b;
      --muted: #64748b;
      --radius: 16px;
    }

    body {
      font-family: 'Inter', system-ui, sans-serif;
      color: var(--text);
      scroll-behavior: smooth;
      background-color: #fff;
    }

    /* NAVBAR */
    .navbar {
      background: rgba(255, 255, 255, 0.8);
      backdrop-filter: blur(12px);
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
    }
    .navbar .nav-link {
      color: var(--text);
      font-weight: 500;
      transition: color 0.2s ease;
    }
    .navbar .nav-link:hover,
    .navbar .nav-link.active {
      color: var(--accent);
    }
    .navbar-brand {
      font-weight: 700;
      font-size: 1.4rem;
      color: var(--accent);
    }

    /* HERO */
    .hero {
      background: radial-gradient(circle at 20% 30%, rgba(79,70,229,0.15), rgba(79,70,229,0.02));
      min-height: 85vh;
      display: flex;
      align-items: center;
      position: relative;
      overflow: hidden;
    }
    .hero::before {
      content: "";
      position: absolute;
      inset: 0;
      background: url('https://www.transparenttextures.com/patterns/cubes.png');
      opacity: 0.05;
    }
    .hero h1 {
      font-weight: 800;
      color: var(--dark);
      font-size: 3rem;
      line-height: 1.2;
    }
    .hero p {
      color: var(--muted);
      font-size: 1.1rem;
    }
    .btn-accent {
      background: var(--accent);
      color: #fff;
      border: none;
      border-radius: var(--radius);
      padding: 0.75rem 1.6rem;
      transition: all 0.3s ease;
      font-weight: 600;
      box-shadow: 0 6px 14px rgba(79, 70, 229, 0.25);
    }
    .btn-accent:hover {
      background: var(--accent-light);
      transform: translateY(-3px);
    }
    .btn-outline-secondary {
      border-radius: var(--radius);
      font-weight: 600;
    }

    /* CARD PRODUK */
    .card {
      border: 0;
      border-radius: var(--radius);
      overflow: hidden;
      box-shadow: 0 10px 25px rgba(0,0,0,0.05);
      transition: all 0.35s ease;
    }
    .card:hover {
      transform: translateY(-6px);
      box-shadow: 0 14px 32px rgba(0,0,0,0.08);
    }
    .card-body {
      padding: 1.5rem;
    }

    /* TESTIMONIAL */
    .testimonial {
      background: linear-gradient(90deg, rgba(79,70,229,0.06), rgba(34,197,94,0.04));
      border-radius: var(--radius);
      padding: 1.75rem;
      box-shadow: 0 6px 20px rgba(0,0,0,0.04);
    }

    /* CTA */
    .cta {
      background: linear-gradient(135deg, var(--accent), var(--accent-light));
      color: #fff;
      border-radius: var(--radius);
      padding: 3rem 1rem;
    }
    .cta h4 {
      font-weight: 700;
    }
    .cta a {
      background: #fff;
      color: var(--accent);
      border-radius: var(--radius);
      font-weight: 600;
    }
    .cta a:hover {
      background: #f1f5f9;
    }

    /* FOOTER */
    footer {
      background: var(--dark);
      color: #94a3b8;
      padding: 3rem 0;
    }
    footer a {
      color: #cbd5e1;
      text-decoration: none;
      transition: color 0.3s ease;
    }
    footer a:hover {
      color: #fff;
    }

    @media (max-width: 992px) {
      .hero h1 {
        font-size: 2.3rem;
      }
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg fixed-top py-3">
  <div class="container">
    <a class="navbar-brand" href="/">JuaraaStyle</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navmenu">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item"><a class="nav-link active" href="/">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="#produk">Produk</a></li>
@auth
@if(auth()->user()->role === 'admin')
<li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Admin</a></li>
@endif
@if(auth()->user()->role === 'cashier')
<li class="nav-item"><a class="nav-link" href="{{ route('cashier.index') }}">Kasir</a></li>
@endif
<li class="nav-item"><a class="nav-link" href="{{ route('profile') }}">Profil</a></li>
<li class="nav-item dropdown ms-2">
  <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
    @if(auth()->user()->avatar)
      <img src="{{ asset('uploads/avatars/' . auth()->user()->avatar) }}" alt="Avatar" class="rounded-circle me-2" style="width:32px;height:32px;object-fit:cover;">
    @else
      <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-2" style="width:32px;height:32px;">
        <span class="text-white fw-bold" style="font-size:14px;">{{ substr(auth()->user()->name, 0, 1) }}</span>
      </div>
    @endif
    {{ auth()->user()->name }}
  </a>
  <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="{{ route('profile') }}">Profil</a></li>
    <li><hr class="dropdown-divider"></li>
    <li>
      <form action="{{ route('logout') }}" method="POST">@csrf
        <button type="submit" class="dropdown-item">Logout</button>
      </form>
    </li>
  </ul>
</li>
@else
<li class="nav-item ms-3">
  <a class="btn btn-accent text-white px-3" href="{{ route('login') }}">Masuk</a>
</li>
@endauth
      </ul>
    </div>
  </div>
</nav>

<!-- HERO -->
<header class="hero py-5 mt-5">
  <div class="container py-5">
    <div class="row align-items-center justify-content-between">
      <div class="col-lg-6 mb-5 mb-lg-0">
        <h1>JuaraaStyle <span class="text-primary">Shoping</span> Online Dengan Mudah</h1>
        <p class="lead mt-3">JuaraaStyle menyediakan semua pakaian keren</p>
        <div class="d-flex flex-wrap gap-3 mt-4">
          <a href="#produk" class="btn btn-accent btn-lg">Lihat Produk</a>
        </div>
      </div>
      <div class="col-lg-5 text-center">
        <img src="uploads/avatars/gemini.jpg"
             class="img-fluid rounded-4 shadow-lg" alt="Hero">
      </div>
    </div>
  </div>
</header>

<!-- PRODUK -->
<section id="produk" class="py-5 bg-light">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold">Produk</h2>
      <p class="text-muted">JuaraaStyle Battle In Style </p>
    </div>
    <div class="row g-4">
      @forelse($products ?? [] as $product)
      <div class="col-md-4">
        <div class="card h-100">
          @if($product->image)
            <img src="{{ asset('uploads/products/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
          @else
            <img src="https://images.unsplash.com/photo-1503602642458-232111445657?q=80&w=1200&auto=format&fit=crop" class="card-img-top" alt="produk" style="height: 200px; object-fit: cover;">
          @endif
          <div class="card-body">
            <h5 class="fw-semibold">{{ $product->name }}</h5>
            <p class="text-muted">{{ Str::limit($product->description, 50) }}</p>
            <div class="d-flex justify-content-between align-items-center mt-3">
              <strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong>
              <span class="badge bg-secondary">{{ ucfirst($product->category) }}</span>
            </div>
            <div class="mt-3">
              <form action="{{ route('add-to-cart') }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn btn-accent btn-sm w-100">Beli</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      @empty
      <div class="col-12">
        <div class="text-center text-muted">
          <p>Belum ada produk tersedia.</p>
        </div>
      </div>
      @endforelse
    </div>
  </div>
</section>

<!-- TESTIMONIAL -->

<!-- CTA -->

<!-- FOOTER -->
<footer>
  <div class="container text-center">
    <p class="mb-1">&copy; 2025 JuaraaStyle Battle In Style</p>
    <a href="#" class="me-3">Privasi</a>
    <a href="#">Syarat</a>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
