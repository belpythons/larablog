<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Modern</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f5f6fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                url('https://source.unsplash.com/1600x600/?technology,web');
            height: 45vh;
            background-size: cover;
            background-position: center;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
        }

        .card:hover {
            transform: translateY(-6px);
            transition: 0.25s ease;
        }

        .tag {
            background: #0d6efd;
            color: white;
            padding: 3px 10px;
            border-radius: 50px;
            font-size: 12px;
        }

        footer {
            background: white;
            border-top: 1px solid #ddd;
            padding: 20px 0;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">MyBlog</a>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="{{ route('blog.index') }}">
                        <i class="bi bi-house-door me-1"></i> Home
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <section class="hero mb-5">
        <h1>Selamat Datang di Blog Modern</h1>
    </section>

    <div class="container pb-5">
        <div class="row">

            @foreach ($articles as $a)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">

                            <span class="tag">{{ $a['kategori'] }}</span>

                            <h5 class="mt-3">{{ $a['judul'] }}</h5>
                            <p class="text-muted">{{ $a['deskripsi'] }}</p>

                            <small class="text-secondary">
                                <i class="bi bi-calendar"></i> {{ $a['tanggal'] }}
                            </small>

                            <div class="mt-3">
                                <button class="btn btn-primary w-100">Baca Selengkapnya</button>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <footer class="text-center">
        <p class="text-muted mb-0">© 2025 Blog Modern — Dibuat dengan Laravel & Bootstrap</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>