<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracer Study STIKOM Bali</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #2b6cb0;
            --secondary-color: #4299e1;
        }
        
        body {
            background-color: #f8fafc;
            font-family: 'Segoe UI', sans-serif;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 1rem 0;
        }
        
        .navbar-brand {
            color: white !important;
        }
        
        .navbar-brand img {
            filter: brightness(0) invert(1);
            transition: transform 0.3s ease;
        }
        
        .navbar-brand:hover img {
            transform: scale(1.05);
        }
        
        .card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: none;
            border-radius: 12px;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .card-title {
            color: var(--primary-color);
            font-weight: 600;
        }
        
        footer {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }
        
        .stats-card {
            background: linear-gradient(135deg, #4299e1, #2b6cb0);
            color: white;
        }
        
        .stats-icon {
            background: rgba(255,255,255,0.2);
            padding: 1rem;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        canvas {
            max-height: 400px;
        }
        
        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }
        
        .text-gradient {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg shadow">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="STIKOM BALI" height="45">
                <div class="ms-3">
                    <span class="fw-bold fs-4">Tracer Study</span>
                    <p class="mb-0 small">STIKOM Bali</p>
                </div>
            </a>
        </div>
    </nav>

    @yield('content')

    <footer class="text-white py-4 mt-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <img src="{{ asset('images/logo.png') }}" alt="STIKOM BALI" height="40" class="mb-3 mb-md-0">
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0">&copy; {{ date('Y') }} STIKOM Bali. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>